@extends('system-mgmt.bps.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update stage</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('stage.update', ['id' => $stage->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Stage Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $stage->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        
                         <div class="form-group{{ $errors->has('basic_pay') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Basic Pay </label>

                            <div class="col-md-6">
                                <input id="basic_pay" type="text" class="form-control" name="basic_pay" value="{{ $stage->basic_pay }}" required autofocus>

                                @if ($errors->has('basic_pay'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('basic_pay') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Select Year</label>
                            <div class="col-md-6">
                                <select class="form-control" name="year">
                                    @foreach ($years as $year)
                                        <option {{$year == $stage->year ? 'selected' : ''}} value="{{$year}}">{{$year}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Select Division</label>
                            <div class="col-md-6">
                                <select class="form-control" name="bps_id">
                                    @foreach ($bpss as $bps)
                                        <option {{$stage->bps_id == $bps->id ? 'selected' : ''}} value="{{$bps->id}}">{{$bps->name}}</option>
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
