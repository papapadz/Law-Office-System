@extends('layouts.app')

@section('content')
<div class="col-md-12 bg-primary-color h-100 fill p-3">
    <h2 class="text-center text-white">
        Know more about us
    </h2>
</div>
<div class="col-md-12 h-100 fill px-5 py-5">
    <div class="container px-5 py-5">
        <div class="row mx-auto text-center">
            <div class="col-md-6" data-aos="fade-in">
                <img class="w-50" src="{{ asset('/img/oncon.png') }}" alt="Oncon">
            </div>
            <div class="col-md-6 d-flex justify-content-center align-self-center" data-aos="fade-in">
                <div class="row text-center text-white">
                    <h2>OnCon</h2>

                    <p>We are students of De La Salle-College of Saint Benilde who are taking up a Bachelor of Science Major in Information Systems (BS-IS). We are conducting a study called "OnCon: A Development of an Online Web Application of Services Offered by a Law Firm". We look forward to successfully connecting with you.</p>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="col-md-12 bg-primary-background h-100 fill p-5">
    <div class="container">
        <h3 class="my-4 font-weight-bold text-center text-primary-color">Client's Feedback</h3>
    </div>
</div>
<div class="col-md-12 bg-primary-color h-100 p-5 text-white">
    <div class="container">
        @if(count($feedbacks))
        @foreach($feedbacks as $feedback)
        
        <div class="row mt-1">
            <div class="col-md-3 text-center mt-3">
                @if($feedback->client->profile_photo_path != null)
                <a href="{{ $feedback->client->profile_photo_path }}">
                    <img class="w-25 rounded-circle" src="{{ $feedback->client->profile_photo_path }}" alt="No Image available">
                </a>
                @else
                <i class="fa fa-user-circle-o fa-5x"></i>
                @endif
                
            </div>
            <div class="col-md-8 mt-3">
                <div class="row font-weight-bold">
                    {{ $feedback->client->first_name }} {{ $feedback->client->last_name }}
                </div>
                <div class="row">
                   "{{ $feedback->feedback }}"
               </div>
           </div>
           <hr class="hr-color my-4">
       </div>
       @endforeach
       @else
       <div class="row mt-1">
            <div class="col-md-3 text-center mt-3">
                <i class="fa fa-user-circle-o fa-5x"></i>
            </div>
            <div class="col-md-8 mt-3">
                <div class="row">
                    John Doe
                </div>
                <div class="row">
                   Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, itaque temporibus, nisi eveniet aspernatur a eligendi consequatur voluptate dolor nihil? Laudantium dignissimos fugit perspiciatis praesentium, similique cupiditate commodi, saepe exercitationem.
               </div>
           </div>
           <hr class="hr-color my-4">
       </div>
       @endif
   </div>
</div>
@endsection
