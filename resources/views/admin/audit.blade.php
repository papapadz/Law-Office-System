@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center mx-auto">
        <div class="col-xl">
            <div class="row">
                <div class="card mt-3 mx-auto">
                    <div class="card-header text-center bg-primary-color text-white">
                        Audit Log
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Auditable Type</th>
                                <th>Old Values</th>
                                <th>New Values</th>
                                <th>Created At</th>
                                <th>Update At</th>
                            </thead>
                            <tbody>
                                @foreach($audits as $audit)
                                <tr>
                                    <td>{{ $audit->id }}</td>
                                    <td>{{ $audit->auditable_type }}</td>
                                    <td>{{ $audit->old_values }}</td>
                                    <td>{{ $audit->new_values }}</td>
                                    <td>{{ $audit->created_at }}</td>
                                    <td>{{ $audit->update_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $audits->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
