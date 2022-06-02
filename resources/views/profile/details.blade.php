@extends('layouts.app')

@section('content')
<div class="container py-4">
	<div class="container row justify-content-center mx-auto">
		<div class="col-md-12">
			<div class="row">
				<div class="card mt-3 mx-auto">
					<div class="card-header text-center bg-primary-color text-white">
						Payment Instructions
					</div>
					<div class="card-body">
						<div class="container row mx-auto">
							<div class="col-md-6">
								<div class="card">
									<div class="card-body text-center">
										<p class="font-weight-bold">
											GCASH TRANSFER
										</p>
										<p>Accout Number: 09XXXXXXX</p>
										<p>OnCon Bank</p>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="card">
									<div class="card-body text-center">
										<p class="font-weight-bold">
											BANK TRANSFER
										</p>
										<p>Accout Number: 09XXXXXXX</p>
										<p>OnCon Bank</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card mt-3 mx-auto w-75">
					<div class="card-header text-center bg-primary-color text-white">
						Proof of Payment
					</div>
					<div class="card-body">
						<form method="POST" action="{{ route('payment.upload') }}" enctype="multipart/form-data">
							@csrf
						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Transaction Number') }}</label>

							<div class="col-md-6">
								<input id="name" type="text" class="form-control @error('transaction_number') is-invalid @enderror" name="transaction_number" readonly value="{{ $transaction_number }}" required autocomplete="transaction_number" autofocus>

								@error('transaction_number')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Attach Proof of Payment') }}</label>

							<div class="col-md-6">
								<input id="name" type="file" class="form-control @error('proof_photo') is-invalid @enderror" name="proof_photo" required autocomplete="proof_photo" autofocus>

								@error('proof_photo')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group row mt-3">
							<button class="btn btn-primary-btn text-white mx-auto">
								Submit
							</button>
						</div>
						</form>


					</div>

				</div>
			</div>
		</div>

	</div>
</div>
@endsection
