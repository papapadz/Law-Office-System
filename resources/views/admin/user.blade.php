@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="container row justify-content-center mx-auto">
        <div class="col-md-6 ml-3 mx-auto">
            <div class="row">
                <div class="card mt-3 w-100">
                    <div class="card-header bg-primary-color text-white">
                        # {{ $users->id }} {{ $users->first_name }} {{ $users->last_name }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.approve') }}" method="POST">
                            @csrf
                            <div class="container">
                                <div class="d-flex">
                                    <input type="hidden" name="user_id" id="user_id" value="{{ $users->id }}">
                                    <div class="form-group ml-1 w-100">
                                        <label for="" class="col-form-label">First Name</label>
                                        <input type="text" readonly value="{{ $users->first_name }}" class="form-control">
                                    </div>
                                    <hr>
                                    <div class="form-group ml-1 w-100">
                                        <label for="" class="col-form-label">Last Name</label>
                                        <input type="text" readonly value="{{ $users->last_name }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group ml-1">
                                    <label for="" class="col-form-label">Phone Number</label>
                                    <input type="text" readonly value="{{ $users->contact_number }}" class="form-control">
                                </div>
                                <div class="form-group ml-1">
                                    <label for="" class="col-form-label">Email</label>
                                    <input type="text" value="{{ $users->email }}" class="form-control" readonly>
                                </div>
                                <div class="form-group ml-1">
                                    <label for="" class="col-form-label">User Type</label>
                                    <input type="text" readonly value="{{ $users->role->role }}" class="form-control">
                                </div>
                                @if($users->role_id == 2)
                                <div class="form-group ml-1">
                                    <label for="" class="col-form-label">Roll Number</label>
                                    <input type="text" readonly value="{{ $users->roll_number }}" class="form-control">
                                    <label for="" class="col-form-label"><a href="https://sc.judiciary.gov.ph/lawlist/" target="_blank"><small>Click here to check authentication of lawyer</small></a></label>  
                                    <iframe src="https://sc.judiciary.gov.ph/lawlist/" width="100%" height="300" style="border:1px solid black;"></iframe>
                                </div>



                                <div class="form-group ml-1 container">
                                    <label for="" class="col-form-label row">Proof of being a Lawyer</label>
                                    <a target="_blank" href="{{ $users->proof_photo_path }}">
                                       <img class="border p-1 img-responsive w-25 row" src="{{ $users->proof_photo_path }}" alt="Missing">
                                   </a>
                               </div>

                               <div class="form-group ml-1 ">
                                    <label for="" class="col-form-label row">Availability</label>
                                    <input type="text" readonly value="{{ $users->availability }}" class="form-control">
                                </div>


                                @endif

                               <div class="form-group ml-1">
                                <label for="" class="col-form-label">Status</label>
                                <input type="text" readonly value="{{ $users->is_verified ? "Verified" : "Pending" }}" class="form-control">
                            </div>

                            @if($users->role_id == 2)
                            <div class="form-group ml-1 float-right">
                                <button name="action" value="approve" class="btn btn-primary-btn text-white">
                                    Approve
                                </button>
                                <button name="action" value="decline" class="btn btn-primary-btn text-white">
                                    Decline
                                </button>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
