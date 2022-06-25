@extends('layouts.app')

@section('content')
<div class="container py-4" >
    <div class="row justify-content-center mx-auto">
        <div class="col-md-10">
           <div class="card mt-3 mx-auto">
            <div class="card-header text-center bg-primary-color text-white">
                <a class="text-white" href="{{ route('user.queries') }}">My Transactions</a>

            </div>
            <div class="card-body" id="printDiv">
                <div class="row">
                    <div class="col-md-4">
                        Transaction Number: <b>{{ $query->transaction_number }}</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        Client Name: <b>{{ $query->client->last_name }}, {{ $query->client->first_name }}</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        Lawyer Name: <b>{{ $query->lawyer->last_name }}, {{ $query->lawyer->first_name }}</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        Date: <b>{{ Carbon\Carbon::parse($query->schedule_date)->toFormattedDateString() }}</b>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>RESOLUTION</h5> <br>
                        {{ $query->reply_to_written_resolution ?? $query->reply_offline }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>SUMMARY</h5> <br>
                        {{ $query->summary_from_lawyer }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-warning" onclick="PrintElem()">Print</button>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function PrintElem()
{
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById('printDiv').innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}
</script>
@endsection
