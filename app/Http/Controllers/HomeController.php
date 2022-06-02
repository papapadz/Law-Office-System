<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;
use App\ContactUs;
use Alert;
use Illuminate\Mail\Mailer;
use App\Mail\NotifMail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
     public function FAQs()
    {
        return view('FAQs');
    }

    public function privacyPolicy()
    {
        return view('privacyPolicy');
    }

    public function termsAndCondition()
    {
        return view('termsAndCondition');
    }

    public function about()
    {
        $feedbacks = Feedback::where('status', 'Approved')->with('client', 'queries')->get();

        return view('about', compact('feedbacks'));
    }

    public function services()
    {
        return view('services');
    }

    public function contact()
    {
        return view('contact');
    }

    public function SubmitContact(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'contact_number' => 'required|numeric|digits:11',
            'subject' => 'required',
            'question' => 'required',
            ]);


        $randon_number = random_int(100000, 999999);

        $contacts = new ContactUs();
        $contacts->inquiry_number = $randon_number;
        $contacts->first_name = $request->first_name;
        $contacts->last_name = $request->last_name;
        $contacts->email = $request->email;
        $contacts->contact_number = $request->contact_number;
        $contacts->subject = $request->subject;
        $contacts->question = $request->question;
        $contacts->save();

        $details = [
                'title' => 'We have receieved your inquiry',
                'ReferenceNumber' => $contacts->inquiry_number,
                'body' => 'We have receieved your inquiry: ' .$request->question. '. Please wait for a reply from our Admin regarding the inquiry. Talk to you soon!' 
            ];

            $from = env('MAIL_FROM_ADDRESS');
            $name = env('MAIL_FROM_NAME');
            $subject = 'Inquiry Received';

            $to = $contacts->email;

            \Mail::to($to)->send(new NotifMail($details));

        toast()->success('Success', 'Inquiry successfully sent')->position('top-end');

        return redirect()->route('contact');

    }
}
