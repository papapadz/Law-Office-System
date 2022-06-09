<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Query;
use Auth;
use Illuminate\Mail\Mailer;
use App\Mail\NotifMail;
use App\Mail\FeedbackMail;
use Alert;
use App\CalendarEvent;
use App\Message;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_PeopleService;
use Google_Service_Calendar_Event;
use Spatie\GoogleCalendar\Event;
use Carbon;
use Illuminate\Support\HtmlString;
use App\User;

class LawyerController extends Controller
{
    //
    public function LawyerQuery($id)
    {
        $queries = Query::where('transaction_number', $id)->get();
        /** check if there is a query with the given ID */
        if($queries) {
            $event_check = CalendarEvent::where('query_id', $queries[0]->id)->with('queries')->first();
        
            return view('lawyer.accept', compact('queries', 'event_check'));
        } else //if no query, return to previous page
            return redirect()->back()->with('error','No Record Found');
        
    }

    public function CreateEvent($pstart_date, $pend_date, $resolution_type, $lawyer_email, $client_email)
    {
        $client = $this->GetToken();

        // $client = getClient();
        
        $service = new Google_Service_Calendar($client);


        $event = new Google_Service_Calendar_Event(array(
          'summary' => 'OnCon Online Consultation',
          // 'location' => '800 Howard St., San Francisco, CA 94103',
          'description' => $resolution_type,
          'start' => array(
            'dateTime' => $pstart_date,
            'timeZone' => 'Asia/Singapore',
        ),
          'end' => array(
            'dateTime' => $pend_date,
            'timeZone' => 'Asia/Singapore',
        ),
          'attendees' => array(
            array('email' => $lawyer_email),
            array('email' => $client_email),
        ),
          'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
              array('method' => 'email', 'minutes' => 24 * 60),
              array('method' => 'popup', 'minutes' => 10),
          ),
        ),
          'conferenceData' => [
            'createRequest' => [
                'requestId' => 'randomString'.time()
            ]
        ]
    ));

        $calendarId = 'oncon.capstone@gmail.com';

        $event = $service->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

        return $event;
        // printf('Event created: %s\n', $ event->htmlLink);
    }

    public function GetToken()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = 'token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
        // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

        // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

        // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
        // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;

    }

    public function AcceptOnlineQuery(Request $request)
    {
        $queries = Query::where('transaction_number', $request->transaction_number)->with('lawyer', 'client')->first();

        if($request->input('action') == 'accept')
        {

            $schedule = explode('--', $request->schedule);
            $schedule_date = $schedule[0];
            $schedule_time = $schedule[1];

            // $request->validate([
            //     'schedule_date' => 'required',
            //     'schedule_time' => 'required',
            // ]);

            $start_date = Carbon\Carbon::parse($schedule_date ."". $schedule_time)->format('Y-m-d H:i+08:00');

            $end_date = Carbon\Carbon::parse($schedule_date ."". $schedule_time)->addHour(2)->format('Y-m-d H:i+08:00');

            $pstart_date = Carbon\Carbon::parse($start_date);
            $pend_date = Carbon\Carbon::parse($end_date);
            $resolution_type = $queries->resolution_type;
            $lawyer_email = $queries->lawyer->email;
            $client_email = $queries->client->email;

            $event = $this->CreateEvent($pstart_date, $pend_date, $resolution_type, $lawyer_email, $client_email);

            $queries = Query::where('transaction_number', $request->transaction_number)->first();
            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $to = $queries->email;
            $toname = $queries->email;
            $schedule_date = $schedule_date;
            $schedule_time = $schedule_time;
            $scheduled_date = $schedule_date . " " . $schedule_time;
            $subject = "Query Scheduled";

            $queries->schedule_date = $schedule_date;
            $queries->schedule_time = $schedule_time;
            $queries->lawyer_id = auth()->user()->id;
            $queries->status = 'In-Progress';
            $queries->save();

            $calendar = new CalendarEvent();
            $calendar->query_id = $queries->id;
            $calendar->meeting_link = $event->hangoutLink;
            $calendar->start_time = $pstart_date;
            $calendar->end_time = $pend_date;
            $calendar->save();


            $details = [
                'title' => $queries->category . ' Notification',
                'body' => 'Your query for '.$queries->resolution_type.' was scheduled at ' .$scheduled_date. '<br><br>This is regarding your sent query: '. $queries->question,
                'ReferenceNumber' => $queries->transaction_number

            ];

            \Mail::to($to)->send(new NotifMail($details));


            toast()->success('Success', 'Query accepted successfully')->position('top-end');


        }elseif($request->input('action') == 'decline')
        {

            $queries = Query::where('transaction_number', $request->transaction_number)->first();
            $declineIDs['declined_id'] = $queries->lawyer->id;
            $queries->declined_id = $declineIDs;
            $queries->lawyer_id = $this->getLawyer(request()->subject);
            $queries->status = 'Pending';
            $queries->save();

            $details = [
                'title' => 'You Have a New Assigned Query',
                'ReferenceNumber' => $request->transaction_number,
                'body' => 'Please check your OnCon account as we have assigned you a new query.' 
            ];

            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $subject = 'You Have New Assigned Query';

            $to = $queries->lawyer->email;

            \Mail::to($to)->send(new NotifMail($details));

            toast()->success('Success', 'Query declined successfully')->position('top-end');


        }elseif($request->input('action') == 'complete')
        {

            $queries = Query::where('transaction_number', $request->transaction_number)->first();
            $queries->status = 'Complete';
            $queries->summary_from_lawyer = $request->summary;
            $queries->save();

            $details = [
                'title' => 'Complete Transaction',
                'ReferenceNumber' => $request->transaction_number,
                'body' => 'A summary of your consultation was submitted: ' .$request->summary. ' .Please visit your account for more details. ' 
            ];

            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $subject = 'You Have New Assigned Query';

            $to = $queries->client->email;

            \Mail::to($to)->send(new NotifMail($details));
            toast()->success('Success', 'Query complete successfully')->position('top-end');

        }elseif($request->input('action') == 'send')
        {
            $request->validate([
                'body' => 'required|string'
            ]);

            if(request()->attach_file != NULL)
            {
                $request->validate([
                    'attach_file' => 'required|mimes:pdf,docx,jpg,bmp,png' /** restrict file uploads to PDF, Word document and Images */
                ]);
                 $attached_file = request()->file('attach_file')->storeOnCloudinary('attach_files/')->getSecurePath();
            }
            else
            {
                $attached_file =null;
            }
            
            

            $queries = Query::where('transaction_number', $request->transaction_number)->with('lawyer')->first();
            $queries = Query::where('transaction_number', $request->transaction_number)->first();
            $queries->reply_to_written_resolution = $request->body;
            $queries->status = 'Complete';
            $queries->attached_file = $attached_file;
            $queries->save();
            
            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $to = $queries->email;
            $toname = $queries->email;

            if(request()->file('attach_file') == null)
            {
                

                $details = [
                    'title' =>'Written Resolution Reply',
                    'from' => 'Atty. '.$queries->lawyer->first_name.' ' .$queries->lawyer->last_name,
                    'transactionNumber' => $request->transaction_number,
                    'body' => $request->body
                ];
                \Mail::to($to)->send(new FeedbackMail($details)); 
            }
            else
            {
                $request->validate([
                    'attach_file' => 'required|mimes:pdf,docx,jpg,bmp,png' /** restrict file uploads to PDF, Word document and Images */
                ]);
                $attached_file = request()->file('attach_file')->storeOnCloudinary('attach_files/')->getSecurePath();

                $details = [
                    'title' =>'Written Resolution Reply',
                    'from' => 'Atty. ' .$queries->lawyer->first_name.' ' .$queries->lawyer->last_name,
                    'transactionNumber' => $request->transaction_number,
                    'body' => $request->body,
                    'attach_file' => $attached_file  
            ];               
            \Mail::to($to)->send(new FeedbackMail($details));
        }

        toast()->success('Success', 'Message sent successfully')->position('top-end');
    }
        elseif($request->input('action') == 'acceptOffline')
        {
            $schedule = explode('--', $request->schedule);
            $schedule_date = $schedule[0];
            $schedule_time = $schedule[1];


            $request->validate([
                'reply_offline' => 'required|string'
            ]);

            $queries = Query::where('transaction_number', $request->transaction_number)->first();
            $queries->status ='Approved';
            $queries->schedule_date = $schedule_date;
            $queries->schedule_time = $schedule_time;
            $queries->reply_offline = request()->reply_offline;
            $queries->save();
            

            $scheduled_date = Carbon\Carbon::parse($queries->schedule_date)->isoFormat('MMM Do YYYY');

            $details = [
                'title' => $queries->category . ' Notification',
                'body' => 'Your reservation for Atty. '.$queries->lawyer->last_name.' was accepted. Please be reminded that your schedule is at ' .$scheduled_date. ' -- '.$schedule_time. ' This is regarding your sent query: '. $queries->question,
                'ReferenceNumber' => $queries->transaction_number

            ];

            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $to = $queries->email;
            $toname = $queries->email;


            \Mail::to($to)->send(new NotifMail($details));


            toast()->success('Success', 'Query accepted successfully')->position('top-end');
        }
        elseif($request->input('action') == 'declineOffline')
        {
            $queries = Query::where('transaction_number', $request->transaction_number)->first();
            $queries->status ='Declined';
            $queries->save();

            $details = [
                'title' => $queries->category . ' Notification',
                'body' => 'Your reservation for Atty. '.$queries->lawyer->last_name.' was declined. This is regarding your sent query: '. $queries->question. ' You may send another offline query. You may try changing your schedule or lawyer of your choice. We hope to hear from you soon.',
                'ReferenceNumber' => $queries->transaction_number

            ];

            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $to = $queries->email;
            $toname = $queries->email;

            \Mail::to($to)->send(new NotifMail($details));


            toast()->success('Success', 'Query accepted successfully')->position('top-end');
        }
    return redirect()->route('user.queries');

    }

    public function SaveBankSetting(Request $request)
    {

    }

    public function getLawyer($subject)
    {

        $users = User::where('role_id', 2)->where('is_verified', 1)->where('availability', '!=', 'Offline')->get();

        foreach($users as $user)
        {
            $availableSubject = $users->pluck('specialization');
            $availSub = explode('-', $availableSubject);


            if(strpos($availableSubject, $subject) !== false)
            {

                $lawyers = User::where('role_id', 2)
                ->where('specialization', 'LIKE', '%'.$subject.'%' )
                ->where('availability', '!=', 'Offline')
                ->get();

                foreach($lawyers as $lawyer) 
                {
                    $query_count = $lawyers->pluck('totalAssigned'); 

                    if($query_count === [0]) 
                    {
                        $assigned = collect($lawyers)->sortBy('created_at')->first(); 
                    }
                    elseif($query_count >= [1] ) 
                    {
                        $assigned = $lawyers->sortBy('date_of_last_query')->first(); 
                    }
                    else 
                    {

                        $filtered = $lawyers->filter(function($value, $key) 
                        {
                            return $value['date_of_last_query'] == NULL; 
                        });

                        $assigned = collect($filtered)->sortBy('created_at')->first(); 
                    }
                    return $assigned->id; 
                }
            }
            else
            {
                
                $lawyers = User::where('role_id', 2)
                ->where('specialization', 'LIKE', '%General%' )
                ->where('availability', '!=', 'Offline')
                ->get();

                foreach($lawyers as $lawyer) 
                {
                    $query_count = $lawyers->pluck('totalAssigned'); 

                    if($query_count === [0]) 
                    {
                        $assigned = collect($lawyers)->sortBy('created_at')->first(); 
                    }
                    elseif($query_count >= [1] ) 
                    {
                        $assigned = $lawyers->sortBy('date_of_last_query')->first(); 
                    }
                    else 
                    {

                        $filtered = $lawyers->filter(function($value, $key) 
                        {
                            return $value['date_of_last_query'] == NULL; 
                        });

                        $assigned = collect($filtered)->sortBy('created_at')->first(); 
                    }

                    return $assigned->id; 
                }
            }
        }
    }
}
