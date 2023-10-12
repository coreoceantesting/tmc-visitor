@extends('layouts.master')

@section('content')

<div class="container-fluid">
    
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                <div class="card-header text-white bg-primary">{{ __('Special Pass') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('store.special_pass') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="f_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="f_name" type="text" class="form-control @error('f_name') is-invalid @enderror" name="f_name" value="{{ $data->first_name }}" required autocomplete="f_name" autofocus readonly>

                                @error('f_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="m_name" class="col-md-4 col-form-label text-md-right">{{ __('Middle Name') }}</label>

                            <div class="col-md-6">
                                <input id="m_name" type="text" class="form-control @error('m_name') is-invalid @enderror" name="m_name" value="{{ $data->middle_name }}" autocomplete="m_name" autofocus readonly>

                                @error('m_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="l_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="l_name" type="text" class="form-control @error('l_name') is-invalid @enderror" name="l_name" value="{{ $data->last_name}}" required autocomplete="l_name" autofocus readonly>

                                @error('l_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>

                            <div class="col-md-6">
                                <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" value="{{ old('photo') }}" required autocomplete="photo" autofocus>

                                @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="age" class="col-md-4 col-form-label text-md-right">{{ __('Age') }}</label>

                            <div class="col-md-6">
                                <input id="age" type="text" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ $data->age }}" required autocomplete="age" autofocus readonly>

                                @error('age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $data->email }}" required autocomplete="email" autofocus readonly>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" cols="10" rows="2" required readonly>{{ $data->address }}</textarea>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Mobile Number') }}</label>

                            <div class="col-md-6">
                                <input id="mobile" type="number" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ $data->mob_no }}" required autocomplete="mobile" readonly>

                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="organization" class="col-md-4 col-form-label text-md-right">{{ __('Organization') }}</label>

                            <div class="col-md-6">
                                <input id="organization" type="text" class="form-control @error('organization') is-invalid @enderror" name="organization" value="{{ $data->organization_name }}" required autocomplete="organization" readonly>

                                @error('organization')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="visiting_dept" class="col-md-4 col-form-label text-md-right">{{ __('Department') }}</label>

                            <div class="col-md-6">
                                <select name="visiting_dept" id="visiting_dept" class="form-control @error('visiting_dept') is-invalid @enderror" required autocomplete="visiting_dept" disabled>
                                    <option value="">Select Department</option>
                                    @foreach($department as $dept)
                                        <option @if($data->department_name == $dept->name) selected @endif value="{{$dept->name}}">{{$dept->name}}</option>
                                    @endforeach
                                </select>

                                @error('visiting_dept')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="made_for" class="col-md-4 col-form-label text-md-right">{{ __('Pass Made For') }}</label>

                            <div class="col-md-6">
                                <select name="made_for" id="made_for" class="form-control @error('made_for') is-invalid @enderror" required autocomplete="made_for" disabled>
                                    <option value="">Select Type</option>
                                    @foreach($Passfor as $pass)
                                        <option @if($data->pass_made_for_type == $pass->id) selected @endif value="{{$pass->id}}">{{$pass->name}}</option>
                                    @endforeach
                                </select>

                                @error('validity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="validity" class="col-md-4 col-form-label text-md-right">{{ __('Validity') }}</label>

                            <div class="col-md-6">
                                <select name="validity" id="validity" class="form-control @error('validity') is-invalid @enderror" required autocomplete="validity" disabled>
                                    <option value="">Select Pass Validity</option>
                                    @foreach($PassValidity as $pass)
                                        <option @if($data->pass_validity == $pass->no_of_days) selected @endif value="{{$pass->no_of_days}}">{{$pass->name}}</option>
                                    @endforeach
                                </select>

                                @error('validity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="valid_till" class="col-md-4 col-form-label text-md-right">{{ __('Valid Till Date') }}</label>

                            <div class="col-md-6">
                                <!-- Read-only field to display "Valid Till" date -->
                                <input type="text" name="valid_till" class="form-control" value="{{$data->valid_till}}" id="valid_till_date" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#approved{{ $data->special_pass_visitors_id }}">Approved</button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#reject{{ $data->special_pass_visitors_id }}">Reject</button>
                                <a href="{{route('specialpass')}}" class="btn btn-primary btn-sm">Cancel</a>
                            </div>
                        </div>
                    </form>

                     <!--Approved Modal -->
                    <div class="modal fade" id="approved{{ $data->special_pass_visitors_id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel{{ $data->special_pass_visitors_id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ route('approved.special_pass', ['id' => $data->special_pass_visitors_id]) }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="approvedLabel{{ $data->special_pass_visitors_id }}">Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to processed?</p>
                                        <label for="approveremark">Remark</label>
                                        <input type="text" name="approveremark" id="approveremark" class="form-control">
                                        <input type="hidden" name="approveaction" value="approved">
                                    </div>
                                    <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Approve</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Reject Model --}}

                    <div class="modal fade" id="reject{{ $data->special_pass_visitors_id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel{{ $data->special_pass_visitors_id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ route('reject.special_pass', ['id' => $data->special_pass_visitors_id]) }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectLabel{{ $data->special_pass_visitors_id }}">Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to processed?</p>
                                        <label for="rejectremark">Remark</label>
                                        <input type="text" name="rejectremark" id="rejectremark" class="form-control">
                                        <input type="hidden" name="action" value="reject">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#validity').on('change', function () {
            var selectedDays = parseInt($(this).val());
            if (!isNaN(selectedDays)) {
                var currentDate = new Date();
                var validTillDate = new Date(currentDate.getTime() + (selectedDays * 24 * 60 * 60 * 1000));
                var formattedDate = formatDate(validTillDate); // Format the date
                $('#valid_till_date').val(formattedDate);
            } else {
                $('#valid_till_date').val('');
            }
        });
 
        // Function to format the date as 'YYYY-MM-DD'
        function formatDate(date) {
            var year = date.getFullYear();
            var month = (date.getMonth() + 1).toString().padStart(2, '0'); // Add leading zero if needed
            var day = date.getDate().toString().padStart(2, '0'); // Add leading zero if needed
            return day + '-' + month + '-' + year;
        }
    });
 </script>
 

@endsection
    