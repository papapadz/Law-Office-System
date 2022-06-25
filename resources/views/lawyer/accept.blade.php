@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center mx-auto">
        <div class="col-md-10">
           <div class="card mt-3 mx-auto">
            <div class="card-header text-center bg-primary-color text-white">
                <a class="text-white" href="{{ route('user.queries') }}">My Transactions</a>

            </div>
            <div class="card-body">
                <form action="{{ route('lawyer.accept') }}"  method="POST" enctype='multipart/form-data'>
                    @csrf
                    @foreach($queries as $query)
                    <div class="container">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Transaction Number') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="transaction_number" readonly value="{{ $query->transaction_number }}" required autocomplete="transaction_number" autofocus>

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
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="category" readonly value="{{ $query->category }}" required autocomplete="category" autofocus>

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
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="status" readonly value="{{ $query->status }}" required autocomplete="status" autofocus>

                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" readonly value="{{ $query->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="question" class="col-md-4 col-form-label text-md-right">{{ __('Questions / Concerns') }}</label>

                            <div class="col-md-6">
                                <textarea rows="5" style="resize: none;" id="question" type="text" class="form-control @error('question') is-invalid @enderror" name="question" readonly value="{{ old('question') }}" required autocomplete="question">{{ $query->question }}</textarea>

                                @error('question')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        @if($query->category == 'Offline Consultation')
                        <div class="form-group row">
                            <label for="lawyer_id" class="col-md-4 col-form-label text-md-right">{{ __('Chosen Lawyer') }}</label>

                            <div class="col-md-6">
                                <select readonly disabled name="lawyer_id" id="lawyer_id" class="form-control @error('lawyer_id') is-invalid @enderror" name="lawyer_id" required>

                                    <option value="{{ $query->lawyer_id }}">{{ $query->lawyer->first_name }} {{ $query->lawyer->last_name }} -- {{ $query->lawyer->location }}  ({{ $query->lawyer->specialization }})</option>

                                </select>
                            </div>
                        </div>

                        @if($query->status != 'Approved')
                        <div class="form-group row">
                            <label for="schedule" class="col-md-12 col-form-label text-md-center">{{ __('Please choose one from the available schedules sent by the customer') }}</label>
                        </div>
                        
                        <div class="form-group row">
                            <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Option 1: ') }}
                                <input type="radio" id="schedule" name="schedule" value="{{ $query->available_date_1 }}{{"--"}}{{ $query->available_time_1}}" class="col-form-label text-md-right"></label>

                                <div class="col-md-6 d-flex">
                                    <input readonly disabled value="{{ $query->available_date_1 }}" min={{ now()->addDay(1) }} id="available_date_1" type="date" class="form-control @error('available_date_1') is-invalid @enderror" name="available_date_1" value="{{ $query->available_date_1 }}" required autocomplete="schedule" autofocus>


                                    <select readonly disabled name="available_time_1" id="available_time_1" class="form-control @error('available_time_1') is-invalid @enderror">
                                        <option selected value="{{ $query->available_time_1 }}"> {{ $query->available_time_1 }}</option>
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
                                <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Option 2: ') }}
                                    <input type="radio" id="schedule" name="schedule" value="{{ $query->available_date_2 }}{{"--"}}{{ $query->available_time_2}}" class="col-form-label text-md-right"></label>

                                    <div class="col-md-6 d-flex">
                                        <input readonly disabled value="{{ $query->available_date_2 }}" min={{ now()->addDay(1) }} id="available_date_2" type="date" class="form-control @error('available_date_2') is-invalid @enderror" name="available_date_2"  value="{{ $query->available_date_1 }}" required autocomplete="schedule" autofocus>


                                        <select readonly disabled name="available_time_2" id="available_time_2" class="form-control @error('available_time_2') is-invalid @enderror">
                                            <option  selected value="{{ $query->available_time_2 }}"> {{ $query->available_time_2 }}</option>
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
                                    <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Option 3: ') }}
                                        <input  type="radio" id="schedule" name="schedule" value="{{ $query->available_date_3 }}{{"--"}}{{ $query->available_time_3}}" class="col-form-label text-md-right" ></label>

                                        <div class="col-md-6 d-flex">
                                            <input readonly disabled value="{{ $query->available_date_3 }}" min={{ now()->addDay(1) }} id="available_date_3" type="date" class="form-control @error('available_date_3') is-invalid @enderror" name="available_date_3" value="{{ $query->available_date_1 }}" required autocomplete="schedule" autofocus>


                                            <select readonly disabled name="available_time_3" id="available_time_3" class="form-control @error('available_time_3') is-invalid @enderror">
                                                <option selected value="{{ $query->available_time_3 }}"> {{ $query->available_time_3 }}</option>
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
                                
                                <div class="form-group row">
                                    <label for="body" class="col-md-4 col-form-label text-md-right">{{ __('Reply from Lawyer (Reminder before going to the office') }}</label>

                                    <div class="col-md-6">
                                        <textarea rows="10" style="resize: none;" id="reply_offline" type="text" class="form-control @error('body') is-invalid @enderror" name="reply_offline" value="{{ $query->reply_offline }}"  autocomplete="body">{{ $query->reply_offline }}</textarea>

                                        @error('body')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>

                                @elseif($query->status == 'Approved')
                                <div class="form-group row">

                                    <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Choosen Schedule: ') }}</label>

                                    <div class="col-md-6 d-flex">

                                        <input readonly disabled value="{{ $query->schedule_date }}" min={{ now()->addDay(1) }} id="schedule_date" type="date" class="form-control @error('schedule_date') is-invalid @enderror" name="schedule_date" value="{{ $query->schedule_date }}" required autocomplete="schedule" autofocus>


                                        <select readonly disabled name="schedule_time" id="schedule_time" class="form-control @error('schedule_time') is-invalid @enderror">
                                            <option selected value="{{ $query->schedule_time }}"> {{ $query->schedule_time }}</option>
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
                                    <label for="body" class="col-md-4 col-form-label text-md-right">{{ __('Reply from Lawyer (Reminder before going to the office') }}</label>

                                    <div class="col-md-6">
                                        <textarea readonly disabled rows="10" style="resize: none;" id="reply_offline" type="text" class="form-control @error('body') is-invalid @enderror" name="reply_offline" value="{{ $query->reply_offline }}"  autocomplete="body">{{ $query->reply_offline }}</textarea>

                                        @error('body')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                @endif


                                @elseif($query->resolution_type == 'Written Resolution from a Lawyer' && $query->status != 'Complete' && $query->lawyer_id!=null)

                                <div class="form-group row">
                                    <label for="body" class="col-md-4 col-form-label text-md-right">{{ __('Reply from Lawyer') }}</label>

                                    <div class="col-md-6">
                                        <textarea rows="10" style="resize: none;" id="body" type="text" class="form-control @error('body') is-invalid @enderror" name="body" value="{{ $query->reply_to_written_resolution }}"  autocomplete="body">{{ $query->reply_to_written_resolution }}</textarea>

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
                                        <input id="name" type="file" class="form-control @error('attach_file') is-invalid @enderror"  name="attach_file" autocomplete="attach_file" autofocus>

                                        @error('attach_file')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                @elseif($query->resolution_type == 'Written Resolution from a Lawyer' && $query->status == 'Complete')

                                <div class="form-group row">
                                    <label for="body" class="col-md-4 col-form-label text-md-right">{{ __('Reply from Lawyer') }}</label>

                                    <div class="col-md-6">
                                        <textarea readonly disabled rows="10" style="resize: none;" id="body" type="text" class="form-control @error('body') is-invalid @enderror" name="body" value="{{ $query->reply_to_written_resolution }}" required autocomplete="body">{{ $query->reply_to_written_resolution }}</textarea>

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

                                       @if($query->attached_file != null)
                                       <a target="_blank" href="{{ $query->attached_file }}">
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

                            @elseif($query->resolution_type == 'Video Conference with a Lawyer' && $query->status == 'Pending')
                            <div class="form-group row">
                                <label for="schedule" class="col-md-12 col-form-label text-md-center">{{ __('Please choose one from the available schedules sent by the customer') }}</label>
                            </div>

                            <div class="form-group row">
                                <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Option 1: ') }}
                                    <input type="radio" id="schedule" name="schedule" value="{{ $query->available_date_1 }}{{"--"}}{{ $query->available_time_1}}" class="col-form-label text-md-right"></label>

                                    <div class="col-md-6 d-flex">
                                        <input readonly disabled value="{{ $query->available_date_1 }}" min={{ now()->addDay(1) }} id="available_date_1" type="date" class="form-control @error('available_date_1') is-invalid @enderror" name="available_date_1" value="{{ $query->available_date_1 }}" required autocomplete="schedule" autofocus>


                                        <select readonly disabled name="available_time_1" id="available_time_1" class="form-control @error('available_time_1') is-invalid @enderror">
                                            <option selected value="{{ $query->available_time_1 }}"> {{ $query->available_time_1 }}</option>
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
                                    <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Option 2: ') }}
                                        <input type="radio" id="schedule" name="schedule" value="{{ $query->available_date_2 }}{{"--"}}{{ $query->available_time_2}}" class="col-form-label text-md-right"></label>

                                        <div class="col-md-6 d-flex">
                                            <input readonly disabled value="{{ $query->available_date_2 }}" min={{ now()->addDay(1) }} id="available_date_2" type="date" class="form-control @error('available_date_2') is-invalid @enderror" name="available_date_2"  value="{{ $query->available_date_1 }}" required autocomplete="schedule" autofocus>


                                            <select readonly disabled name="available_time_2" id="available_time_2" class="form-control @error('available_time_2') is-invalid @enderror">
                                                <option  selected value="{{ $query->available_time_2 }}"> {{ $query->available_time_2 }}</option>
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
                                        <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Option 3: ') }}
                                            <input  type="radio" id="schedule" name="schedule" value="{{ $query->available_date_3 }}{{"--"}}{{ $query->available_time_3}}" class="col-form-label text-md-right" ></label>

                                            <div class="col-md-6 d-flex">
                                                <input readonly disabled value="{{ $query->available_date_3 }}" min={{ now()->addDay(1) }} id="available_date_3" type="date" class="form-control @error('available_date_3') is-invalid @enderror" name="available_date_3" value="{{ $query->available_date_1 }}" required autocomplete="schedule" autofocus>


                                                <select readonly disabled name="available_time_3" id="available_time_3" class="form-control @error('available_time_3') is-invalid @enderror">
                                                    <option selected value="{{ $query->available_time_3 }}"> {{ $query->available_time_3 }}</option>
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


                                    @elseif($query->resolution_type == 'Video Conference with a Lawyer' && $query->status == 'In-Progress')
                                    <div class="form-group row">

                                        <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Choosen Schedule: ') }}</label>

                                        <div class="col-md-6 d-flex">

                                            <input readonly disabled value="{{ $query->schedule_date }}" min={{ now()->addDay(1) }} id="schedule_date" type="date" class="form-control @error('schedule_date') is-invalid @enderror" name="schedule_date" value="{{ $query->schedule_date }}" required autocomplete="schedule" autofocus>


                                            <select readonly disabled name="schedule_time" id="schedule_time" class="form-control @error('schedule_time') is-invalid @enderror">
                                                <option selected value="{{ $query->schedule_time }}"> {{ $query->schedule_time }}</option>
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
                                            <textarea rows="10" style="resize: none;" id="summary" type="text" class="form-control @error('summary') is-invalid @enderror" name="summary"  value="{{ old('summary_from_lawyer') }}" required autocomplete="summary"></textarea>

                                            @error('summary')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    @elseif($query->resolution_type == 'Video Conference with a Lawyer' &&  $query->status == 'Complete')
                                    <div class="form-group row">

                                        <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Choosen Schedule: ') }}</label>

                                        <div class="col-md-6 d-flex">

                                            <input readonly disabled value="{{ $query->schedule_date }}" min={{ now()->addDay(1) }} id="schedule_date" type="date" class="form-control @error('schedule_date') is-invalid @enderror" name="schedule_date" value="{{ $query->schedule_date }}" required autocomplete="schedule" autofocus>


                                            <select readonly disabled name="schedule_time" id="schedule_time" class="form-control @error('schedule_time') is-invalid @enderror">
                                                <option selected value="{{ $query->schedule_time }}" readonly> {{ $query->schedule_time }}</option>
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
                                            <textarea readonly rows="10" style="resize: none;" id="summary" type="text" class="form-control @error('summary') is-invalid @enderror" name="summary"  value="{{ old('summary_from_lawyer') }}" required autocomplete="summary">{{ $query->summary_from_lawyer}}</textarea>

                                            @error('summary')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-group row">
                                        <div class="mx-auto">
                                            @if($query->status == 'In-Progress' )
                                                <button name="action" value="complete" class="btn btn-primary-btn text-white" @if(Carbon\Carbon::parse($event_check->end_time)->gte(Carbon\Carbon::now())) disabled @endif>
                                                    Complete
                                                </button>
                                            @elseif($query->resolution_type == 'Written Resolution from a Lawyer' && $query->status != 'Complete')
                                                @if($query->lawyer_id==null)
                                                    @if($query->category == "Offline Consultation" || $query->resolution_type == 'Written Resolution from a Lawyer')
                                                        <button name="action" value="acceptOffline" class="btn btn-primary-btn text-white">
                                                            Accept
                                                        </button>
                                                        <button name="action" value="declineOffline" class="btn btn-danger text-white">
                                                            Decline 
                                                        </button>
                                                    @else
                                                        <button name="action" value="accept" class="btn btn-primary-btn text-white">
                                                            Accept
                                                        </button>
                                                        <button name="action" value="decline" class="btn btn-danger text-white">
                                                            Decline
                                                        </button>
                                                    @endif
                                                @else
                                                    <button name="action" value="send" class="btn btn-primary-btn text-white">
                                                        Send
                                                    </button>
                                                @endif
                                            @elseif($query->category == "Offline Consultation"  &&  $query->status == 'Pending' && $query->lawyer_id==null)
                                                <button name="action" value="acceptOffline" class="btn btn-primary-btn text-white">
                                                    Accept 
                                                </button>
                                                <button name="action" value="declineOffline" class="btn btn-danger text-white">
                                                    Decline 
                                                </button>
                                            @elseif($query->status == 'Pending' && $query->lawyer_id==null)
                                                <button name="action" value="accept" class="btn btn-primary-btn text-white">
                                                    Accept
                                                </button>
                                                <button name="action" value="decline" class="btn btn-danger text-white">
                                                    Decline
                                                </button>
                                            @endif

                                        </div>
                                    </div>

                                    @endforeach
                                </div>
                            </form>
                            @if($event_check && $queries[0]->status != 'Complete')
                            <div class="card-body">
                                <div class="container mx-auto">
                                    <h5 class="text-center">Your Meeting starts at {{ $event_check->start_time }} and ends at {{ $event_check->end_time }}. 
                                        <br>
                                        Your meeting link -- <strong>
                                        <a target="_blank" href="{{ $event_check->meeting_link }}">{{ $event_check->meeting_link }}</a></strong>
                                    </h5>

                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @endsection
