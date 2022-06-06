@extends('layouts.app')

@section('content')
<div class="container py-4">
	<div class="container row justify-content-center mx-auto">
		<div class="col-md-10">
			<div class="row">
				<div class="card mt-3 mx-auto">
					<div class="card-header text-center bg-primary-color text-white">
						Inquiries
					</div>
					<div class="card-body">
						<table class="table table-responsive table-bordered">
							<thead>
								<th>#</th>
								<th>Client's Name</th>
								<th>Email</th>
								<th>Contact Number</th>
								<th>Subject</th>
								<th>Question</th>
								<th>Status</th>
								<th>Action</th>
							</thead>
							<tbody>
								@foreach($contacts as $contact)
								<tr>
									<td>{{ $contact->id }}</td>
									<td>{{ $contact->first_name . " " . $contact->last_name }}</td>
									<td>{{ $contact->email }}</td>
									<td>{{ $contact->contact_number }}</td>
									<td>{{ $contact->subject }}</td>
									<td>{{ $contact->question }}</td>
									<td>{{ $contact->status }}</td>
									<td>
										<a href="{{ route('inquiry.details', $contact->id) }}" class="btn btn-sm"
											><span class="fa fa-eye">
											</span></a>
										</td>
									</td>
								</tr>
								@endforeach
							</table>
							{{ $contacts->links() }}
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	@endsection
