@extends('layouts.app')

@section('content')
{{-- <div class="container mt-5">
    <div class="row mx-auto">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4>Oncon</h4>
                    <p>Lorem ipsum dolor, sit, amet consectetur adipisicing elit. Voluptate, dolore corporis magni autem fugiat beatae dolores dolor dignissimos quia aut totam quisquam, quod quam reprehenderit eligendi repudiandae eveniet, dolorem quo.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mx-auto">
            <img width="150" height="150" src="{{ asset('img/oncon.png') }}" alt="">
        </div>
    </div>
</div> --}}
{{-- <div data-aos="fade-in"></div> --}}
<div class="col-md-12 text-white homepage h-100 fill px-5 py-5">
    <div class="container px-5 py-5">
        <div class="row mx-auto text-center">
            <div class="col-md-6 d-flex justify-content-center align-self-center" data-aos="fade-in">
                <div class="row text-center">
                    <h2>OnCon</h2>

                    <p>We are students of De La Salle-College of Saint Benilde who are taking up a Bachelor of Science Major in Information Systems (BS-IS). We are conducting a study called "OnCon: A Development of an Online Web Application of Services Offered by a Law Firm". We look forward to successfully connecting with you  </p>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-in">
                <img class="w-50" src="{{ asset('img/oncon.png') }}" alt="Oncon">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 bg-primary-background h-100 fill p-5">
    <div class="container text-center text-primary-color">
        <h1 class="mx-auto font-weight-bold" style="font-size: 4vw;">
            WHAT WE OFFER
        </h1>
    </div>
</div>
<div class="col-md-12 bg-primary-color h-100 fill p-5" >
    <div class="container text-center">
        <div class="row">
            <div class="col-md-6 mt-1">
                <a class="text-decoration-none" href="{{ route('online') }}">
                <div class="card">
                    <div class="card-body pb-5">
                        <i class="fa fa-video-camera fa-4x fa-md mx-auto text-primary-color"></i>
                        <h5 class="text-center mt-4">
                            ONLINE CONSULTATION
                        </h5>
                        <p class="text-center">
                            TALK WITH ONE OF OUR LAWYERS AND GET THE BEST RESULTS
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-md-6 mt-1">
                <a class="text-decoration-none" href="{{ route('offline') }}">
                <div class="card">
                    <div class="card-body pb-4">
                        <i class="fa fa-calendar fa-4x fa-md mx-auto text-primary-color"></i>
                        <h5 class="text-center mt-4">
                            RESERVATION SCHEDULE
                        </h5>
                        <p class="text-center">
                            HASSLE FREE RESERVING YOUR SCHEDULE, NO MORE WASTING TIME LINING UP
                        </p>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 bg-primary-background h-100 fill p-5">
    <div class="container">
        <div class="row mx-auto text-center">
            <div class="col-md-4 text-center">
                <i class="fa fa-gavel fa-4x fa-md mx-auto text-primary-color"></i>
                <h2 class="my-4 font-weight-bold text-primary-color">LABOR LAW</h2>
                <p class="text-center"> </p>
            </div>
            <div class="col-md-4 text-center">
                <i class="fa fa-balance-scale fa-4x fa-md mx-auto text-primary-color"></i>
                <h2 class="my-4 font-weight-bold text-primary-color">LITIGATION</h2>
                <p class="text-center">
                    
                </p>
            </div>
            <div class="col-md-4 text-center">
                <i class="fa fa-bank fa-4x fa-md mx-auto text-primary-color"></i>
                <h2 class="my-4 font-weight-bold text-primary-color">CORPORATE LAW</h2>
                <p class="text-center">
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
@guest
@elseif(Auth::User()->role_id==3)
<div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 h-100 fill">
                    <div class="container text-center text-primary-color">
                        <h3 class="mx-auto font-weight-bold" style="font-size: 4vw;">
                            WHAT WE OFFER
                        </h3>
                    </div>
                </div>
                <div class="col-md-12 bg-primary-color h-100 fill p-5" >
                    <div class="container text-center">
                        <div class="row">
                            <div class="col-md-6">
                                <a class="text-decoration-none" href="{{ route('online') }}">
                                <div class="card">
                                    <div class="card-body pb-5">
                                        <i class="fa fa-video-camera fa-4x fa-md mx-auto text-primary-color"></i>
                                        <h5 class="text-center mt-4">
                                            ONLINE CONSULTATION
                                        </h5>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a class="text-decoration-none" href="{{ route('offline') }}">
                                <div class="card">
                                    <div class="card-body pb-5">
                                        <i class="fa fa-calendar fa-4x fa-md mx-auto text-primary-color"></i>
                                        <h5 class="text-center mt-4">
                                            RESERVATION SCHEDULE
                                        </h5>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
@endguest
@endsection

@section('scripts')
<script type="text/javascript">
    
    $(window).on('load', function() {
        $('#welcomeModal').modal('show')
    });
    
</script>
@endsection