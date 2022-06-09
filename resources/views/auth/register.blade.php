@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- <div class="card">
                <div class="card-header bg-primary-color text-white">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus required="true" >

                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus required="true">

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" required="true">

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
                                <input id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" required autocomplete="contact_number" required="true">

                                @error('contact_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="role_id" class="col-md-4 col-form-label text-md-right">{{ __('Register as') }}</label>

                            <div class="col-md-6">
                                <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror" name="role_id" required>
                                    <option value="1">Client</option>
                                    <option value="2">Lawyer</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" required="true">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}
            <div class="card">
                <div class="card-header bg-primary-color text-white">
                    Registration
                </div>
            </div>
            <div class="card mt-2">
                <div class="container">
                    <ul class="nav nav-tabs m-1" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="client-tab" data-toggle="tab" href="#client" role="tab" aria-controls="client" aria-selected="true">Client</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="Lawywer-tab" data-toggle="tab" href="#Lawywer" role="tab" aria-controls="Lawywer" aria-selected="false">Lawyer</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="client" role="tabpanel" aria-labelledby="client-tab">
                      <div class="container mt-5">
                          <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus required="true">

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus required="true">

                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" required="true">

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
                                    <input id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" required autocomplete="contact_number" required="true">

                                    @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <input type="hidden" value="1" name="role_id">
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="policy" id="policy" {{ old('policy') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="policy"> I have read and agree to the
                                         <a href="{{ url('/termsAndCondition') }}" target="_blank"> {{ __('Terms and Agreement') }}</a>
                                     </label>
                                    </div>
                                </div>
                            </div>

                        @include('auth.captcha')


                         <div class="form-group row">
                            <div class="col-md-6 offset-md-4 float-right">
                                <button type="submit" class="btn btn-primary-btn text-white btn">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="Lawywer" role="tabpanel" aria-labelledby="Lawywer-tab">
                <div class="container mt-5">
                    <form method="POST" action="{{ route('register') }}" enctype='multipart/form-data'>
                        @csrf

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus required="true">

                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus required="true">

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" required="true">

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
                                <input id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" required autocomplete="contact_number" required="true">

                                @error('contact_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="roll_number" class="col-md-4 col-form-label text-md-right">{{ __('Roll Number') }}</label>

                            <div class="col-md-6">
                                <input id="roll_number" type="text" class="form-control @error('roll_number') is-invalid @enderror" name="roll_number" value="{{ old('roll_number') }}" required autocomplete="roll_number" required="true">

                                @error('roll_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="specialization" class="col-md-4 col-form-label text-md-right">{{ __('Specialization') }}</label>

                            <div class="col-md-6">
                                <input type="checkbox" id="specialization" name="specialization[]" value="General"/>
                                <label for="General">General</label><br>
                                <input type="checkbox" id="specialization"name="specialization[]" value="Business and Corporate Law"/>
                                <label for="Business and Corporate Law">Business and Corporate Law</label><br>
                                <input type="checkbox" id="specialization" name="specialization[]" value="Litigation"/>
                                <label for="Litigation">Litigation</label><br>
                                <input type="checkbox" id="specialization"name="specialization[]" value="Labor Law"/>
                                <label for="Labor Law">Labor Law</label><br>
                                <input type="checkbox" id="specialization" name="specialization[]" value="Intellectual Property"/>
                                <label for="Intellectual Property">Intellectual Property</label><br>
                                <input type="checkbox" id="specialization" name="specialization[]" value="Entertainment Law"/>
                                <label for="Entertainment Law">Entertainment Law</label><br> 
                                <input type="checkbox" id="specialization" name="specialization[]" value="Family Law (Marriage, Child, etc.)"/>
                                <label for="Family Law (Marriage, Child, etc.)">Family Law (Marriage, Child, etc.)</label><br>
                                <input type="checkbox" id="specialization"name="specialization[]" value="Property Law"/>
                                <label for="Property Law">Property Law</label><br>
                                <input type="checkbox" id="specialization" name="specialization[]" value="Tax Law"/>
                                <label for="Tax Law">Tax Law</label><br>
                                <input type="checkbox" id="specialization" name="specialization[]" value="Data Privacy Law"/>
                                <label for="Data Privacy Law">Data Privacy Law</label><br>
                                @error('specialization')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                 <p style="font-size:x-small;"><br>
                                        *By including General as your specialization, you will allow questions be sent to you with unknown subject.
                                    </p> 
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="availability" class="col-md-4 col-form-label text-md-right">{{ __('Availability') }}</label>

                            <div class="col-md-6 ">
                                <input type="radio" id="availability" name="availability" value="Online">
                                <label for="Online">Online</label><br>
                                <input type="radio" id="availability" name="availability" value="Offline">
                                <label for="Offline">Offline</label><br>
                                <input type="radio" id="availability" name="availability" value="Both">
                                <label for="Both online and offline">Both online and offline</label>
                                @error('availability')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="location" class="col-md-4 col-form-label text-md-right">{{ __('Location') }}</label>

                            <div class="col-md-6">
                                <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" required autocomplete="location" autofocus>

                                @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photo_proof" class="col-md-4 col-form-label text-md-right">{{ __('Identification Card') }}</label>

                            <div class="col-md-6 input-group">
                                <input name="photo_proof" type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" required="true">
                            </div>
                        </div>

                        @error('photo_proof')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <input type="hidden" value="2" name="role_id">
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="policy" id="policy" {{ old('policy') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="policy"> I have read and agree to the
                                         <a href="{{ url('/termsAndCondition') }}" target="_blank"> {{ __('Terms and Agreement') }}</a>
                                     </label>
                                </div>
                            </div>
                        </div>

                        @include('auth.captcha')

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4 float-right">
                                <button type="submit" class="btn btn-primary-btn text-white btn">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </div>

                </div>



            </form>
        </div>
    </div>
</div>
@endsection