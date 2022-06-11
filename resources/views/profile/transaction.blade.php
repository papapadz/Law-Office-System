@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center mx-auto">
        <div class="col-md-10">
         <div class="card mt-3 mx-auto">
            <div class="card-header text-center bg-primary-color text-white">
                <a class="text-white" href="{{ route('user.queries') }}">My Transactions ( Step
                    @if( $queries->status=='Complete')
                        6
                    @elseif($queries->is_payment_verified && $queries->status=='In-Progress')
                        5
                    @elseif($queries->proof_photo_url && $queries->status=='Pending')
                        4
                    @elseif(!$queries->is_payment_verified)
                        3
                    @endif
                    )
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('user.accept') }}" method="POST">
                    @csrf
                    <div class="container">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Transaction Number') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="transaction_number" readonly value="{{ $queries->transaction_number }}" required autocomplete="transaction_number" autofocus>

                                @error('transaction_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Type of Service') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="category" readonly value="{{ $queries->category }}" required autocomplete="category" autofocus>

                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="status" readonly value="{{ $queries->status }}" required autocomplete="status" autofocus>

                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        @if($queries->status == 'Declined')
                        <div class="form-group-row">
                            <div class="form-group row">
                                <label for="subject" class="col-md-4 col-form-label text-md-right">{{ __('Subject of Query') }}</label>

                                <div class="col-md-6">
                                    <select name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" name="subject" required>
                                        <option value="1" selected>I am not sure of the subject</option>
                                        @foreach($specializations as $specialization)
                                        <option value="{{ $specialization->id }}" >{{ $specialization->specialization }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="form-group row">
                            <label for="question" class="col-md-4 col-form-label text-md-right">{{ __('Questions / Concerns') }}</label>

                            <div class="col-md-6">
                                <textarea rows="5" style="resize: none;" id="question" type="text" class="form-control @error('question') is-invalid @enderror" name="question" @if(!$queries->declined_id) readonly @endif value="{{ old('question') }}" required autocomplete="question">{{ $queries->question }}</textarea>

                                @error('question')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        @if($queries->status == 'Declined')
                        <div class="video type">
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="schedule" class="col-md-12 col-form-label text-md-center">{{ __('Please provide three another (3) available specific schedules') }}</label>
                                </div>

                                <div class="form-group row" >
                                    <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Available Schedule') }}</label>

                                    <div class="col-md-6 d-flex">
                                        <input min={{ now()->addDay(1) }} max="{{ now()->addYear()->toDateString() }}" id="available_date_1" type="date" class="form-control @error('available_date_1') is-invalid @enderror" name="available_date_1"  autofocus>

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
                                        <input  min={{ now()->addDay(1) }} max="{{ now()->addYear()->toDateString() }}" id="available_date_2" type="date" class="form-control @error('available_date_2') is-invalid @enderror" name="available_date_2"   autofocus>


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
                                        <input  min={{ now()->addDay(1) }} max="{{ now()->addYear()->toDateString() }}" id="available_date_3" type="date" class="form-control @error('available_date_3') is-invalid @enderror" name="available_date_3" autofocus>

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
                        @endif
                        @if($queries->is_payment_verified == '1')

                        @if($queries->category == 'Offline Consultation' && $queries->lawyer!=null)
                        <div class="form-group row">
                            <label for="lawyer_id" class="col-md-4 col-form-label text-md-right">{{ __('Chosen Lawyer') }}</label>

                            <div class="col-md-6">
                                <select readonly disabled name="lawyer_id" id="lawyer_id" class="form-control @error('lawyer_id') is-invalid @enderror" name="lawyer_id" required>

                                    <option value="{{ $queries->lawyer_id }}">{{ $queries->lawyer->first_name }} {{ $queries->lawyer->last_name }} -- {{ $queries->lawyer->location }}  ({{ $queries->lawyer->specialization }})</option>

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Schedule') }}</label>

                            <div class="col-md-6 d-flex">
                                <input readonly disabled min={{ now()->addDay(1) }} id="schedule_date" type="date" class="form-control @error('schedule') is-invalid @enderror" name="schedule_date" value="{{ $queries->schedule_date }}" required autocomplete="schedule" autofocus>


                                <select readonly disabled name="schedule_time" id="schedule_time" class="form-control @error('schedule_time') is-invalid @enderror">
                                    <option selected value="{{ $queries->schedule_time }}" readonly> {{ $queries->schedule_time }}</option>
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

                        @if($queries->status == 'Approved')
                        <div class="form-group row">
                            <label for="body" class="col-md-4 col-form-label text-md-right">{{ __('Reply from Lawyer (Reminder before going to the office') }}</label>

                            <div class="col-md-6">
                                <textarea readonly disabled rows="10" style="resize: none;" id="reply_offline" type="text" class="form-control @error('body') is-invalid @enderror" name="reply_offline" value="{{ $queries->reply_offline }}"  autocomplete="body">{{ $queries->reply_offline }}</textarea>

                                @error('body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        @elseif($queries->status == 'Declined')
                        <div class="form-group row"> 
                            <div class="col-md-12">          
                                <center>Your query was declined</center>
                            </div>
                        </div>

                        
                        @endif


                        @elseif($queries->category == 'Online Consultation')

                        <div class="form-group row">
                            <label for="resolution_type" class="col-md-4 col-form-label text-md-right">{{ __('Chosen Resolution') }}</label>

                            <div class="col-md-6">
                                <select readonly disabled name="resolution_type" id="resolution_type" class="form-control @error('resolution_type') is-invalid @enderror" name="resolution_type" required>
                                    <option readonly value="">{{ $queries->resolution_type }}</option>
                                    <option readonly value="1">Written Resolution from a Lawyer</option>
                                    {{-- <option readonly value="2">Video Conference with a Lawyer</option>
                                    <option readonly value="3">Voice Conference with a Lawyer</option> --}}
                                </select>
                            </div>
                        </div>

                        @if($queries->lawyer)
                        <div class="form-group row">
                            <label for="lawyer_id" class="col-md-4 col-form-label text-md-right">{{ __('You are assigned to: ') }}</label>

                            <div class="col-md-6">
                                <select readonly disabled name="lawyer_id" id="lawyer_id" class="form-control @error('lawyer_id') is-invalid @enderror" name="lawyer_id" required>

                                    <option value="{{ $queries->lawyer_id }}">{{ $queries->lawyer->first_name }} {{ $queries->lawyer->last_name }} -- {{ $queries->lawyer->location }}  ({{ $queries->lawyer->specialization }})</option>

                                </select>
                            </div>
                        </div>
                        @endif

                        @if($queries->resolution_type == 'Written Resolution from a Lawyer' && $queries->status == 'Complete')

                        <div class="form-group row">
                            <label for="body" class="col-md-4 col-form-label text-md-right">{{ __('Reply from Lawyer') }}</label>

                            <div class="col-md-6">
                                <textarea rows="10" style="resize: none;" id="body" type="text" class="form-control @error('body') is-invalid @enderror" name="body" readonly value="{{ old('body') }}" required autocomplete="body">{{ $queries->reply_to_written_resolution }}</textarea>

                                @error('body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="body" class="col-md-4 col-form-label text-md-right">{{ __('Attach file') }}</label>

                            <div class="col-md-6">

                             @if($queries->attached_file != null)
                             <a target="_blank" href="{{ $queries->attached_file }}">
                                <label><strong>See Attached File Here</strong></label>
                            </a> 
                            @else
                            <strong>No Available Attached File </strong>
                            @endif


                            @error('attach_file')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    @elseif($queries->resolution_type == 'Video Conference with a Lawyer' && $queries->status == 'Pending')
                    <div class="form-group row">
                        <label for="schedule" class="col-md-12 col-form-label text-md-center">{{ __('Three (3) provided available specific schedules') }}</label>

                    </div>

                    <div class="form-group row">
                        <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Available Schedule') }}</label>

                        <div class="col-md-6 d-flex">
                            <input readonly value="{{ $queries->available_date_1 }}" min={{ now()->addDay(1) }} id="available_date_1" type="date" class="form-control @error('available_date_1') is-invalid @enderror" name="available_date_1" value="{{ $queries->available_date_1 }}" required autocomplete="schedule" autofocus>


                            <select readonly name="available_time_1" id="available_time_1" class="form-control @error('available_time_1') is-invalid @enderror">
                                <option selected value="{{ $queries->available_time_1 }}"> {{ $queries->available_time_1 }}</option>
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
                            <input readonly value="{{ $queries->available_date_2 }}" min={{ now()->addDay(1) }} id="available_date_2" type="date" class="form-control @error('available_date_2') is-invalid @enderror" name="available_date_2"  value="{{ $queries->available_date_1 }}" required autocomplete="schedule" autofocus>


                            <select readonly name="available_time_2" id="available_time_2" class="form-control @error('available_time_2') is-invalid @enderror">
                                <option selected value="{{ $queries->available_time_2 }}"> {{ $queries->available_time_2 }}</option>
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
                            <input readonly value="{{ $queries->available_date_3 }}" min={{ now()->addDay(1) }} id="available_date_3" type="date" class="form-control @error('available_date_3') is-invalid @enderror" name="available_date_3" value="{{ $queries->available_date_1 }}" required autocomplete="schedule" autofocus>


                            <select readonly name="available_time_3" id="available_time_3" class="form-control @error('available_time_3') is-invalid @enderror">
                                <option selected value="{{ $queries->available_time_3 }}"> {{ $queries->available_time_3 }}</option>
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

                    @elseif($queries->resolution_type == 'Video Conference with a Lawyer' && $queries->status == 'In-Progress')
                    <div class="form-group row">

                        <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Choosen Schedule: ') }}</label>

                        <div class="col-md-6 d-flex">

                            <input readonly disabled value="{{ $queries->schedule_date }}" min={{ now()->addDay(1) }} id="schedule_date" type="date" class="form-control @error('schedule_date') is-invalid @enderror" name="schedule_date" value="{{ $queries->schedule_date }}" required autocomplete="schedule" autofocus>


                            <select readonly disabled name="schedule_time" id="schedule_time" class="form-control @error('schedule_time') is-invalid @enderror">
                                <option selected value="{{ $queries->schedule_time }}" readonly> {{ $queries->schedule_time }}</option>
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
                    @elseif($queries->resolution_type == 'Video Conference with a Lawyer' && $queries->status == 'Complete')
                    <div class="form-group row">

                        <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Choosen Schedule: ') }}</label>

                        <div class="col-md-6 d-flex">

                            <input readonly disabled value="{{ $queries->schedule_date }}" min={{ now()->addDay(1) }} id="schedule_date" type="date" class="form-control @error('schedule_date') is-invalid @enderror" name="schedule_date" value="{{ $queries->schedule_date }}" required autocomplete="schedule" autofocus>


                            <select readonly disabled name="schedule_time" id="schedule_time" class="form-control @error('schedule_time') is-invalid @enderror">
                                <option selected value="{{ $queries->schedule_time }}" readonly> {{ $queries->schedule_time }}</option>
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
                        <label for="summary" class="col-md-4 col-form-label text-md-right">{{ __('Summary of Consultation') }}</label>

                        <div class="col-md-6">
                            <textarea rows="10" style="resize: none;" id="summary" type="text" class="form-control @error('summary') is-invalid @enderror" name="summary" readonly value="{{ old('summary_from_lawyer') }}" required autocomplete="summary">{{ $queries->summary_from_lawyer }}</textarea>

                            @error('summary')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                </div>
                @endif
                @endif

                @if($queries->status == 'Declined')
                <div class="form-group row">
                    <div class="mx-auto">
                        <button name="action" value="decline-reschedule" class="btn btn-primary-btn bg-primary-color text-white">
                            Submit Query Again
                        </button>
                    </div>
                </div>
                @endif
                
                @if($queries->status == 'Complete' && $feedback_check == 0 || $queries->status == 'Approved' && $feedback_check == 0 )
                <div class="form-group row">
                    <label for="feedback" class="col-md-4 col-form-label text-md-right">{{ __('Feedback') }}</label>

                    <div class="col-md-6">
                        <textarea rows="5" style="resize: none;" id="feedback" type="text" class="form-control @error('feedback') is-invalid @enderror" name="feedback" value="{{ old('feedback') }}" required autocomplete="feedback"></textarea>

                        @error('feedback')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                @endif


                <div class="form-group row">
                    <div class="mx-auto">
                        @if($queries->status == 'Complete' && $feedback_check == 0 || $queries->status == 'Approved' && $feedback_check == 0)
                        <button name="action" value="feedback" class="btn btn-primary-btn bg-primary-color text-white">
                            Send Feedback
                        </button>
                        @endif
                    </div>
                </div>

                @else
                <div class="card-body">
                    <div class="container mx-auto">
                        <h5 class="text-center">

                            <a href="{{ route('payment.details', $queries->transaction_number) }}" class="btn btn-primary-btn bg-primary-color text-white">
                                Payment Instruction
                            </a>
                            <br><br><small>Please secure payment to view other details.</small> 
                        </h5>
                    </div>
                </div>
                @endif
            </div>
        </form>
    </div>

    @if(($event_check && $queries->status == 'In-Progress' && $queries->is_payment_verified == 1) )
    <div class="card-body">
        <div class="container mx-auto">
            <h5 class="text-center">Your Meeting starts at {{ $event_check->start_time }} and ends at {{ $event_check->end_time }}. 
                <br>
                
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#googleMeetModal">
                    Show Meeting Link
                </button>
            </h5>
        </div>
    </div>
    @endif

</div> 
</div>

<!-- Modal -->
@if(($event_check && $queries->status == 'In-Progress' && $queries->is_payment_verified == 1) )
<div class="modal fade" id="googleMeetModal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Reminder</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse fermentum mattis finibus. Praesent tincidunt aliquet metus, id egestas leo suscipit in. Nulla aliquam, nulla nec venenatis accumsan, est felis scelerisque justo, vel efficitur nisi elit eget nibh. Maecenas dapibus massa felis, non venenatis neque euismod ut. Etiam varius enim nisl, et iaculis libero rhoncus sit amet. Vestibulum non sagittis mi. Suspendisse euismod quis ante ut laoreet. Praesent ut mollis nulla.

            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed at ullamcorper erat. Nam tincidunt enim erat, nec fermentum sem volutpat gravida. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla facilisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse sed felis egestas, sagittis magna a, luctus libero. Sed nec tellus imperdiet, dignissim purus vitae, facilisis ligula. Nam vitae condimentum felis, eu fringilla metus. Sed aliquet nisl vitae magna auctor, vitae placerat dui vulputate. Quisque vel feugiat mi, in fermentum orci. Pellentesque a mi dui. Quisque tempor dui nec lorem venenatis, quis lacinia augue luctus. Praesent malesuada suscipit velit, dictum sodales libero efficitur non. Maecenas congue pretium tellus.
            
            In aliquam laoreet ex, vitae sagittis metus aliquam quis. Sed a vehicula nisl, vitae lobortis quam. Fusce augue metus, commodo id placerat sit amet, ullamcorper a purus. Donec ultricies dignissim ornare. Integer sed erat sit amet sem efficitur commodo. Praesent vehicula interdum metus, vel interdum odio elementum a. Ut libero lorem, porta vel eleifend nec, pretium bibendum nisi. Pellentesque et auctor magna, fermentum lacinia est. Etiam ligula urna, sollicitudin id sodales ut, tempus nec mi. Sed sit amet sem id justo mattis rutrum. Cras erat libero, vehicula vitae ipsum sed, maximus bibendum quam.
            
            Vestibulum in euismod libero. Etiam ultricies arcu nibh, vitae dapibus quam sollicitudin in. Ut blandit ipsum nec lorem porta luctus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas nec tempor eros. Duis a dignissim turpis, eget lobortis lorem. Vestibulum vehicula, massa id imperdiet convallis, urna est lacinia risus, lacinia porttitor enim ipsum in libero. Sed pulvinar id mauris facilisis lobortis. Suspendisse ac vulputate nisi. Sed vitae arcu turpis. Cras auctor ante sit amet purus commodo fringilla. Etiam vel massa nisi. Donec molestie et metus quis efficitur. Integer mauris quam, feugiat venenatis ex at, imperdiet commodo dui.
          </p>
          <a class="btn btn-primary" target="_blank" href="{{ $event_check->meeting_link }}">{{ $event_check->meeting_link }}</a></strong>
        </div>
      </div>
    </div>
  </div>
@endif

@endsection
