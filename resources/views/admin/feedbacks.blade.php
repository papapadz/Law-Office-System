@extends('layouts.app')

@section('content')
<div class="container py-4">
	<div class="container row justify-content-center mx-auto">
		<div class="col-md-8">
			<div class="row">
				<div class="card mt-3 mx-auto">
					<div class="card-header text-center bg-primary-color text-white">
						Feedbacks
					</div>
					<div class="card-body">
						<table class="table table-responsive table-bordered">
							<thead>
								<th>#</th>
								<th>Client's Name</th>
								<th>Feedback</th>
								<th>Status</th>
								<th>Action</th>
							</thead>
							<tbody>
								@foreach($feedbacks as $feedback)
								<tr>
									<td>{{ $feedback->id }}</td>
									<td>{{ $feedback->client->first_name .' '. $feedback->client->last_name }}</td>
									<td>{{ $feedback->feedback }}</td>
									<td>{{ $feedback->status }}</td>
									<td>
										<a href="{{ route('admin.feedback', $feedback->id) }}" class="btn btn-sm"
											><span class="fa fa-eye">
											</span></a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
							{{ $feedbacks->links() }}
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	@endsection
