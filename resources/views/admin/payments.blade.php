@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center mx-auto">
        <div class="col-md-8">
           <div class="card mt-3 mx-auto">
            <div class="card-header text-center bg-primary-color text-white">

                Queries
            </div>
            <div class="card-body mx-auto">
                <table class="table table-responsive table-bordered">
                    	<thead>
                    		<th>Transaction Number</th>
                    		<th>Date</th>
                            <th>Customer</th>
                    		<th>Type Of Resolution</th>
                            <th>Is Payment Verified</th>
                    		<th>Status</th>
                    	</thead>
                    	<tbody>
                    		@foreach($payments as $payment)
                    		<tr>
                    			<td>
                    				<a href="{{ route('admin.detail', $payment->transaction_number) }}">
                    					{{ $payment->transaction_number }}
                    				</a>
                    				
                    			</td>
                    			<td>{{ $payment->created_at }}</td>
                                <td>{{ $payment->client ? $payment->client->first_name .' '. $payment->client->last_name : "" }}</td>
                    			<td>{{ $payment->resolution_type }}</td>
                                <td>{{ $payment->is_payment_verified }}</td>
                    			<td>{{ $payment->status }}</td>
                    		</tr>
                    		@endforeach
                    	</tbody>
                    </table>
					{{ $payments->links() }}
            </div>
        </div>
    </div>

</div>
</div>
@endsection
