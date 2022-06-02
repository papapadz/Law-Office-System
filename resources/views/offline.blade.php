@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-primary-color">
                <div class="card-body">
                    <div class="mx-auto">
                        <h3 class="text-center text-white font-weight-bold">
                            OFFLINE CONSULTATION
                        </h3>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="container d-flex">
                        <div class="col-md-4 d-flex align-self-center">
                            <i class="fa fa-calendar fa-5x fa-md mx-auto text-primary-color"></i>
                        </div>
                        <div class="col-md-8">
                            Offline consultation usually involves a customer having to visit a particular law firm for their consultation. But, in our case we found a way to make it a less hassle experience for the customer. The customer can select a schedule for their offline consultation meaning that they can set a schedule for their visit even without physically going to the law firm. The only travel that they will do is when it is time for their offline consultation schedule. It is a convenient and hassle free way for customers because it gives them assurance that there will be a lawyer who will tend to their needs and they don't have to wait for a lawyer to consult with them.
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="col-md-12 bg-primary-color">
                    <p class="text-center font-weight-bold mx-auto text-white my-2">STEPS TO SEND AN OFFLINE QUERY</p>
                </div>
                <div class="card-body">
                    <div class="container">
                        {{-- FIRST ROW --}}
                        <div class="row mx-auto">
                        <div class="col-md-4 mt-1">
                            <div class="card pb-5">
                                <div class="card-body">
                                    <h4 class="text-center">
                                        Step 1
                                    </h4>
                                    <div class="mx-auto d-flex">
                                        <img class="w-50 mx-auto" src="https://res.cloudinary.com/dptv7erxn/image/upload/v1634940207/icons/offline_1.png" alt="">
                                    </div>
                                    <p class="text-center mt-4">
                                        Click the "Set Schedule" button below to be directed to a form
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-1">
                            <div class="card pb-4">
                                <div class="card-body">
                                    <h4 class="text-center">
                                        Step 2
                                    </h4>
                                    <div class="mx-auto d-flex">
                                        <img class="w-50 mx-auto" src="https://res.cloudinary.com/dptv7erxn/image/upload/v1634940206/icons/2.png" alt="">
                                    </div>
                                    <p class="text-center mt-4">
                                        Fill out the necessary information in the form then click submit button
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-1">
                            <div class="card pb-5">
                                <div class="card-body">
                                    <h4 class="text-center">
                                        Step 3
                                    </h4>
                                    <div class="mx-auto d-flex">
                                        <img class="w-50 mx-auto" src="https://res.cloudinary.com/dptv7erxn/image/upload/v1634940206/icons/3.png" alt="">
                                    </div>
                                    <p class="text-center mt-4">
                                        You will see your summary query details
                                    </p>
                                </div>
                            </div>
                        </div>
                        </div>
                        {{-- FIRST ROW --}}

                        {{-- SECOND ROW --}}
                        <div class="row mx-auto">
                        <div class="col-md-4 mt-1">
                            <div class="card pb-5">
                                <div class="card-body pb-5">
                                    <h4 class="text-center">
                                        Step 4
                                    </h4>
                                    <div class="mx-auto d-flex">
                                        <img class="w-50 mx-auto" src="https://res.cloudinary.com/dptv7erxn/image/upload/v1634940206/icons/5.png" alt="">
                                    </div>
                                    <p class="text-center mt-4">
                                        You may now patiently wait for a reply as a lawyer will now see your query
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-1">
                            <div class="card pb-4">
                                <div class="card-body">
                                    <h4 class="text-center">
                                        Step 5
                                    </h4>
                                    <div class="mx-auto d-flex">
                                        <img class="w-50 mx-auto" src="https://res.cloudinary.com/dptv7erxn/image/upload/v1634940206/icons/9.png" alt="">
                                    </div>
                                    <p class="text-center mt-4">
                                        You may now patiently wait for a reply as a lawyer will now see your query. You will be either schedule to a conference call or receive a resolution from a lawyer.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-1">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="text-center">
                                        Step 6
                                    </h4>
                                    <div class="mx-auto d-flex">
                                        <img class="w-50 mx-auto" src="https://res.cloudinary.com/dptv7erxn/image/upload/v1634940206/icons/6.png" alt="">
                                    </div>
                                    <p class="text-center mt-4">
                                        In you "My Transaction" page; you may see the status of your query. When transactions are complete, we hope to hear from you by click on the "Send Feedback" button located ath the bottom of the page.
                                    </p>
                                </div>
                            </div>
                        </div>
                        </div>
                        {{-- SECOND ROW --}}
                    </div>
                </div>
            </div>
            @if(Auth::check() && Auth()->user()->role_id == 1)
            <div class="mx-auto text-center mt-3">
                <a href="{{ route('offline.query') }}" class="btn btn-lg btn-primary-btn mx-auto btn-large text-white">Set Schedule</a>
            </div>
            @endif
            
        </div>
    </div>
</div>
@endsection
