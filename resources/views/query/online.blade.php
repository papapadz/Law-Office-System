@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-primary-color">
                <div class="card-body">
                    <div class="mx-auto">
                        <h4 class="text-center text-white font-weight-bold">
                            SEND A QUERY
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="container">
                        <form method="POST" action={{ route('online.query') }}>
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input readonly id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ auth()->user()->first_name }} {{ auth()->user()->last_name }} " required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input readonly id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ auth()->user()->email }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contact_number" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number') }}</label>

                                <div class="col-md-6">
                                    <input readonly id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ auth()->user()->contact_number }}" required autocomplete="contact_number" autofocus>

                                    @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="subject" class="col-md-4 col-form-label text-md-right">{{ __('Subject of Query') }}</label>

                                <div class="col-md-6">
                                    <select name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" name="subject" required>
                                        <option style="display:none;">Please select</option>
                                        <option value="General" >I am not sure of the subject</option>
                                        <option value="Business and Corporate Law" >Business and Corporate Law</option>
                                        <option value="Litigation" >Litigation</option>
                                        <option value="Labor Law" >Labor Law</option>
                                        <option value="Intellectual Property" >Intellectual Property</option>
                                        <option value="Entertainment Law">Entertainment Law</option>
                                        <option value="Family Law (Marriage, Child, etc.)" >Family Law (Marriage, Child, etc.)</option>
                                        <option value="Property Law">Property Law</option>
                                        <option value="Tax Law" >Tax Law</option>
                                        <option value="Data Privacy Law" >Data Privacy Law</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="question" class="col-md-4 col-form-label text-md-right">{{ __('Questions / Concerns') }}</label>

                                <div class="col-md-6">
                                    <textarea rows="5" style="resize: none;" id="question" type="text" class="form-control @error('question') is-invalid @enderror" name="question" value="{{ old('question') }}" required autocomplete="question"></textarea>

                                    @error('question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="resolution_type" class="col-md-4 col-form-label text-md-right">{{ __('Choose Resolution') }}</label>

                                <div class="col-md-6">
                                    <input type="radio" name="resolution_type" id="written" value="Written Resolution from a Lawyer" checked="" />
                                    <label for="written">Written Resolution</label>
                                    <br>
                                    <input type="radio" name="resolution_type" id="video" value="Video Conference with a Lawyer"/>
                                    <label for="video">Video Consultation</label>  
                                    
                                    <p class="written type"  style="font-size:x-small;"><br>
                                        You have selected <strong>Written Resolution</strong> This is a non-video type of service that provides you a non-verbal means of communication with the lawyer. You will have to send a detailed description of the query to the lawyer, in which the lawyer will write a reply about the query that you've sent. NOTE: lawyer will only send a reply once you have provided your proof of payment.
                                    </p>     

                                    <p class="video type" style="font-size:x-small;"><br>You have selected <strong>Video Consultation</strong>, video conferencing or video resolution is a type of online meeting in which both the you and the lawyer are engaged in a live audio-visual call. You and the lawyer can see, hear and talk to each other in realtime. You just have to be sure sure about the schedule that you chose because you can only reschedule a video conference with a lawyer 3 times. NOTE: you will only receive the google meet link once you have provided your proof of payment
                                    </p>  
                                </div>                                  
                            </div>

                            <div class="video type">
                                <div class="form-group">
                                    <div class="form-group row">
                                        <label for="schedule" class="col-md-12 col-form-label text-md-center">{{ __('Please provide three (3) available specific schedules') }}</label>
                                    </div>

                                    <div class="form-group row" >
                                        <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Available Schedule') }}</label>

                                        <div class="col-md-6 d-flex">
                                            <input min={{ now()->addDay(1) }} id="available_date_1" type="date" class="form-control @error('available_date_1') is-invalid @enderror" name="available_date_1"  autofocus>

                                            <select  name="available_time_1" id="available_time_1" class="form-control @error('available_time_1') is-invalid @enderror">
                                                <option value="08:00 AM">08:00 AM</option>
                                                <option value="08:30 AM">08:30 AM</option>
                                                <option value="09:00 AM">09:00 AM</option>
                                                <option value="09:30 AM">09:30 AM</option>
                                                <option value="10:00 AM">10:00 AM</option>
                                                <option value="10:30 AM">10:30 AM</option>
                                                <option value="11:00 AM">11:00 AM</option>
                                                <option value="11:30 AM">11:30 AM</option>
                                                <option value="12:00 PM">12:00 PM</option>
                                                <option value="12:30 PM">12:30 PM</option>
                                                <option value="01:00 PM">01:00 PM</option>
                                                <option value="01:30 PM">01:30 PM</option>
                                                <option value="02:00 PM">02:00 PM</option>
                                                <option value="02:30 PM">02:30 PM</option>
                                                <option value="03:00 PM">03:00 PM</option>
                                                <option value="03:30 PM">03:30 PM</option>
                                                <option value="04:00 PM">04:00 PM</option>
                                                <option value="04:30 PM">04:30 PM</option>
                                                <option value="05:00 PM">05:00 PM</option>
                                                <option value="05:30 PM">05:30 PM</option>
                                                <option value="06:00 PM">06:00 PM</option>
                                                <option value="06:30 PM">06:30 PM</option>
                                            </select>

                                            @error('schedule')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Available Schedule') }}</label>

                                        <div class="col-md-6 d-flex">
                                            <input  min={{ now()->addDay(1) }} id="available_date_2" type="date" class="form-control @error('available_date_2') is-invalid @enderror" name="available_date_2"   autofocus>


                                            <select  name="available_time_2" id="available_time_2" class="form-control @error('available_time_2') is-invalid @enderror">
                                                <option value="08:00 AM">08:00 AM</option>
                                                <option value="08:30 AM">08:30 AM</option>
                                                <option value="09:00 AM">09:00 AM</option>
                                                <option value="09:30 AM">09:30 AM</option>
                                                <option value="10:00 AM">10:00 AM</option>
                                                <option value="10:30 AM">10:30 AM</option>
                                                <option value="11:00 AM">11:00 AM</option>
                                                <option value="11:30 AM">11:30 AM</option>
                                                <option value="12:00 PM">12:00 PM</option>
                                                <option value="12:30 PM">12:30 PM</option>
                                                <option value="01:00 PM">01:00 PM</option>
                                                <option value="01:30 PM">01:30 PM</option>
                                                <option value="02:00 PM">02:00 PM</option>
                                                <option value="02:30 PM">02:30 PM</option>
                                                <option value="03:00 PM">03:00 PM</option>
                                                <option value="03:30 PM">03:30 PM</option>
                                                <option value="04:00 PM">04:00 PM</option>
                                                <option value="04:30 PM">04:30 PM</option>
                                                <option value="05:00 PM">05:00 PM</option>
                                                <option value="05:30 PM">05:30 PM</option>
                                                <option value="06:00 PM">06:00 PM</option>
                                                <option value="06:30 PM">06:30 PM</option>
                                            </select>

                                            @error('schedule')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Available Schedule') }}</label>

                                        <div class="col-md-6 d-flex">
                                            <input  min={{ now()->addDay(1) }} id="available_date_3" type="date" class="form-control @error('available_date_3') is-invalid @enderror" name="available_date_3" autofocus>

                                            <select  name="available_time_3" id="available_time_3" class="form-control @error('available_time_3') is-invalid @enderror">
                                                <option value="08:00 AM">08:00 AM</option>
                                                <option value="08:30 AM">08:30 AM</option>
                                                <option value="09:00 AM">09:00 AM</option>
                                                <option value="09:30 AM">09:30 AM</option>
                                                <option value="10:00 AM">10:00 AM</option>
                                                <option value="10:30 AM">10:30 AM</option>
                                                <option value="11:00 AM">11:00 AM</option>
                                                <option value="11:30 AM">11:30 AM</option>
                                                <option value="12:00 PM">12:00 PM</option>
                                                <option value="12:30 PM">12:30 PM</option>
                                                <option value="01:00 PM">01:00 PM</option>
                                                <option value="01:30 PM">01:30 PM</option>
                                                <option value="02:00 PM">02:00 PM</option>
                                                <option value="02:30 PM">02:30 PM</option>
                                                <option value="03:00 PM">03:00 PM</option>
                                                <option value="03:30 PM">03:30 PM</option>
                                                <option value="04:00 PM">04:00 PM</option>
                                                <option value="04:30 PM">04:30 PM</option>
                                                <option value="05:00 PM">05:00 PM</option>
                                                <option value="05:30 PM">05:30 PM</option>
                                                <option value="06:00 PM">06:00 PM</option>
                                                <option value="06:30 PM">06:30 PM</option>
                                            </select>

                                            @error('schedule')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="policy" id="policy" {{ old('policy') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="policy">

                                         I have read and agree to the <a href="{{ url('/privacyPolicy') }}" target="_blank">Privacy Policy</a>
                                     </label>
                                 </div>
                             </div>
                         </div>

                         <div class="form-group row">
                            <div class="mx-auto">
                                <button class="btn btn-primary-btn text-white">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection