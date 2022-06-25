<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Alert;
use App\User;
use Spatie\GoogleCalendar\Event;
use Carbon;
use App\Query;
use App\Feedback;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_PeopleService;
use Google_Service_Calendar_Event;
use App\CalendarEvent;
use App\Payment;
use App\Rules\MatchOldPassword;
use App\Specialization;
use App\LawyerSpecialization;
use App\Mail\NotifMail;

class ProfileController extends Controller
{
    //

    public function profile()
    {
        $query_count = Query::where('lawyer_id', auth()->user()->id)->count();

        $query_count_billing = Query::where('lawyer_id', auth()->user()->id)->where('status', 'complete')->count();

        return view('profile.index', compact('query_count', 'query_count_billing'));
    }

    public function UpdateProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'contact_number' => 'required|numeric|digits:11',
        ]);


        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->contact_number = $request->contact_number;
        $user->save();

        toast()->success('Success', 'Profile updated successfully')->position('top-end');
        return redirect()->route('user.profile');
    }


    public function ChangePassword(Request $request)
    {
        $validated = $this->validate($request, [
            'current_password' => 'required', new MatchOldPassword,
            'password' => 'confirmed|min:8|string'
        ]);

        $user = Auth::user();

        if(!Hash::check($request->current_password, $user->password))
        {
            toast()->error('Error', 'Wrong Old Password.')->position('top-end');
            return redirect()->route('user.profile');
        }

        $user->password = Hash::make($request->password);
        $user->save();
        toast()->success('Success', 'Successfully changed password')->position('top-end');
        return redirect()->route('user.profile');

    }

    public function Query()
    {
        $user_id = Auth()->user()->id;
        $role_id = Auth()->user()->role_id;
        $pending_queries = '';

        if($role_id == 1)
        {
            $queries = Query::where('client_id', $user_id)->get();

        }else if($role_id == 2)
        {
            $arrDeclined = [];
            $nqueries = Query::where('lawyer_id', $user_id)->orWhere('lawyer_id',null)->get();

            foreach($nqueries as $query) {
                if($query->declined_id) {
                    $declineID = json_decode($query->declined_id);
                    if($declineID->declined_id==Auth::User()->id)
                        array_push($arrDeclined, $query->id);
                }
            }
            $queries = Query::where('lawyer_id', $user_id)->orWhere('lawyer_id',null)->whereNotIn('id',$arrDeclined)->get();
            $pending_queries = Query::where('status', 'Pending')->where('lawyer_id', $user_id)->orWhere('lawyer_id',null)->whereNotIn('id',$arrDeclined)->get();
            // $queries = Query::where('lawyer_id', $user_id)->get();
        }else{
            $queries = Query::with('lawyer')->get();
            $pending_queries = '';
        }
        
        return view('profile.query', compact('queries', 'pending_queries'));
    }

    public function QueryProfile($id)
    {
        $queries = Query::where('transaction_number', $id)->first();

        /** check if there is a query with the given ID */
        if($queries) {
            if(Auth::User()->role_id==1 && Auth::User()->id!=$queries->client_id) /** check if query is requeste by the client logged in */
                    return redirect()->route('user.queries')->with('error','Access Denied');
            $feedback_check = Feedback::where('query_id', $queries->id)->count();

            $event_check = CalendarEvent::where('query_id', $queries->id)->with('queries')->first();

            /** show only available specializations */
            $availableSpecializations = LawyerSpecialization::select('specialization_id')->groupBy('specialization_id')->get();
            $specializations = Specialization::where('id','!=',1)->whereIn('id',$availableSpecializations->toArray())->get();
            
            return view('profile.transaction', compact('queries' , 'feedback_check', 'event_check','specializations'));
        } else // if no query based on the ID, return to previous page
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

    public function AcceptQuery(Request $request)
    {
        $queries = Query::where('transaction_number', $request->transaction_number)->with('lawyer', 'client')->first();

        if($request->input('action') == 'accept')
        {
            $start_date = Carbon\Carbon::parse($request->schedule_date ."". $request->schedule_time)->format('Y-m-d H:i');

            $end_date = Carbon\Carbon::parse($request->schedule_date ."". $request->schedule_time)->addHour(2)->format('Y-m-d H:i');


            $pstart_date = Carbon\Carbon::parse($start_date);
            $pend_date = Carbon\Carbon::parse($end_date);
            $resolution_type = $queries->resolution_type;
            $lawyer_email = $queries->lawyer->email;
            $client_email = $queries->client->email;

            $event = $this->CreateEvent($pstart_date, $pend_date, $resolution_type, $lawyer_email, $client_email);

            $queries->status = 'In-Progress';
            $queries->assigned_date = $request->schedule_date;
            $queries->assigned_time = $request->schedule_time;
            $queries->save();

            $calendar = new CalendarEvent();
            $calendar->query_id = $queries->id;
            $calendar->meeting_link = $event->hangoutLink;
            $calendar->start_time = $pstart_date;
            $calendar->end_time = $pend_date;
            $calendar->save();

            toast()->success('Success', 'Schedule successfully accepted')->position('top-end');

            return redirect()->route('user.query', $queries->transaction_number);

        }elseif($request->input('action') == 'reschedule')
        {
            $request->validate([
                'assigned_date' => 'required',
                'assigned_time' => 'required',
            ]);

            if($queries->reschedule_count == 3)
            {
                toast()->error('Error', 'Reschedule Count already exceeded')->position('top-end');

                return redirect()->route('user.query', $queries->transaction_number);


            }else{
                $queries->status = 'Rescheduled';
            $queries->schedule_date = $request->assigned_date;
            $queries->schedule_time = $request->assigned_time;
            $queries->reschedule_count = $queries->reschedule_count + 1;
            $queries->save();

            toast()->success('Success', 'Rescheduled successfully')->position('top-end');

            return redirect()->route('user.query', $queries->transaction_number);
            }

            


        }elseif($request->input('action') == 'feedback')
        {
            $request->validate([
                'feedback' => 'required',
            ]);

            $randon_number = random_int(100000, 999999);

            $feedback = new Feedback();
            $feedback->feedback_number = $randon_number;
            $feedback->client_id = Auth()->user()->id;
            $feedback->status = "Pending";
            $feedback->query_id = $queries->id;
            $feedback->feedback = $request->feedback;
            $feedback->save();

            toast()->success('Success', 'Feedback successfully sent!')->position('top-end');

            return redirect()->route('user.queries');
        }elseif($request->input('action') == 'decline-reschedule')
        {
            $request->validate([
                'available_date_1' => 'required',
                'available_date_2' => 'required',
                'available_date_3' => 'required',
                'subject' => 'required',
                'question' => 'required',
            ]);

            /** Checks each given available time for duplicates */
            $available_date_array = [request()->new_available_date_1,request()->new_available_date_2,request()->new_available_date_3];
            $available_time_array = [request()->new_available_time_1,request()->new_available_time_2,request()->new_available_time_3];
        
            foreach($available_date_array as $i => $row) {
                for($j=1;$j<=3;$j++) {
                    $counter = Query::where([
                        ['client_id',Auth()->user()->id],
                        ['available_date_'.$j,$row],
                        ['available_time_'.$j,$available_time_array[$i]],
                        ['transaction_number','!=',$request->transaction_number]
                    ])
                    ->count();

                    if($counter>0)
                        return back()->withErrors(
                            ['schedule' => 'Duplicate appointment on '.$row.' '.$available_time_array[$i]]);
                }
            }
            /** end checking */
            
            /** Update query */
            $newQuery = Query::where('transaction_number', $request->transaction_number)->first();
            $newQuery->question = $request->question;
            $newQuery->subject = Specialization::find($request->subject)->specialization;
            $newQuery->status = 'Pending';
            $newQuery->available_date_1 = $request->available_date_1;
            $newQuery->available_date_2 = $request->available_date_2;
            $newQuery->available_date_3 = $request->available_date_3;
            $newQuery->available_time_1 = $request->available_time_1;
            $newQuery->available_date_2 = $request->available_date_2;
            $newQuery->available_date_3 = $request->available_date_3;
            
            /** Call Query-Lawyer Matchmaking Algo */
            $queryController = new QueryController;
            //send email to lawyers
            $newQuery->lawyer_id = $queryController->sendLawyerEmail($request);
            //save new updated query info
            $newQuery->save();

            toast()->success('Success', 'New Query has been sent!')->position('top-end');

            //return to queries page
            return redirect()->route('user.queries');
        }
    }

    public function PaymentDetails($id)
    {
        $queries = Query::where('transaction_number', $id)->first();

        $transaction_number = $queries->transaction_number;

        return view('profile.details', compact('queries', 'transaction_number'));
    }

    public function UploadProfilePicture(Request $request)
    {
        $user_id = Auth()->user()->id;

        if($request->hasFile('profile_picture'))
        {
            $user = User::where('id', $user_id)->first();

            $profile_picture = request()->file('profile_picture')->storeOnCloudinary('profile_picture/')->getSecurePath();

            $user->profile_photo_path = $profile_picture;
            $user->save();

            toast()->success('Success', 'Profile Picture successfully uploaded')->position('top-end');

            return redirect()->route('user.profile');
        }
    }

    public function UploadPayment(Request $request)
    {
        $request->validate([
            'proof_photo' => 'required|mimes:pdf,docx,jpg,bmp,png' /** restrict file uploads to PDF, Word document and Images */
        ]);
        $transaction_number = $request->transaction_number;

        $queries = Query::where('transaction_number', $transaction_number)->first();

        $proof_photo = request()->file('proof_photo')->storeOnCloudinary('payment_proof/')->getSecurePath();
        
        $queries->proof_photo_url = $proof_photo;
        $queries->save();

        $randon_number = random_int(100000, 999999);
        
        $payments = new Payment();
        $payments->payment_number = $randon_number;
        $payments->client_id =auth()->user()->id;
        $payments->payment_status = "Pending";
        $payments->proof_payment_path = $proof_photo;
        $payments->save();

        /** Check query has been accepted by a lawyer
         *  If query is assigned, send an email to the lawyer
         *  Else, query all eligible lawyers and send them an email to accept query
         */
        if($queries->lawyer_id) {
            $details = [
                'title' => 'Payment has been Made',
                'ReferenceNumber' => $request->transaction_number,
                'body' => 'Please check your OnCon account, please verify proof of payment for a Query.' 
            ];

            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $subject = 'Payment has been Made';

            $to = $queries->lawyer->email;

            \Mail::to($to)->send(new NotifMail($details));
        } else {
            
            $availabilityQuery = 'Offline';
            if($queries->category != 'Online Consultation')
                $availabilityQuery = 'Online';

            $users = User::where('role_id', 2)->where('is_verified', 1)->where('availability', '!=', $availabilityQuery)->get();

            foreach($users as $user)
            {
                $availableSubject = $users->pluck('specialization');
                $availSub = explode('-', $availableSubject);

                if(strpos($availableSubject, $queries->subject) !== false)
                {
                    $lawyers = User::where('role_id', 2)
                        ->join('lawyer_time_frames','lawyer_time_frames.lawyer_id','users.id')
                        ->where([
                            ['specialization', 'LIKE', '%'.$queries->subject.'%'],['availability', '!=', $availabilityQuery]
                        ])
                        ->orWhere([
                            ['from', '<=', $queries->available_time_1], ['from', '<=', $queries->available_time_2], ['from', '<=', $queries->available_time_3]
                        ])
                        ->get();
                    
                    $requestedDates = [$queries->available_date_1,$queries->available_date_2,$queries->available_date_3]; //save requested dates to  an array
                    $requestedTimes = [$queries->available_time_1,$queries->available_time_2,$queries->available_time_3]; //save requested time to  an array
                    
                    if($lawyers) {
                        
                        $lawyersAvailableCount = 0;
                        foreach($lawyers as $lawyer) 
                        {
                            /** get assigned queries to a lawyer */
                            $lawyerQueries = Query::where('lawyer_id',$lawyer->id)->get();
        
                            /** check for conflicts in schedule */
                            $conflicts = 0; //conflict counter
                            foreach($lawyerQueries as $lawyerQuery) {
        
                                foreach($requestedDates as $k => $requestedDate) {
        
                                    /** check if a query assigned to a lawyer 
                                     *  if requested date is the same, check also if the difference in time is more than 2 hours
                                     */
                                    if($lawyerQuery->assigned_date==$requestedDate) { 
                                        $requestedTimeItem = Carbon\Carbon::parse($requestedDate.' '.$requestedTimes[$k]);
                                        if(Carbon\Carbon::parse($lawyerQuery->schedule_date.' '.$lawyerQuery->schedule_time)->diffInHours($requestedTimeItem)<2)
                                            $conflicts++;
                                    }
                                }
                            }
        
                            // if conflict == 0 send this query to the specialized lawyers
                            if($conflicts==0) {
                                $lawyersAvailableCount++;
                                $details = [
                                    'title' => 'Payment has been Made',
                                    'ReferenceNumber' => $request->transaction_number,
                                    'body' => 'Please check your OnCon account, please verify proof of payment for a Query.' 
                                ];
            
                                $from = env('MAIL_FROM_ADDRESS');
                                $name = env('MAIL_FROM_NAME');
                                $subject = 'Payment has been Made';
            
                                $to = $lawyer->email;
            
                                \Mail::to($to)->send(new NotifMail($details));
                            }
                        }

                        if($lawyersAvailableCount==0) //if value is 0, no lawyer time frame is available, so send query to lawyers with specializations with the subject
                        {
                            foreach($lawyers as $lawyer) {
                                $details = [
                                    'title' => 'Payment has been Made',
                                    'ReferenceNumber' => $request->transaction_number,
                                    'body' => 'Please check your OnCon account, please verify proof of payment for a Query.' 
                                ];
            
                                $from = env('MAIL_FROM_ADDRESS');
                                $name = env('MAIL_FROM_NAME');
                                $subject = 'Payment has been Made';
            
                                $to = $lawyer->email;
            
                                \Mail::to($to)->send(new NotifMail($details));
                            }
                        }
                    } else //if no lawyers available assign to general specialization
                    {
                        $lawyers = User::where('role_id', 2)
                        ->where('specialization', 'LIKE', '%General%' )
                        ->where('availability', '!=', 'Offline')
                        ->get();
        
                        $assigned = null;
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
                                    $value['date_of_last_query'] == NULL; 
                                });
        
                                $assigned = collect($filtered)->sortBy('created_at')->first(); 
                            }
                        }

                        $details = [
                            'title' => 'Payment has been Made',
                            'ReferenceNumber' => $request->transaction_number,
                            'body' => 'Please check your OnCon account, please verify proof of payment for a Query.' 
                        ];
    
                        $from = env('MAIL_FROM_ADDRESS');
                        $name = env('MAIL_FROM_NAME');
                        $subject = 'Payment has been Made';
    
                        $to = User::find($assigned->id)->email;
    
                        \Mail::to($to)->send(new NotifMail($details));

                        $queries = new Query;
                        $queries->lawyer_id = $assigned->id;
                        $queries->save();
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
                    }

                    $details = [
                        'title' => 'Payment has been Made',
                        'ReferenceNumber' => $queries->transaction_number,
                        'body' => 'Please check your OnCon account, please verify proof of payment for a Query.' 
                    ];

                    $from = env('MAIL_FROM_ADDRESS');
                    $name = env('MAIL_FROM_NAME');
                    $subject = 'Payment has been Made';

                    $to = User::find($assigned->id)->email;

                    \Mail::to($to)->send(new NotifMail($details));

                    $queries = new Query;
                    $queries->lawyer_id = $assigned->id;
                    $queries->save();
                }
            }
        }
        /** */
        
        toast()->success('Success', 'Proof of payment uploaded')->position('top-end');

        return redirect()->route('user.query', $transaction_number);

    }


}
