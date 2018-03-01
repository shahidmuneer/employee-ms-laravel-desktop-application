@extends('system-mgmt.bps_Deductions.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update bps_Deduction</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('bps_deduction.update', ['id' => $bps_deduction->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Bps Deduction Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $bps_deduction->name }}" required autofocus>

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
                                <input id="amount" type="text" class="form-control" name="amount" value="{{ $bps_deduction->amount }}" required >

                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('date_of_deduction') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label"> Date of Deduction</label>

                            <div class="col-md-6">
                               <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" value="{{ $bps_deduction->date_of_deduction }}" name="date_of_deduction" class="form-control pull-right" id="date_of_deduction" required>
                                </div>
                                @if ($errors->has('date_of_deduction'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_of_deduction') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        
                        
                        
                        <div class="form-group ">
                            <label class="col-md-4 control-label">Select Bps</label>
                            <div class="col-md-6">
                                <select class="form-control" name="bps_id">
                                    @foreach ($bpss as $bps)
                                        <option {{$bps_deduction->bps_id == $bps->id ? 'selected' : ''}} value="{{$bps->id}}">{{$bps->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
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
