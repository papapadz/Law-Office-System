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
                            <th>Lawyer</th>
                    		<th>Type Of Resolution</th>
                    		<th>Status</th>
                    	</thead>
                    	<tbody>
                    		@foreach($queries as $query)
                    		<tr>
                    			<td>
                    				<a href="{{ route('admin.detail', $query->transaction_number) }}">
                    					{{ $query->transaction_number }}
                    				</a>
                    				
                    			</td>
                    			<td>{{ $query->created_at }}</td>
                                <td>{{ $query->lawyer ? $query->lawyer->first_name .' '. $query->lawyer->last_name : "" }}</td>
                    			<td>{{ $query->resolution_type }}</td>
                    			<td>{{ $query->status }}</td>
                    		</tr>
                    		@endforeach
                    	</tbody>
                    </table>
            </div>
        </div>
    </div>

</div>
</div>
@endsection
