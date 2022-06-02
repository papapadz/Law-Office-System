@extends('layouts.app')

@section('content')
<div class="container py-4">
	<div class="row justify-content-center mx-auto">
		<div class="col-md-8">
			<div class="card mt-3 mx-auto">
				<div class="card-header text-center bg-primary-color text-white">
					Pending Inquiries
				</div>
				<div class="card-body">
					<form action="{{ route('inquiries.approve') }}" method="POST">
						@csrf
						<div class="container">
							<div class="d-flex flex-column">
								<input type="hidden" name="contact_id" value="{{ $contacts->id }}">
								<small class="font-weight-bold">Name</small>
								<p>{{ $contacts->first_name . ' '. $contacts->last_name }}</p>

							</div>
							<div class="d-flex flex-column">
								<small class="font-weight-bold">Status</small>
								<p>{{ $contacts->status }}</p>
							</div>

							<div class="d-flex flex-column">
								<small class="font-weight-bold">Email</small>
								<p>{{ $contacts->email }}</p>
							</div>
							<div class="d-flex flex-column">
								<small class="font-weight-bold">Contact Number</small>
								<p>{{ $contacts->contact_number }}</p>
							</div>
							<div class="d-flex flex-column">
								<small class="font-weight-bold">Subject</small>
								<p>{{ $contacts->subject }}</p>
							</div>
							<div class="d-flex flex-column">
								<small class="font-weight-bold">Inquiry</small>
								<p>{{ $contacts->question }}</p>
							</div>

							<div class="d-flex flex-column">
								<small class="font-weight-bold">Reply Message</small>
								<textarea required style="resize: none;" name="reply_message" id="reply_message" cols="30" rows="10" class="form-control mt-2"></textarea>
							</div>
							<div class="d-flex flex-column">
								<button class="btn btn-primary-btn text-white mt-2">Send</button>
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
