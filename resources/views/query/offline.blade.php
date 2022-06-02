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
						<form method="POST" action={{ route('offline.query') }}>
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

							<input type="hidden" name="resolution_type" id="resolution_type" value="Reservation" class="form-control">

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
								<label for="lawyer_id" class="col-md-4 col-form-label text-md-right">{{ __('Choose Lawyer') }}</label>

								<div class="col-md-6">
									<select name="lawyer_id" id="lawyer_id" class="form-control @error('lawyer_id') is-invalid @enderror" name="lawyer_id" required>
										@foreach($users as $user)
										<option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }} -- {{ $user->location }}  ({{ $user->specialization }})</option>
										@endforeach
									</select>
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
											{{ __('I have read and agree to the Privacy Policy') }}
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
</div>
@endsection
