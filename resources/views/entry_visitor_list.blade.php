@extends('layouts.master')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
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
            <div class="card">
                <div class="card-header text-white bg-primary align-items-center d-flex" style="justify-content: space-between;"><strong>Visitor Entry List</strong></div>
                <div class="card-body">
                    <form action="{{ route('entrylist.visitor') }}" method="GET">
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="Name"><strong>Name</strong></label>
                            <input type="text" style="border: solid 1px" class="form-control" placeholder="Name" name="name" id="name" value="{{ request('name') }}">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="mobnumber"><strong>Pass ID</strong></label>
                            <input type="number" style="border: solid 1px" class="form-control" name="passid" id="passid" placeholder="Enter Passid" value="{{ request('passid') }}">
                          </div>
                          <!--<div class="form-group col-md-6">-->
                          <!--  <label for="Department"><strong>Department</strong></label>-->
                          <!--    <select class="form-control" name="dept" id="dept" style="border: solid 1px">-->
                          <!--        <option value="">Select Visiting Department</option>-->
                          <!--        @foreach($department as $dept)-->
                          <!--              <option value="{{$dept->name}}" @if(request('dept') == $dept->name) selected @endif>{{$dept->name}}</option>-->
                          <!--          @endforeach-->
                          <!--    </select>-->
                          <!--</div>-->
                          <!--<div class="form-group col-md-6">-->
                          <!--  <label for="oraganization"> <strong>Oraganization</strong> </label>-->
                          <!--  <input type="text" style="border: solid 1px" class="form-control" name="oraganization" id="oraganization" placeholder="Enter oraganization" value="{{ request('oraganization') }}">-->
                          <!--</div>-->
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-filter" aria-hidden="true"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <table id="departmentTable" class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Pass ID</th>
                <th scope="col">Mobile Number</th>
                <th scope="col">Date And Time</th>
                <th scope="col">Oragnization</th>
            </tr>
        </thead>
        @if(count($visitors) > 0)
            @php
                $id = 1; // Initialize ID counter
            @endphp
            @foreach($visitors as $visitor)
                <tbody>
                    <tr>
                        <th>{{$id}}</th>
                        <th>{{$visitor->name}}</th>
                        <th>{{$visitor->pass_id}}</th>
                        <th>{{$visitor->mobile}}</th>
                        <th>{{$visitor->entry_datetime}}</th>
                        <th>{{$visitor->organization}}</th>
                    </tr>
                </tbody>
            @php
            $id++; // Initialize ID counter
            @endphp
            @endforeach
        @else
            <p>No Record Found</p>
        @endif
    </table>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js" defer></script>

<script>
    $(document).ready(function() {
        $('#departmentTable').DataTable({
            "searching": false,
            "paging": true,
            "lengthMenu": [10, 25, 50, 75, 100],
        });
    });
</script>
</script>