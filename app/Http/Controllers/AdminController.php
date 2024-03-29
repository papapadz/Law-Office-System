<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Query;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Mail\NotifMail;
use App\User;
use App\Feedback;
use App\ContactUs;
use Carbon\Carbon;
use App\Audit;
use App\LawyerSpecialization;

class AdminController extends Controller
{
    //
    public function index()
    {
        
        $pending_query = Query::where('status', 'Pending')->count();
        $inprogress_query = Query::where('status', 'In-Progress')->count();
        $scheduled_query = Query::where('status', 'Scheduled')->count();
        $complete_query = Query::where('status', 'Complete')->count();

        $lawyer_count = User::where('role_id', 2)->count();

        $client_count = User::where('role_id', 1)->count();

        $pending_count = User::where('role_id', 2)->where('is_verified', 0)->count();

        $feedback_count = Feedback::where('status', 'Pending')->count();

        $inquiry_count = ContactUs::where('status', 'Pending')->count();

        return view('admin.index', compact('pending_query', 'inprogress_query', 'scheduled_query', 'complete_query',  'lawyer_count', 'client_count', 'pending_count', 'feedback_count', 'inquiry_count'));
    }

    public function feedbacks()
    {
        $feedbacks = Feedback::get();

        return view('admin.feedbacks', compact('feedbacks'));
    }

    public function payments()
    {
        $payments = Query::where('is_payment_verified', '!=', '1')->get(); 
        return view('admin.payments', compact('payments'));
    }

    public function Inquiries()
    {
        $contacts = ContactUs::get();

        return view('admin.inquiries', compact('contacts'));
    }

    public function ApproveInquiry(Request $request)
    {
        $request->validate([
                'reply_message' => 'required',
        ]);

        $contacts = ContactUs::where('id', $request->contact_id)->first();
        $details = [
            'title' => 'Inquiry Reply',
            'body' => 'Reply from OnCon: ' .$request->reply_message,
            'ReferenceNumber' => $contacts->inquiry_number
        ];

        $from = env('MAIL_FROM_ADDRESS');
        $name = env('MAIL_FROM_NAME');
        $subject = 'Inquiry Reply';

       
        $contacts->status = "Replied";
        $contacts->save();

        $to = $contacts->email;

        \Mail::to($to)->send(new NotifMail($details));

        toast()->success('Success', 'Inquiry successfully approved')->position('top-end');

        return redirect()->route('admin.dashboard');


    }



    public function inquirydetails($id)
    {
        $contacts = ContactUs::where('id', $id)->first();

        return view('admin.contactdetails', compact('contacts'));
    }

    public function feedback($id)
    {
        $feedbacks = Feedback::where('id', $id)->with('client', 'queries')->first();


        return view('admin.feedback', compact('feedbacks'));

    }

    public function ApproveFeedback(Request $request)
    {
        

        if($request->input('action') == 'send')
        {
            $feedbacks = Feedback::where('id', $request->feedback_id)->with('client', 'queries')->first();

            $request->validate([
                'reply_message' => 'required',
            ]);

            $details = [
            'title' => 'Feedback Reply',
            'body' => 'Reply from OnCon: ' .$request->reply_message,
            'ReferenceNumber' => $feedbacks->feedback_number
            ];

            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $subject = 'Feedback Reply';

            
            $feedbacks->status = 'Send';
            $feedbacks->save();

            $to = $feedbacks->client->email;

            \Mail::to($to)->send(new NotifMail($details));


        }else{

            $feedbacks = Feedback::where('id', $request->feedback_id)->with('client', 'queries')->first();

            $request->validate([
                'reply_message' => 'required',
            ]);

            $details = [
            'title' => 'Feedback Reply',
            'body' => 'Reply from OnCon: ' .$request->reply_message,
            'ReferenceNumber' => $feedbacks->feedback_number 
            ];

            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $subject = 'Feedback Reply';

            $feedbacks->status = 'Approved';
            $feedbacks->save();
            
            $to = $feedbacks->client->email;


            \Mail::to($to)->send(new NotifMail($details));
            

            toast()->success('Success', 'Feedback successfully approved')->position('top-end');

        }

        return redirect()->route('admin.dashboard');


    }



    public function AdminQueryType($type)
    {
        // $queries = Query::where('transaction_number', $id)->get();
        $queries = Query::where('status', $type)->with('lawyer', 'client')->get();
        

        return view('admin.queries', compact('queries'));
    }

    public function QueryDetails($id)
    {
        $queries = Query::where('transaction_number', $id)->first();

        $users = User::where('role_id', 2)->where('is_verified', 1)->get();

        return view('admin.details', compact('queries', 'users'));
    }

    public function AccountList($id)
    {
        // $queries = Query::where('transaction_number', $id)->get();
        $users = User::where('role_id', $id)->get();
        $ids = $id;


        return view('admin.accounts', compact('users', 'ids'));
    }

    public function AssignQuery(Request $request)
    {
        if($request->input('action') == 'save')
        {
            $queries = Query::where('transaction_number', $request->transaction_number)->first();
            $queries->is_payment_verified = 1;
            $queries->save();

            $details = [
                'title' => 'Approved Proof of Payment',
                'ReferenceNumber' => $queries->transaction_number,
                'body' => 'We are pleased to inform that your proof of payment is approve. Update on your transaction will be sent soon. Thank you.'
            ];

            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $subject = 'Approved Proof of Payment';

            $to = $queries->client->email;

            \Mail::to($to)->send(new NotifMail($details));

            toast()->success('Success', 'Query successfully assigned! Lawyer is notified.')->position('top-end');

            if($queries->lawyer_id) {
                $details = [
                    'title' => 'Approved Proof of Payment',
                    'ReferenceNumber' => $queries->transaction_number,
                    'body' => 'A Proof of Payment is approved. You can proceed with this Query now.'
                ];
                $to = $queries->lawyer->email;
                \Mail::to($to)->send(new NotifMail($details));
            } else {

                $lawyersAvailableCount = 0;
                $requestedDates = [$queries->available_date_1,$queries->available_date_2,$queries->available_date_3]; //save requested dates to  an array
                $requestedTimes = [$queries->available_time_1,$queries->available_time_2,$queries->available_time_3]; //save requested time to  an array
                
                $user_specializations = LawyerSpecialization::where('specialization_id',$queries->subject)->get();

                foreach($user_specializations as $user_specialization) {
                    
                    $lawyer = $user_specialization->user;
                    
                    if($queries->category = 'Online Consultation' && $lawyer->availability != 'Offline' && $lawyer->is_verified) {
                        
                        if($queries->resolution_type == 'Video Conference with a Lawyer') {
                            /** check for conflicts in schedule */
                            $conflicts = 0; //conflict counter
                            $lawyer_queries = $lawyer->queries->where('status','Pending');

                            if(count($lawyer_queries)>0) {
                                foreach($lawyer_queries as $lawyer_query) {
                                    foreach($requestedDates as $k => $requestedDate) {
                                        /** check if a query assigned to a lawyer 
                                         *  if requested date is the same, check also if the difference in time is more than 2 hours
                                         */
                                        if($lawyer_query->schedule_date==$requestedDate) { 
                                            $requestedTimeItem = Carbon\Carbon::parse($requestedDate.' '.$requestedTimes[$k]);
                                            if(Carbon\Carbon::parse($lawyer_query->schedule_date.' '.$lawyer_query->schedule_time)->diffInHours($requestedTimeItem)<2)
                                                $conflicts++;
                                        }
                                    }
                                }
                                if($conflicts==0) {
                                    $lawyersAvailableCount++;
                                    $details = [
                                        'title' => 'Approved Proof of Payment',
                                        'ReferenceNumber' => $queries->transaction_number,
                                        'body' => 'A Query Proof of Payment is approved. You might want to accept this query.'
                                    ];
                                    $from = env('MAIL_FROM_ADDRESS');
                                    $name = env('MAIL_FROM_NAME');
                                    $subject = 'Approved Proof of Payment';   
                                    $to = $lawyer->email;                        
                                    \Mail::to($to)->send(new NotifMail($details));
                                }
                            }
                        } else {
                            $lawyersAvailableCount++;
                            $details = [
                                'title' => 'Approved Proof of Payment',
                                'ReferenceNumber' => $queries->transaction_number,
                                'body' => 'A Query Proof of Payment is approved. You might want to accept this query.'
                            ];
                            $from = env('MAIL_FROM_ADDRESS');
                            $name = env('MAIL_FROM_NAME');
                            $subject = 'You Have a New Query Match';   
                            $to = $lawyer->email;                        
                            \Mail::to($to)->send(new NotifMail($details));
                        }
                    } else if($queries->category = 'Offline Consultation' && $lawyer->availability == 'Offline' && $lawyer->is_verified) {

                        $lawyersAvailableCount++;
                        $details = [
                            'title' => 'Approved Proof of Payment',
                            'ReferenceNumber' => $queries->transaction_number,
                            'body' => 'A Query Proof of Payment is approved. You might want to accept this query.'
                        ];
                        $from = env('MAIL_FROM_ADDRESS');
                        $name = env('MAIL_FROM_NAME');
                        $subject = 'You Have a New Query Match';   
                        $to = $lawyer->email;                        
                        \Mail::to($to)->send(new NotifMail($details));
                    }
                }

                /**if no lawyers available */
                if($lawyersAvailableCount==0) {

                    //send email to all lawyers with that specialization
                    foreach($user_specializations as $user_specialization) {
                        $lawyer = $user_specialization->user;
                        if($queries->category = 'Online Consultation' && $lawyer->availability != 'Offline' && $lawyer->is_verified) {
                            $lawyersAvailableCount++;
                            $details = [
                                'title' => 'Approved Proof of Payment',
                                'ReferenceNumber' => $queries->transaction_number,
                                'body' => 'A Query Proof of Payment is approved. You might want to accept this query.'
                            ];
                            $from = env('MAIL_FROM_ADDRESS');
                            $name = env('MAIL_FROM_NAME');
                            $subject = 'You Have a New Query Match';   
                            $to = $lawyer->email;                        
                            \Mail::to($to)->send(new NotifMail($details));
                        } else if($queries->category = 'Offline Consultation' && $lawyer->availability == 'Offline' && $lawyer->is_verified) {
                            $lawyersAvailableCount++;
                            $details = [
                                'title' => 'Approved Proof of Payment',
                                'ReferenceNumber' => $queries->transaction_number,
                                'body' => 'A Query Proof of Payment is approved. You might want to accept this query.'
                            ];
                            $from = env('MAIL_FROM_ADDRESS');
                            $name = env('MAIL_FROM_NAME');
                            $subject = 'You Have a New Query Match';   
                            $to = $lawyer->email;                        
                            \Mail::to($to)->send(new NotifMail($details));
                        }
                    }

                    //if no lawyer is still available, send to general lawyers
                    if($lawyersAvailableCount==0) {
                        //get general lawyers
                        $user_specializations = LawyerSpecialization::where('specialization_id',1)->get();
                        foreach($user_specializations as $user_specialization) {
                            $lawyer = $user_specialization->user;
                            if($queries->category = 'Online Consultation' && $lawyer->availability != 'Offline' && $lawyer->is_verified) {
                                $lawyersAvailableCount++;
                                $details = [
                                    'title' => 'Approved Proof of Payment',
                                    'ReferenceNumber' => $queries->transaction_number,
                                    'body' => 'A Query Proof of Payment is approved. You might want to accept this query.'
                                ];
                                $from = env('MAIL_FROM_ADDRESS');
                                $name = env('MAIL_FROM_NAME');
                                $subject = 'You Have a New Query Match';   
                                $to = $lawyer->email;                        
                                \Mail::to($to)->send(new NotifMail($details));
                            } else if($queries->category = 'Offline Consultation' && $lawyer->availability == 'Offline' && $lawyer->is_verified) {
                                $lawyersAvailableCount++;
                                $details = [
                                    'title' => 'Approved Proof of Payment',
                                    'ReferenceNumber' => $queries->transaction_number,
                                    'body' => 'A Query Proof of Payment is approved. You might want to accept this query.'
                                ];
                                $from = env('MAIL_FROM_ADDRESS');
                                $name = env('MAIL_FROM_NAME');
                                $subject = 'You Have a New Query Match';   
                                $to = $lawyer->email;                        
                                \Mail::to($to)->send(new NotifMail($details));
                            }
                        } 
                    }
                }
            }

        }elseif($request->input('action') == 'declineProof')
        {
            $queries = Query::where('transaction_number', $request->transaction_number)->first();

            $request->validate([
                            'reason_of_Declined_Payment' => 'required',
                    ]);

            $queries->is_payment_verified = '3';
            $queries->reason_of_Declined_Payment = $request->reason_of_Declined_Payment;
            $queries->save();


            $details = [
            'title' => 'Declined Proof of Payment',
            'ReferenceNumber' => $queries->transaction_number,
            'body' => 'We are sorry to inform that your proof of payment is declined. Please submit another proof of payment to proceed transaction. Reason: ' .$queries->reason_of_Declined_Payment
            ];

            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $subject = 'Declined Proof of Payment';

            $to = $queries->client->email;

            \Mail::to($to)->send(new NotifMail($details));

            toast()->success('Success', 'Notified Client for Declined Proof of Payment ')->position('top-end');

            $lawyersAvailableCount = 0;
                $requestedDates = [$queries->available_date_1,$queries->available_date_2,$queries->available_date_3]; //save requested dates to  an array
                $requestedTimes = [$queries->available_time_1,$queries->available_time_2,$queries->available_time_3]; //save requested time to  an array
                
                $user_specializations = LawyerSpecialization::where('specialization_id',$queries->subject)->get();

                foreach($user_specializations as $user_specialization) {
                    
                    $lawyer = $user_specialization->user;
                    
                    if($queries->category = 'Online Consultation' && $lawyer->availability != 'Offline' && $lawyer->is_verified) {
                        
                        if($queries->resolution_type == 'Video Conference with a Lawyer') {
                            /** check for conflicts in schedule */
                            $conflicts = 0; //conflict counter
                            $lawyer_queries = $lawyer->queries->where('status','Pending');

                            if(count($lawyer_queries)>0) {
                                foreach($lawyer_queries as $lawyer_query) {
                                    foreach($requestedDates as $k => $requestedDate) {
                                        /** check if a query assigned to a lawyer 
                                         *  if requested date is the same, check also if the difference in time is more than 2 hours
                                         */
                                        if($lawyer_query->schedule_date==$requestedDate) { 
                                            $requestedTimeItem = Carbon\Carbon::parse($requestedDate.' '.$requestedTimes[$k]);
                                            if(Carbon\Carbon::parse($lawyer_query->schedule_date.' '.$lawyer_query->schedule_time)->diffInHours($requestedTimeItem)<2)
                                                $conflicts++;
                                        }
                                    }
                                }
                                if($conflicts==0) {
                                    $lawyersAvailableCount++;
                                    $details = [
                                        'title' => 'New Query Match',
                                        'ReferenceNumber' => $transaction_number,
                                        'body' => 'Please check your OnCon account, we have a new query that you might be interested with.' 
                                    ];
                                    $from = env('MAIL_FROM_ADDRESS');
                                    $name = env('MAIL_FROM_NAME');
                                    $subject = 'Approved Proof of Payment';   
                                    $to = $lawyer->email;                        
                                    \Mail::to($to)->send(new NotifMail($details));
                                }
                            }
                        } else {
                            $lawyersAvailableCount++;
                            $details = [
                                'title' => 'New Query Match',
                                'ReferenceNumber' => $queries->transaction_number,
                                'body' => 'Please check your OnCon account, we have a new query that you might be interested with.' 
                            ];
                            $from = env('MAIL_FROM_ADDRESS');
                            $name = env('MAIL_FROM_NAME');
                            $subject = 'You Have a New Query Match';   
                            $to = $lawyer->email;                        
                            \Mail::to($to)->send(new NotifMail($details));
                        }
                    } else if($queries->category = 'Offline Consultation' && $lawyer->availability == 'Offline' && $lawyer->is_verified) {

                        $lawyersAvailableCount++;
                        $details = [
                            'title' => 'New Query Match',
                            'ReferenceNumber' => $transaction_number,
                            'body' => 'Please check your OnCon account, we have a new query that you might be interested with.' 
                        ];
                        $from = env('MAIL_FROM_ADDRESS');
                        $name = env('MAIL_FROM_NAME');
                        $subject = 'You Have a New Query Match';   
                        $to = $lawyer->email;                        
                        \Mail::to($to)->send(new NotifMail($details));
                    }
                }

                /**if no lawyers available */
                if($lawyersAvailableCount==0) {

                    //send email to all lawyers with that specialization
                    foreach($user_specializations as $user_specialization) {
                        $lawyer = $user_specialization->user;
                        if($queries->category = 'Online Consultation' && $lawyer->availability != 'Offline' && $lawyer->is_verified) {
                            $lawyersAvailableCount++;
                            $details = [
                                'title' => 'New Query Match',
                                'ReferenceNumber' => $transaction_number,
                                'body' => 'Please check your OnCon account, we have a new query that you might be interested with.' 
                            ];
                            $from = env('MAIL_FROM_ADDRESS');
                            $name = env('MAIL_FROM_NAME');
                            $subject = 'You Have a New Query Match';   
                            $to = $lawyer->email;                        
                            \Mail::to($to)->send(new NotifMail($details));
                        } else if($queries->category = 'Offline Consultation' && $lawyer->availability == 'Offline' && $lawyer->is_verified) {
                            $lawyersAvailableCount++;
                            $details = [
                                'title' => 'New Query Match',
                                'ReferenceNumber' => $transaction_number,
                                'body' => 'Please check your OnCon account, we have a new query that you might be interested with.' 
                            ];
                            $from = env('MAIL_FROM_ADDRESS');
                            $name = env('MAIL_FROM_NAME');
                            $subject = 'You Have a New Query Match';   
                            $to = $lawyer->email;                        
                            \Mail::to($to)->send(new NotifMail($details));
                        }
                    }

                    //if no lawyer is still available, send to general lawyers
                    if($lawyersAvailableCount==0) {
                        //get general lawyers
                        $user_specializations = LawyerSpecialization::where('specialization_id',1)->get();
                        foreach($user_specializations as $user_specialization) {
                            $lawyer = $user_specialization->user;
                            if($queries->category = 'Online Consultation' && $lawyer->availability != 'Offline' && $lawyer->is_verified) {
                                $lawyersAvailableCount++;
                                $details = [
                                    'title' => 'New Query Match',
                                    'ReferenceNumber' => $transaction_number,
                                    'body' => 'Please check your OnCon account, we have a new query that you might be interested with.' 
                                ];
                                $from = env('MAIL_FROM_ADDRESS');
                                $name = env('MAIL_FROM_NAME');
                                $subject = 'You Have a New Query Match';   
                                $to = $lawyer->email;                        
                                \Mail::to($to)->send(new NotifMail($details));
                            } else if($queries->category = 'Offline Consultation' && $lawyer->availability == 'Offline' && $lawyer->is_verified) {
                                $lawyersAvailableCount++;
                                $details = [
                                    'title' => 'New Query Match',
                                    'ReferenceNumber' => $transaction_number,
                                    'body' => 'Please check your OnCon account, we have a new query that you might be interested with.' 
                                ];
                                $from = env('MAIL_FROM_ADDRESS');
                                $name = env('MAIL_FROM_NAME');
                                $subject = 'You Have a New Query Match';   
                                $to = $lawyer->email;                        
                                \Mail::to($to)->send(new NotifMail($details));
                            }
                        } 
                    }
                }
        }

        return redirect()->route('admin.dashboard');

    }

    public function AccountDetails($id)
    {
        $users = User::where('id', $id)->first();

        return view('admin.user', compact('users'));
    }

    public function ApproveLawyer(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        if($request->input('action') == 'approve')
        {
            $details = [
            'title' => 'Account Verified',
            'ReferenceNumber' => $user->user_number,
            'body' => 'Your account has been successfully verified'
            
            ];

            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            

            $subject = 'Account Successfully Approved';

        
            
            $to = $user->email;
            $user->is_verified = 1;
            $user->save();

            \Mail::to($to)->send(new NotifMail($details));

            toast()->success('Success', 'Approved Successfully')->position('top-end');
        }elseif($request->input('action') == 'decline')
        {
            $details = [
            'title' => 'Account Declined',
            'body' => 'Your account was declined due to invalid proof',
            'ReferenceNumber' => $user->user_number
            ];

            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $subject = 'Account Registration Declined';   

            $user = User::findOrFail($request->user_id);
            $user->is_verified = 0;
            $user->save();

            $to = $user->email;
            \Mail::to($to)->send(new NotifMail($details));

            toast()->success('Success', 'Account Declined')->position('top-end');
        }
    

        

        return redirect()->route('admin.account', 2);
    }

    public function DeclineLawyer(Request $request)
    {
        $details = [
            'title' => 'Account Declined',
            'body' => 'Your account has been declined.',
            'ReferenceNumber' => $user->user_number
        ];


        $from = env('MAIL_FROM_ADDRESS');
        $name = env('MAIL_FROM_NAME');
        $to = 'email here';
        $subject = 'Account Registration Declined';


        $user = User::findOrFail($request->user_id);
        $toname = $user->email;
        $user->is_verified = 0;
        $user->save();

        \Mail::to($to)->send(new NotifMail($details));
        toast()->success('Success', 'Declined Successfully')->position('top-end');

        return redirect()->route('admin.account', 2);
    }

    public function createnewadmin()
    {
        return view('admin.storeNewAdmin');
    }

    public function StoreNewAdmin(Request $request){
        
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'contact_number' => 'required'
        ]);

        $randon_number = random_int(100000, 999999);
        
        $users = new User();
        $users->user_number = $randon_number;
        $users->first_name = request()->first_name;
        $users->last_name = request()->last_name;
        $users->contact_number = request()->contact_number;
        $users->email = request()->email;
        $users->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
        $users->password = Hash::make('adminadmin');
        $users->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $users->is_verified = '1';
        $users->role_id = '3';
        $users->save();

        $details = [
            'title' => 'You are a New Admin',
            'ReferenceNumber' => $users->user_number,   
            'body' => 'We have created a new account for you. Please use your email address and the default password (adminadmin) for logging in'
            ];

            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $subject = 'You are a New Admin';

            $to = $users->email;

            \Mail::to($to)->send(new NotifMail($details));

        toast()->success('Success', 'New Admin Created!')->position('top-end');

        return redirect()->route('admin.dashboard');
    }

    public function Audits()
    {
       $audits = Audit::get();
        return view('admin.audit', compact('audits'));
    }
}
