@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="container row justify-content-center mx-auto">
        <div class="col-md-4">
         <div class="row">
            {{-- <div class="card mt-3">
                <div class="card-body">
                    <div class="container">
                        <i class="fa fa-user-circle-o fa-5x"></i>
                    </div>
                </div>
            </div> --}}
            @if(auth()->user()->role_id == 2)
            <div class="card mt-3 w-100">
                <div class="card-header bg-primary-color text-white">
                    Dashboard
                </div>
                <div class="card-body">
                    <div class="container row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-center">You have a total of</p>
                                    <h5 class="text-center font-weight-bold">₱ {{ $query_count_billing * 600 }}</h5>
                                    <p class="text-center"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-center">You have a total of</p>
                                    <h5 class="text-center font-weight-bold">{{ $query_count }}</h5>
                                    <p class="text-center">Queries</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-6 ml-3 mx-auto">
        <div class="row">
            <div class="card mt-3 w-100">
                <div class="card-header bg-primary-color text-white">
                    Profile Settings
                </div>
                <div class="card-body">

                    <div class="container">
                        {{-- <input type="file" class="form-control" id="upload_photo"> --}}
                        @if( Auth()->user()->profile_photo_path != null )
                        <div class="form-group ml-1 text-center">
                            <a href="{{ Auth()->user()->profile_photo_path }}" target="_blank">
                            <img class="w-25 mx-auto rounded-full" src="{{ Auth()->user()->profile_photo_path }}" alt="No Image">
                            </a>
                        </div>
                        @else
                        <div class="form-group ml-1 text-center">
                            <i class="fa fa-user-circle-o fa-5x avatar-size"></i>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('profile.upload') }}" enctype='multipart/form-data'>
                            @csrf
                            <div class="input-group my-2">
                              <div class="custom-file">
                                <input onchange="form.submit()" name="profile_picture" type="file" class="custom-file-input" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04">
                                <label class="custom-file-label" for="inputGroupFile04">Change Profile Picture</label>
                            </div>
                        </form>

                    </div>
                    <form action="{{ route('user.updateprofile') }}" method="POST">
                        @csrf

                        <div class="d-flex">
                            <div class="form-group ml-1 w-100">
                                <label for="" class="col-form-label">First Name</label>
                                <input type="text" name="first_name" value="{{ auth()->user()->first_name }}" class="form-control">
                            </div>
                            <hr>
                            <div class="form-group ml-1 w-100">
                                <label for="" class="col-form-label">Last Name</label>
                                <input type="text" name="last_name" value="{{ auth()->user()->last_name }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group ml-1">
                            <label for="" class="col-form-label">Phone Number</label>
                            <input type="text" name="contact_number" value="{{ auth()->user()->contact_number }}" class="form-control">
                        </div>
                        <div class="form-group ml-1">
                            <label for="" class="col-form-label">Email</label>
                            <input type="text" name="email" value="{{ auth()->user()->email }}" class="form-control" readonly>
                        </div>
                        <div class="form-group ml-1">
                            <label for="" class="col-form-label">User Type</label>
                            <input type="text" readonly value="{{ auth()->user()->role->role }}" class="form-control">
                        </div>
                        @if(auth()->user()->role_id == 2)
                        <div class="form-group ml-1 ">
                            <label for="" class="col-form-label row">Availability</label>
                            <input type="text" readonly value="{{ auth()->user()->availability }}" class="form-control">
                        </div>
                        @endif
                        <div class="form-group ml-1">
                            <button class="btn btn-primary-btn text-white float-right">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mt-3 w-100">
            <div class="card-header bg-primary-color text-white">
                Password Settings
            </div>
            <div class="card-body">
                <form action="{{ route('user.changepassword') }}" method="POST">
                    @csrf

                    <div class="container">
                        <div class="form-group ml-1">
                            <label for="current_password" class=" col-form-label">{{ __('Old Password') }}</label>

                            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="current_password">

                            @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror


                        </div>
                        <div class="form-group ml-1">
                            <label for="password" class=" col-form-label">{{ __('New Password') }}</label>

                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror


                        </div>
                        <div class="form-group ml-1">
                            <label for="password_confirmation" class=" col-form-label">{{ __('Repeat New Password') }}</label>

                            <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password_confirmation">

                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror


                        </div>
                        <div class="form-group ml-1">
                            <button class="btn btn-primary-btn text-white float-right">
                                Save
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
@section('script')

<script type="text/javascript">

    $(document).ready({
        alert('test');
    });

</script>
@endsection

@endsection
