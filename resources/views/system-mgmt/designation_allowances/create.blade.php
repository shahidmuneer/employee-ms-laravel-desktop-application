@extends('system-mgmt.designation_allowances.base')
@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new designation Allowance</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('designation_allowances.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Designation Allowances Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        
                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label"> Amount</label>

                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control" name="amount" value="{{ old('amount') }}" required >

                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('date_of_allowance') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label"> Date of Allowance</label>

                            <div class="col-md-6">
                               <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" value="{{ old('date_of_allowance') }}" name="date_of_allowance" class="form-control pull-right" id="date_of_allowance" required>
                                </div>
                                @if ($errors->has('date_of_allowance'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_of_allowance') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        
                        
                        
                        <div class="form-group ">
                            <label class="col-md-4 control-label">Select Designation</label>
                            <div class="col-md-6">
                                <select class="form-control" name="designation_id">
                                    @foreach ($designations as $designation)
                                        <option  value="{{$designation->id}}">{{$designation->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        
                        
                        
         
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
