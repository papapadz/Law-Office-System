<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Query;
use App\Lawyer;
Use Alert;
use Illuminate\Support\Str;
use App\User;
use Carbon;
use Illuminate\Mail\Mailer;
use App\Mail\NotifMail;
use App\Specialization;
use App\LawyerSpecialization;

class QueryController extends Controller
{
    //
    public function online()
    {
        return view('online');
    }

    public function onlinequery()
    {
        /** show only available specializations */
        $availableSpecializations = LawyerSpecialization::select('specialization_id')->groupBy('specialization_id')->get();
        $specializations = Specialization::where('id','!=',1)->whereIn('id',$availableSpecializations->toArray())->get();
        
        return view('query.online', compact('specializations'));
    }

    public function offlinequery()
    {
        $users = User::where('role_id', 2)->where('is_verified', 1)->where('availability', '!=', 'Online')->get();
        return view('query.offline', compact('users'));
    }

    public function SubmitQuery(Request $request)
    {
        $request->validate([
            'contact_number' => 'required|numeric|digits:11',
        ]);

        $query = new Query();
        $query->name = $request->name;
        $query->email = $request->email;
        $query->contact_number = $request->contact_number;
        $query->category = "Online Consultation";
        $query->resolution_type = request()->resolution_type;
        $query->question = $request->question;

        return view('query.submit', compact('query'));
    }

    public function offline()
    {
        return view('offline');
    }

    public function StoreOfflineQuery(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'policy' => 'required',
            'available_date_1' =>'required',
            'available_time_1' =>'required',
            'available_date_2' =>'required',
            'available_time_2' =>'required',
            'available_date_3' =>'required',
            'available_time_3' =>'required'
        ]);

        $randon_number = random_int(100000, 999999);

        $query = new Query();
        $query->client_id = auth()->user()->id;
        $query->name = request()->name;
        $query->email = request()->email;
        $query->contact_number = request()->contact_number;
        $query->category = "Offline Consultation";
        $query->question = request()->question;
        $query->resolution_type = request()->resolution_type;
        $query->lawyer_id = request()->lawyer_id;
        $query->status = 'Pending';
        $query->available_date_1 = request()->available_date_1;
        $query->available_time_1 = request()->available_time_1;
        $query->available_date_2 = request()->available_date_2;
        $query->available_time_2 = request()->available_time_2;
        $query->available_date_3 = request()->available_date_3;
        $query->available_time_3 = request()->available_time_3;
        $query->transaction_number = $randon_number;
        $query->save();

         $details = [
            'title' => 'You Have a New Assigned Query',
            'ReferenceNumber' => $request->transaction_number,
            'body' => 'Please check your OnCon account as we have assigned you a new query.' 
            ];

            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $subject = 'You Have New Assigned Query';

            $to = $query->lawyer->email;

            \Mail::to($to)->send(new NotifMail($details));

        toast()->success('Success', 'Query successfully sent!')->position('top-end');

        return redirect()->route('user.query', $query->transaction_number);
    }

    public function StoreOnlineQuery(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'policy' => 'required',
            'subject' => 'required',
            'resolution_type' => 'required',
            'available_date_1' =>'required_if:resolution_type,Video Conference with a Lawyer',
            'available_time_1' =>'required',
            'available_date_2' =>'required_if:resolution_type,Video Conference with a Lawyer',
            'available_time_2' =>'required',
            'available_date_3' =>'required_if:resolution_type,Video Conference with a Lawyer',
            'available_time_3' =>'required'
        ]);

        /** Checks each given available time for duplicates */
        $available_date_array = [request()->available_date_1,request()->available_date_2,request()->available_date_3];
        $available_time_array = [request()->available_time_1,request()->available_time_2,request()->available_time_3];
        
        foreach($available_date_array as $i => $row) {
            for($j=1;$j<=3;$j++) {
                $counter = Query::where([
                    ['client_id',auth()->user()->id],
                    ['available_date_'.$j,$row],
                    ['available_time_'.$j,$available_time_array[$i]]
                ])
                ->count();

                if($counter>0)
                    return back()->withErrors(
                        ['schedule' => 'Duplicate appointment on '.$row.' '.$available_time_array[$i]]);
            }
        }
        /** end checking */
        
        $randon_number = random_int(100000, 999999);

        $query = new Query();
        $query->client_id = auth()->user()->id;
        $query->name = request()->name;
        $query->email = request()->email;
        $query->contact_number = request()->contact_number;
        $query->category = "Online Consultation";
        $query->question = request()->question;
        $query->subject = request()->subject;
        $query->resolution_type = request()->resolution_type;
        $query->available_date_1 = request()->available_date_1;
        $query->available_time_1 = request()->available_time_1;
        $query->available_date_2 = request()->available_date_2;
        $query->available_time_2 = request()->available_time_2;
        $query->available_date_3 = request()->available_date_3;
        $query->available_time_3 = request()->available_time_3;
        $query->status = 'Pending';
        $query->transaction_number = $randon_number;
        //$choosenlawyer = $this->getLawyer($request);
        //$query->lawyer_id = $choosenlawyer;      
        $query->lawyer_id = $this->sendLawyerEmail($request);
        $query->save();

        // $lawyer = User::where('id', $choosenlawyer)->first();
        // $lawyer->totalAssigned++;
        // $lawyer->date_of_last_query = Carbon\Carbon::now()->format('Y-m-d H:i');
        // $lawyer->save();

        //  $details = [
        //     'title' => 'You Have a New Assigned Query',
        //     'ReferenceNumber' => $request->transaction_number,
        //     'body' => 'Please check your OnCon account as we have assigned you a new query.' 
        //     ];

        //     $from = env('MAIL_FROM_ADDRESS');
        //     $name = env('MAIL_FROM_NAME');
        //     $subject = 'You Have New Assigned Query';

        //     $to = $query->lawyer->email;

        //     \Mail::to($to)->send(new NotifMail($details));

        toast()->success('Success', 'Query successfully sent!')->position('top-end');
        // return redirect()->route('online.query');
        return redirect()->route('user.query', $query->transaction_number);
    }

    public function getLawyer(Request $request)
    {

        $users = User::where('role_id', 2)->where('is_verified', 1)->where('availability', '!=', 'Offline')->get();

        foreach($users as $user)
        {
            $availableSubject = $users->pluck('specialization');
            $availSub = explode('-', $availableSubject);

            if(strpos($availableSubject, $request->subject) !== false)
            {
                $lawyers = User::where('role_id', 2)
                    ->join('lawyer_time_frames','lawyer_time_frames.lawyer_id','users.id')
                    ->where([
                        ['specialization', 'LIKE', '%'.$subject.'%'],['availability', '!=', 'Offline']
                    ])
                    ->orWhere([
                        ['from', '<=', $request->available_time_1], ['from', '<=', $request->available_time_2], ['from', '<=', $request->available_time_3]
                    ])
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

    /** Query-Lawyer matchmaking algorithm
     *  this function sends an email to lawyers who are eligible for the submitted query
    */
    public function sendLawyerEmail(Request $request) {

        $users = User::where('role_id', 2)->where('is_verified', 1)->where('availability', '!=', 'Offline')->get();

        foreach($users as $user)
        {
            $availableSubject = $users->pluck('specialization');
            $availSub = explode('-', $availableSubject);

            if(strpos($availableSubject, $request->subject) !== false)
            {
                $lawyers = User::where('role_id', 2)
                    ->join('lawyer_time_frames','lawyer_time_frames.lawyer_id','users.id')
                    ->where([
                        ['specialization', 'LIKE', '%'.$subject.'%'],['availability', '!=', 'Offline']
                    ])
                    ->orWhere([
                        ['from', '<=', $request->available_time_1], ['from', '<=', $request->available_time_2], ['from', '<=', $request->available_time_3]
                    ])
                    ->get();
                
                $requestedDates = [$request->available_date_1,$request->available_date_2,$request->available_date_3]; //save requested dates to  an array
                $requestedTimes = [$request->available_time_1,$request->available_time_2,$request->available_time_3]; //save requested time to  an array
                
                if($lawyers) {
                    
                    $lawyersAvailableCount = 0;
                    foreach($lawyers as $lawyer) 
                    {
                        /** get assigned queries to a lawyer */
                        $queries = Query::where('lawyer_id',$lawyer->id)->get();
    
                        /** check for conflicts in schedule */
                        $conflicts = 0; //conflict counter
                        foreach($queries as $query) {
    
                            foreach($requestedDates as $k => $requestedDate) {
    
                                /** check if a query assigned to a lawyer 
                                 *  if requested date is the same, check also if the difference in time is more than 2 hours
                                 */
                                if($query->assigned_date==$requestedDate) { 
                                    $requestedTimeItem = Carbon\Carbon::parse($requestedDate.' '.$requestedTimes[$k]);
                                    if(Carbon\Carbon::parse($query->schedule_date.' '.$query->schedule_time)->diffInHours($requestedTimeItem)<2)
                                        $conflicts++;
                                }
                            }
                        }
    
                        // if conflict == 0 send this query to the specialized lawyers
                        if($conflicts==0) {
                            $lawyersAvailableCount++;
                            $details = [
                                'title' => 'New Query Match',
                                'ReferenceNumber' => $request->transaction_number,
                                'body' => 'Please check your OnCon account, we have a new query that you might be interested with.' 
                            ];
        
                            $from = env('MAIL_FROM_ADDRESS');
                            $name = env('MAIL_FROM_NAME');
                            $subject = 'You Have a New Query Match';
        
                            $to = $lawyer->email;
        
                            \Mail::to($to)->send(new NotifMail($details));
                        }
                    }

                    if($lawyersAvailableCount==0) //if value is 0, no lawyer time frame is available, so send query to lawyers with specializations with the subject
                    {
                        foreach($lawyers as $lawyer) {
                            $details = [
                                'title' => 'New Query Match',
                                'ReferenceNumber' => $request->transaction_number,
                                'body' => 'Please check your OnCon account, we have a new query that you might be interested with.' 
                            ];
        
                            $from = env('MAIL_FROM_ADDRESS');
                            $name = env('MAIL_FROM_NAME');
                            $subject = 'You Have a New Query Match';
        
                            $to = $lawyer->email;
        
                            \Mail::to($to)->send(new NotifMail($details));
                        }
                    }

                    return null;
                } else //if no lawyers availble assign to general specialization
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
        return null;
    }

    public function checkUnassigned() {
        
        $queries = Query::where('lawyer_id',null)->get();

        foreach($queries as $query) {

            if(Carbon\Carbon::now()->diffInHours(Carbon\Carbon::parse($query->created_at)>2)) {
                $category = 'Offline';
                if($query->category=='Offline Consultation')
                    $category = 'Online';
                    
                $users = User::where('role_id', 2)->where('is_verified', 1)->where('availability', '!=', $category)->get();
                foreach($users as $user)
                {
                    $availableSubject = $users->pluck('specialization');
                    $availSub = explode('-', $availableSubject);

                    if(strpos($availableSubject, $query->subject) !== false)
                    {
                        $lawyers = User::where('role_id', 2)
                            ->join('lawyer_time_frames','lawyer_time_frames.lawyer_id','users.id')
                            ->where([
                                ['specialization', 'LIKE', '%'.$subject.'%'],['availability', '!=', 'Offline']
                            ])
                            ->orWhere([
                                ['from', '<=', $query->available_time_1], ['from', '<=', $query->available_time_2], ['from', '<=', $query->available_time_3]
                            ])
                            ->get();
                        
                        $requestedDates = [$query->available_date_1,$query->available_date_2,$query->available_date_3]; //save requested dates to  an array
                        $requestedTimes = [$query->available_time_1,$query->available_time_2,$query->available_time_3]; //save requested time to  an array
                        
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
                                            if(Carbon\Carbon::parse($query->schedule_date.' '.$query->schedule_time)->diffInHours($requestedTimeItem)<2)
                                                $conflicts++;
                                        }
                                    }
                                }
            
                                // if conflict == 0 send this query to the specialized lawyers
                                if($conflicts==0) {
                                    $lawyersAvailableCount++;
                                    $details = [
                                        'title' => 'New Query Match',
                                        'ReferenceNumber' => $request->transaction_number,
                                        'body' => 'Please check your OnCon account, we have a new query that you might be interested with.' 
                                    ];
                
                                    $from = env('MAIL_FROM_ADDRESS');
                                    $name = env('MAIL_FROM_NAME');
                                    $subject = 'You Have a New Query Match';
                
                                    $to = $lawyer->email;
                
                                    \Mail::to($to)->send(new NotifMail($details));
                                }
                            }

                            if($lawyersAvailableCount==0) //if value is 0, no lawyer time frame is available, so send query to lawyers with specializations with the subject
                            {
                                foreach($lawyers as $lawyer) {
                                    $details = [
                                        'title' => 'New Query Match',
                                        'ReferenceNumber' => $request->transaction_number,
                                        'body' => 'Please check your OnCon account, we have a new query that you might be interested with.' 
                                    ];
                
                                    $from = env('MAIL_FROM_ADDRESS');
                                    $name = env('MAIL_FROM_NAME');
                                    $subject = 'You Have a New Query Match';
                
                                    $to = $lawyer->email;
                
                                    \Mail::to($to)->send(new NotifMail($details));
                                }
                            }

                            return null;
                        } else //if no lawyers availble assign to general specialization
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
            }
        }
    }
}