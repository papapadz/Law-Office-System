@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center mx-auto">
        <div class="col-md-8">
         <div class="card mt-3 mx-auto">
            <div class="card-header text-center bg-primary-color text-white">
                Pending Feedback
            </div>
            <div class="card-body">
                <form action="{{ route('feedback.approve') }}" method="POST">
                    @csrf
                    <div class="container">
                        <div class="d-flex flex-column">
                            <input type="hidden" name="feedback_id" value="{{ $feedbacks->id }}">
                            <small class="font-weight-bold">Name</small>
                            <p>{{ $feedbacks->client->first_name . ' '. $feedbacks->client->last_name }}</p>

                        </div>
                        <div class="d-flex flex-column">
                            <small class="font-weight-bold">Status</small>
                            <p>{{ $feedbacks->status }}</p>
                        </div>

                        <div class="d-flex flex-column">
                            <small class="font-weight-bold">Feedback</small>
                            <p>{{ $feedbacks->feedback }}</p>
                        </div>
                        
                        <div class="card-body">
                            <div class="d-flex flex-column">
                                <small class="font-weight-bold">Reply Message</small>
                                <textarea style="resize: none;" name="reply_message" id="reply_message" cols="30" rows="10" class="form-control mt-2"></textarea>
                            </div>
                            <div class="d-flex flex-column">
                                <button name="action" value="send" class="btn btn-primary-btn text-white mt-2">Send</button>
                                <button name="action" value="approve" class="btn btn-primary-btn text-white mt-2">Approve</button>
                            </div>

                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
