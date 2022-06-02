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
                        <form method="POST" action={{ route('online.submit') }}>
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input readonly id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $query->name }}" required autocomplete="name" autofocus>

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
                                    <input readonly id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $query->email }}" required autocomplete="email">

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
                                    <input readonly id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ $query->contact_number }}" required autocomplete="contact_number" autofocus>

                                    @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="resolution_type" class="col-md-4 col-form-label text-md-right">{{ __('Choose Resolution') }}</label>

                                <div class="col-md-6">
                                    <select disabled readonly name="resolution_type" id="resolution_type" class="form-control @error('resolution_type') is-invalid @enderror" name="resolution_type" required>
                                        <option value="1">Written Resolution from a Lawyer</option>
                                        <label>Please expect that you wil be receiving a reply from a lawyer.</label>
                                        <option value="2">Video Conference with a Lawyer</option>
                                        <option value="3">Voice Conference with a Lawyer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="question" class="col-md-4 col-form-label text-md-right">{{ __('Questions / Concerns') }}</label>

                                <div class="col-md-6">
                                    <textarea readonly rows="5" style="resize: none;" id="question" type="text" class="form-control @error('question') is-invalid @enderror" name="question" required autocomplete="question">{{$query->question}}</textarea>

                                    @error('question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
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
