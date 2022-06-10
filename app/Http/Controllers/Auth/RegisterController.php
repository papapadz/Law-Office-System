<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Specialization;
use App\LawyerSpecialization;
use App\LawyerTimeFrame;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::LOGIN;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'numeric', 'digits:11'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_id' => ['required', 'exists:roles,id'],
            'specialization' =>['required_if:role_id,2'],
            'availability' =>['required_if:role_id,2'],
            'location' =>['required_if:role_id,2'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'captcha' => ['required','captcha'], /** captcha */
            'policy' => ['required'], /** require policy input checkbox */
            
            /** available lawyer time from and to*/
            'timeframe_from' => ['required'], 
            'timeframe_to' => ['required','after:timeframe_from']
        ],[
            'captcha.captcha' => 'CAPTCHA validation failed, try again', /** custom error message for captcha */
            'policy.required' => 'Please read and accept our Terms and Conditions' /** custom error message for policy input checkbox */
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        if(request()->roll_number != '')
        {

            $roll_number = request()->roll_number;

        }else{
            $roll_number = null;
        }

        if(isset($data['photo_proof']))
        {
            $photo_proof = request()->file('photo_proof')->storeOnCloudinary('lawyer_proof/')->getSecurePath();
        }else{
             $photo_proof = null;
        }

        $randon_number = random_int(100000, 999999);
        
        if(request()->role_id == 2){
            /** Create a User */
            $user = User::create([
                'user_number' => $randon_number,
                'first_name' => ucfirst($data['first_name']),
                'last_name' => $data['last_name'],
                'contact_number' => $data['contact_number'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
                'specialization' => 'x',
                'availability' =>$data['availability'],
                'location' =>$data['location'],
                'password' => Hash::make($data['password']),
                'roll_number' => $roll_number,
                'proof_photo_path' => $photo_proof
            ]);
            
            /** Add specializations to the table */
            $specializationText = '';
            foreach($data['specialization'] as $specializationId)  {
                $specializationText .= Specialization::find($specializationId)->specialization.',';
                LawyerSpecialization::create([
                    'user_id' => $user->id,
                    'specialization_id' => $specializationId
                ]);
            }
            
            /** update lawyer specialization */
            User::where('id',$user->id)->update([
                'specialization' => $specializationText
            ]);
            
            /** add lawyer time frames */
            LawyerTimeFrame::create([
                'lawyer_id' => $user->id,
                'from' => $data['timeframe_from'],
                'to' => $data['timeframe_to']
            ]);

            return $user;
        }
        else
        {
             return User::create([
            'user_number' => $randon_number,
            'first_name' => ucfirst($data['first_name']),
            'last_name' => $data['last_name'],
            'contact_number' => $data['contact_number'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
            'password' => Hash::make($data['password']),
            'roll_number' => $roll_number,
            'proof_photo_path' => $photo_proof
        ]);
        }
        

       
    }

    /** show registration form */
    public function showRegistrationForm()
    {
        $specializations = Specialization::get();
        return view('auth.register',compact('specializations'));
    }

    /** Captcha Reload */
    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
