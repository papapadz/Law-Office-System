@extends('layouts.app')

@section('content')
<div class="container py-4">
	<div class="row justify-content-center mx-auto">
		<div class="col-md-3">
			<div class="card mt-3 mx-auto">
				<div class="card-header text-center bg-primary-color text-white">
					Accounts
				</div>
				<ul class="list-group list-group-flush">

					<a class="list-group-item" href="{{ route('admin.account', ['id' => 1]) }}">Customer Accounts

					</a>

					<a class="list-group-item" href="{{ route('admin.account', ['id' => 2]) }}">Lawyer Accounts
		
					</a>

					
				</ul>
			</div>

			<div class="card mt-3 mx-auto">
				<div class="card-header text-center bg-primary-color text-white">
					Queries
				</div>
				<ul class="list-group list-group-flush">

					<a class="list-group-item" href="{{ route('admin.payments') }}">Payment Queries 
					</a>

					<a class="list-group-item" href="{{ route('admin.query', 'pending') }}">Pending Queries 
					</a>

					<a class="list-group-item" href="{{ route('admin.query', 'In-Progress') }}">In-Progress
						
					</a>

					<a class="list-group-item" href="{{ route('admin.query', 'scheduled') }}">Scheduled
						
					</a>

					<a class="list-group-item" href="{{ route('admin.query', 'complete') }}">Complete
					</a>
				</ul>
			</div>

			<div class="card mt-3 mx-auto">
				<div class="card-header text-center bg-primary-color text-white">
					Feedback & Inquiries
				</div>
				<ul class="list-group list-group-flush">
					<a class="list-group-item" href="{{ route('admin.feedbacks') }}">Feedbacks 
					</a>
					<a class="list-group-item" href="{{ route('admin.inquiries') }}">Inquiries
					</a>
				</ul>
			</div>

			<div class="card mt-3 mx-auto">
				<div class="card-header text-center bg-primary-color text-white">
					New Admin
				</div>
				<ul class="list-group list-group-flush">
					<a class="list-group-item" href="{{ route('admin.CreateNewAdmin') }}">Create New Admin 
					</a>
				</ul>
			</div>

			<div class="card mt-3 mx-auto">
				<div class="card-header text-center bg-primary-color text-white">
					Audit Logs
				</div>
				<ul class="list-group list-group-flush">
					<a class="list-group-item" href="{{ route('admin.audit') }}">View Audit Logs 
					</a>
				</ul>
			</div>

		</div>
		<div class="col-md-6">
			<div class="card mt-3 mx-auto">
				<div class="card-header text-center bg-primary-color text-white">
					Dashboard
				</div>
				<div class="card-body">
					<div class="container mx-auto">
						{{-- FIRST ROW --}}
						

						<div class="row">
							<div class="card mx-auto mt-1">
								<div class="card-body">
									<a href="{{ route('admin.query', 'pending') }}">
                                    <h2 class="text-center">
                                        {{ $pending_query }}
                                    </h2>
                                </a>
                                    <p class="text-center">
                                        Pending Queries
                                    </p>
								</div>
							</div>

							<div class="card mx-auto mt-1">
								<div class="card-body">
									<a href="{{ route('admin.query', 'In-Progress') }}">
									<h2 class="text-center">
										{{ $inprogress_query }}
									</h2>
								</a>
								 <p class="text-center">
                                       In-Progress 
                                    </p>
									</h2>
								</div>
							</div>

							<div class="card mx-auto mt-1">
								<div class="card-body">
									<a href="{{ route('admin.query', 'scheduled') }}">
									<h2 class="text-center">
										{{ $scheduled_query }}
									</h2>
								</a>
								<p class="text-center">
                                       Scheduled Queries </p>
								</div>
							</div>

						</div>
						{{-- FIRST ROW --}}

						{{-- SECOND ROW --}}
						<div class="row mt-2">
							<div class="card mx-auto mt-1">
								<div class="card-body">
									<a href="{{ route('admin.account', ['id' => 1]) }}">
									<h2 class="text-center">
										{{ $client_count }}
									</h2>
								</a>
									<p class="text-center">
                                       Customer Accounts </p>

					</a>
								</div>
							</div>

							<div class="card mx-auto mt-1">
								<div class="card-body">
									<a href="{{ route('admin.account', ['id' => 2]) }}">
									<h2 class="text-center">
										{{ $lawyer_count }}
									</h2>
					</a>
					<p class="text-center">
                                       Lawyer Accounts </p>

								</div>
							</div>

							<div class="card mx-auto mt-1">
								<div class="card-body">
									<a href="{{ route('admin.account', ['id' => 2]) }}">
									<h2 class="text-center">
										{{ $pending_count }}
									</h2>
								</a>
									<p class="text-center">
										Pending Lawyers
									</p>
								</div>
							</div>
						</div>

						{{-- SECOND ROW --}}

						{{-- THIRD ROW --}}
						<div class="row mt-2">
							<div class="card mx-auto mt-1">
								<div class="card-body">
									<a href="{{ route('admin.feedbacks') }}">
									<h2 class="text-center">
										{{ $feedback_count }}
									</h2>
									</a>
									<p class="text-center">
										Feedbacks
									</p>
								</div>
							</div>

							<div class="card mx-auto mt-1">
								<div class="card-body">
									<a href="{{ route('admin.inquiries') }}">
									<h2 class="text-center">
										{{ $inquiry_count }}
									</h2>
								</a>
								<p class="text-center">
										Inquiries
									</p>
								</div>
							</div>
						</div>

						{{-- THIRD ROW --}}

					</div>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection
