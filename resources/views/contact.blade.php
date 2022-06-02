@extends('layouts.app')
@section('content')
<div class="col-md-12 bg-primary-color h-100 fill p-3">
    <h2 class="ml-5 text-white text-center">
        Contact Us
    </h2>
</div>
<div class="col-md-12 h-100 fill px-5 pt-5 pb-2">
    <div class="container px-5 py-5">
        <div class="row mx-auto text-center">
            <div class="col-md-10 mx-auto text-white">
                <h1>Get in touch</h1>
                <p class="text-center">Want to find out how Oncon can solve your case? Let's talk.</p>
            </div>
        </div>
    </div>
</div>

<div class="col-md-5 mx-auto h-100 fill p-3">
    <div class="container">
        <div class="card bg-primary-color">
                <div class="card-body">
                    <div class="mx-auto">
                        <h3 class="text-center text-white font-weight-bold">
                           SEND YOUR INQUIRY
                        </h3>
                    </div>
                </div>
            </div>
        <div class="card shadow">
            <div class="card-body">


                <form action="{{ route('contact.submit') }}" method="POST">
                @csrf 
                <div class="container mx-auto w-75 my-5 pb-5">
                    <div class="row">
                        <label for="first_name" class="col-form-label">First Name</label>
                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row mt-3">
                        <label for="last_name" class="col-form-label">Last Name</label>

                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row mt-3">
                        <label for="email" class="col-form-label">Email</label>
                        
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <div class="row mt-3">

                        <label for="contact_number" class="col-form-label">Contact Number</label>

                        <input id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" required autocomplete="contact_number" autofocus>

                        @error('contact_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <div class="row mt-3">
                        <label for="subject" class="col-form-label">Subject</label>
                        <input id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}" required autocomplete="subject" autofocus>
                        @error('subject')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <div class="row mt-3">
                        <label for="" class="col-form-label">Questions / Concerns</label>

                        <textarea required autofocus id="question" name="question" style="resize: none;" cols="30" rows="6" class="form-control @error('question') is-invalid @enderror">{{old('subject')}}</textarea>

                        @error('question')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror


                    </div>
                    <div class="row mt-3 float-right">
                        <button class="btn btn-primary-btn text-white btn float-right">Submit</button>
                    </div>
                </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
