@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="container row justify-content-center mx-auto">
        <div class="col-md-12">
         <div class="row">
            <div class="card mt-3 mx-auto">
            	<div class="card-header text-center bg-primary-color text-white">
            		My Transactions
            	</div>
                <div class="card-body">
                    <table class="table table-responsive table-bordered">
                    	<thead>
                    		<th>Transaction Number</th>
                    		<th>Date</th>
                            <th>Consultation</th>
                    		<th>Type Of Resolution</th>
                            @if( Auth()->user()->role_id == 3 )
                            <th>Assigned To</th>

                            @endif
                    		<th>Status</th>

                    	</thead>
                    	<tbody>
                    		@foreach($queries as $query)
                    		<tr>
                                @if( Auth()->user()->role_id == 2)
                                <td>
                                    <a href="{{ route('lawyer.query', $query->transaction_number) }}">
                                        {{ $query->transaction_number }}
                                    </a>
                                    
                                </td>
                                @else
                                <td>
                                    <a href="{{ route('user.query', $query->transaction_number) }}">
                                        {{ $query->transaction_number }}
                                    </a>
                                    
                                </td>
                                @endif
                                <td>{{ $query->created_at }}</td>
                                <td>{{ $query->category }}</td>
                                <td>{{ $query->resolution_type }}</td>
                                @if( Auth()->user()->role_id == 3 )
                                @if($query->lawyer != null)
                                <td>{{ $query->lawyer->first_name }} {{ $query->lawyer->last_name }}</td>
                                @else
                                <td></td>
                                @endif
                                
                                {{-- <td>{{ $query->lawyer->first_name }}</td> --}}
                                @endif
                                <td>{{ $query->status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if( Auth()->user()->role_id == 5 )
        <div class="row">
            <div class="card mt-3 mx-auto">
                <div class="card-header text-center bg-primary-color text-white">Pending Queries</div>
                <div class="card-body">
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <th>Transaction Number</th>
                            <th>Date</th>
                            <th>Type Of Service</th>
                            {{-- <th>Type Of Resolution</th> --}}
                            <th>Status</th>
                        </thead>
                        <tbody>
                            @foreach($pending_queries as $query)
                            <tr>
                                <td>
                                    <a href="{{ route('lawyer.query', $query->transaction_number) }}">
                                        {{ $query->transaction_number }}
                                    </a>
                                </td>
                                <td>{{ $query->created_at }}</td>
                                <td>{{ $query->category }}</td>
                                {{-- <td>{{ $query->resolution_type }}</td> --}}
                                <td>{{ $query->status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
    </div>

</div>
</div>
@endsection
