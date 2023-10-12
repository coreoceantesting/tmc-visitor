@extends('layouts.master')
<style>
    .card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 0.75rem!important;
}
ul {
    list-style: none;
    padding: 0;
}

li {
    margin-bottom: 10px;
}
</style>
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-12 col-md-12 mb-4">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                    {{Session::get('success')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    {{Session::get('error')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card">
                <div class="card-header text-white bg-primary align-items-center d-flex" style="justify-content: space-between;"><strong>Pending Special Pass List</strong></div>
                <div class="card-body">
                    <form action="{{ route('pending.special_pass') }}" method="GET">
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="Name"><strong>Name</strong></label>
                            <input type="text" style="border: solid 1px" class="form-control" placeholder="Name" name="name" id="name" value="{{ request('name') }}">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="mobnumber"><strong>Mobile Number</strong></label>
                            <input type="number" style="border: solid 1px" class="form-control" name="mobnumber" id="mobnumber" placeholder="Mobile Number" value="{{ request('mobnumber') }}">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="Department"><strong>Department</strong></label>
                              <select class="form-control" name="dept" id="dept" style="border: solid 1px">
                                  <option value="">Select Department</option>
                                  @foreach($department as $dept)
                                        <option value="{{$dept->name}}" @if(request('dept') == $dept->name) selected @endif>{{$dept->name}}</option>
                                    @endforeach
                              </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="oraganization"> <strong>Oraganization</strong> </label>
                            <input type="text" style="border: solid 1px" class="form-control" name="oraganization" id="oraganization" placeholder="Enter oraganization" value="{{ request('oraganization') }}">
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-filter" aria-hidden="true"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @if(count($visitors) > 0)
            @foreach($visitors as $visitor)
                <div class="col-sm-6" style="padding: 10px;">
                    <div class="card border-primary mb-3">
                        <div class="card-header bg-primary border-primary"><strong class="text-white" style="font-size: x-large;">{{$visitor->first_name}} {{$visitor->last_name}}</strong></div>
                        <div class="card-body">
                            <ul>
                                <li><strong>Pass ID:</strong> {{$visitor->special_pass_visitor_unique_id}}</li>
                                <li><strong>Mobile Number:</strong> {{$visitor->mob_no}}</li>
                                <li><strong>Oragnization:</strong> {{$visitor->organization_name}}</li>
                                <li><strong>Valid From:</strong> {{$visitor->valid_from}}</li>
                                <li><strong>Valid Till:</strong> {{$visitor->valid_till}}</li>
                                <li><strong>Approval Status:</strong> {{ ucfirst($visitor->approval_status) }}</li>
                            </ul>
                        </div>
                        <div class="card-footer bg-primary border-primary">
                            {{-- <form action="{{ route('approved.special_pass', ['id' => $visitor->special_pass_visitors_id]) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form> --}}
                            <a class="btn btn-success form-control"  href="{{ route('view.special_pass', ['id' => $visitor->special_pass_visitors_id]) }}">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>No Record Found</p>
        @endif
    </div>
</div>
@endsection

<!-- Include Twitter Bootstrap CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Include DataTables CSS with Bootstrap 4 styling -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<!-- Include DataTables Buttons CSS with Bootstrap 4 styling -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">


<script>
   $(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>