@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center mx-auto">
        <div class="col-md-8">
         <div class="card mt-3 mx-auto">
            <div class="card-header text-center bg-primary-color text-white">

                Accounts
            </div>
            <div class="card-body mx-auto">
                <table class="table table-responsive table-bordered">
                   <thead>
                      <th>#</th>
                      <th>Name</th>
                      <th>Contact Number</th>
                      <th>User Type</th>
                      <th>Date Registered</th>
                      @if($ids == 2)
                      <th>Status</th>
                      <th>Action</th>
                      @endif
                  </thead>
                  <tbody>
                      @foreach($users as $user)
                      <tr>
                         <td>
                            <a href="{{ route('admin.user', $user->id) }}">
                               {{ $user->id }}
                           </a>
                       </td>
                       <td>
                        {{ $user->last_name }}, {{ $user->first_name }}
                    </td>
                    <td>
                        {{ $user->contact_number }}
                    </td>
                    <td>
                        @if($user->role_id == 1)
                        <span class="badge badge-info text-white">Client</span>
                        @elseif($user->role_id == 2)
                        <span class="badge badge-info text-white">Lawyer</span>
                        @elseif($user->role_id == 3)
                        <span class="badge badge-info text-white">Administrator</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at }}</td>
                    @if($ids == 2)
                    <td>
                        @if($user->is_verified == 0)
                        <span class="badge badge-danger">Pending</span>
                        @else
                        <span class="badge badge-success">Verified</span>
                        @endif
                    </td>
                    
                    <td>
                        <a href="{{ route('admin.user', $user->id) }}" class="btn btn-sm"
                            ><span class="fa fa-eye">
                            </span></a>
                        </td>
                    @endif
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