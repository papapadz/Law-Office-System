@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center mx-auto">
        <div class="col-md-10">
         <div class="card mt-3 mx-auto">
            <div class="card-header text-center bg-primary-color text-white">
                My Transactions
            </div>
            <div class="card-body">
                <div class="container">
                    <form action="{{ route('admin.assign') }}" method="POST">
                        @csrf
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

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" readonly value="{{ $queries->name }}" required autocomplete="name" autofocus>

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" readonly value="{{ $queries->email }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        @if( $queries->category == 'Offline Consultation' )
                        <div class="form-group row">
                            <label for="schedule_date" class="col-md-4 col-form-label text-md-right">{{ __('Schedule Date') }}</label>

                            <div class="col-md-6">
                                <input id="schedule_date" type="text" class="form-control @error('schedule_date') is-invalid @enderror" name="schedule_date" readonly value="{{ $queries->schedule_date }}" required autocomplete="schedule_date" autofocus>

                                @error('schedule_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="schedule_time" class="col-md-4 col-form-label text-md-right">{{ __('Schedule Time') }}</label>

                            <div class="col-md-6">
                                <input id="schedule_time" type="text" class="form-control @error('schedule_time') is-invalid @enderror" name="schedule_time" readonly value="{{ $queries->schedule_time }}" required autocomplete="schedule_time" autofocus>

                                @error('schedule_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        @endif
                        



                        <div class="form-group row">
                            <label for="contact_number" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number') }}</label>

                            <div class="col-md-6">
                                <input id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" readonly value="{{ $queries->contact_number }}" required autocomplete="contact_number" autofocus>

                                @error('contact_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="resolution_type" class="col-md-4 col-form-label text-md-right">{{ __('Proof of Payment') }}</label>

                            <div class="col-md-6">
                                
                               @if($queries->proof_photo_url == null)
                               <a target="_blank" href="{{ asset('storage/icons/no_image.svg') }}">
                                   <img class="img-responsive w-25" src="{{ asset('storage/icons/no_image.svg') }}" alt="Not available">
                               </a>
                               @else
                               <a target="_blank" href="{{ $queries->proof_photo_url }}">
                                   <img class="img-responsive w-25" src="{{ $queries->proof_photo_url }}" alt="{{ asset('img/no_image.svg') }}">
                               </a>
                               @endif
                           </div>
                       </div>


                       <div class="form-group row">
                        <label for="resolution_type" class="col-md-4 col-form-label text-md-right">{{ __('Choose Resolution') }}</label>

                        <div class="col-md-6">
                            <select readonly disabled name="resolution_type" id="resolution_type" class="form-control @error('resolution_type') is-invalid @enderror" name="resolution_type" required>
                                <option readonly value="">{{ $queries->resolution_type }}</option>
                                <option readonly value="1">Written Resolution from a Lawyer</option>
                                <option readonly value="2">Video Conference with a Lawyer</option>
                                <option readonly value="3">Voice Conference with a Lawyer</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="question" class="col-md-4 col-form-label text-md-right">{{ __('Questions / Concerns') }}</label>

                        <div class="col-md-6">
                            <textarea rows="5" style="resize: none;" id="question" type="text" class="form-control @error('question') is-invalid @enderror" name="question" readonly value="{{ old('question') }}" required autocomplete="question">{{ $queries->question }}</textarea>

                            @error('question')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                                <label for="schedule" class="col-md-12 col-form-label text-md-center">{{ __('Clients provided three (3) available specific schedules') }}</label>

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


                    @if($queries->is_payment_verified == 0)
                    <div class="form-group row">
                        <div class="mx-auto">
                            <button name="action" value="save" class="btn btn-primary-btn btn text-white">
                                    Accept Proof of Payment
                            </button>
                            <button name="action" value="declineProof" class="btn btn-primary-btn btn text-white">
                                    Decline Proof of Payment
                            </button>
                        </div>
                    </div>
                    @else
                    <div class="col-md-4 text-center">
                        <i class="fa fa-check fa-1x fa-sm mx-auto text-primary-color">Payment Verified</i>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

</div>
</div>
@endsection
