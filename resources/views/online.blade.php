@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-primary-color">
                <div class="card-body">
                    <div class="mx-auto">
                        <h3 class="text-center text-white font-weight-bold">
                            ONLINE CONSULTATION
                        </h3>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="container d-flex">
                        <div class="col-md-4 d-flex align-self-center">
                            <i class="fa fa-video-camera fa-5x fa-md mx-auto text-primary-color"></i>
                        </div>
                        <div class="col-md-8">
                            Online communication contributes to bringing the world together. Perhaps the most important thing about online communication is that it connects individuals from all over the world together and makes it makes the world smaller in a way.  There is no time latency when information is shared online across the internet. It makes meetings easy for users and it is convenient. Using online consultation will allow users to have another mean of communication between the lawyer. Customers don't have to physically appear in a law firm just for consultation. They can do it in the comfort of their home.
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="col-md-12 bg-primary-color">
                    <p class="text-center font-weight-bold mx-auto text-white my-2">STEPS TO SEND AN ONLINE QUERY</p>
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
                                        <img class="w-50 mx-auto" src="https://res.cloudinary.com/dptv7erxn/image/upload/v1634940207/icons/online_1.png" alt="">
                                    </div>
                                    <p class="text-center mt-4">
                                        Click the "Ask A Lawyer" button below to be directed to a form
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
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="text-center">
                                        Step 3
                                    </h4>
                                    <div class="mx-auto d-flex">
                                        <img class="w-50 mx-auto" src="https://res.cloudinary.com/dptv7erxn/image/upload/v1634940206/icons/3.png" alt="">
                                    </div>
                                    <p class="text-center mt-4">
                                        You will see your summary query details. Below is a button that will direct you to to the payment details page
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
                                <div class="card-body">
                                    <h4 class="text-center">
                                        Step 4
                                    </h4>
                                    <div class="mx-auto d-flex">
                                        <img class="w-50 mx-auto" src="https://res.cloudinary.com/dptv7erxn/image/upload/v1634940206/icons/online_4.png" alt="">
                                    </div>
                                    <p class="text-center mt-4">
                                        For payment instructions, you may follow the instructions seen in the page. You may upload your proof of payment on the same page.
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
                                        <img class="w-50 mx-auto" src="https://res.cloudinary.com/dptv7erxn/image/upload/v1634940206/icons/5.png" alt="">
                                    </div>
                                    <p class="text-center mt-4">
                                        You may now patiently wait for a reply as a lawyer will now see your query. You will be either scheduled to a conference call or receive a resolution from a lawyer.
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
                                        In your "My Transaction" page, you may see the status of your query. When transactions are complete, we hope to hear from you by clicking on the "Send Feeback" button located at the bottom of the page.
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
                <a href="{{ route('online.query') }}" class="btn btn-lg btn-primary-btn mx-auto btn-large text-white">ASK A LAWYER</a>
            </div>
            @endif
            
        </div>
    </div>
</div>
@endsection
