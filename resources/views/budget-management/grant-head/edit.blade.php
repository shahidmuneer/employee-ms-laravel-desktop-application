@extends('budget-management.grant.base')
@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Add New Grant Head</div>
                <div class="panel-body">
                    <form  role="form" method="POST" action="{{ route('grant-head.update',["id"=>1]) }}">
                       <input type="hidden" name="_method" value="PATCH">
                        {{ csrf_field() }}

                     <table class="table table-bordered">
                         
                        <thead>
                            <tr>
                                
                            <th class="col-md-2">
                               Grant Name
                            </th>
            
                        
                        
                    
                         <th class="col-lg-2">
                            Credit
                        </th>
                        
                     
                            <th class="col-md-2">
                               Amount
                            </th>
                
                        
                        
                         
                            <th class="col-md-2">
                               Date 
                            </th>
                            <th class="col-md-2">
                               Action
                            </th>
                            
                     </tr>
                          </thead>
                          <tbody >
                              @foreach($grant_heads as $grant_head)
                              
                              <tr>
                          <input type="hidden" value="{{$grant_head->id}}" name="id[]">
                            <td class="col-md-2">
                                <select class="form-control" name="grant_id[]">
                                    @foreach ($grants as $grant)
                                    <option {{$grant_head->id==$grant->id?"selected":""}}  value="{{$grant->id}}">{{$grant->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                       
                            <td class="col-md-2">
                                <input type="checkbox" {{$grant_head->credit==0?"checked":""}}  name="credit[]">
                            </td>

                            <td class="col-md-2">
                                <input id="amount" value="{{$grant_head->credit==0?$grant_head->debit:$grant_head->credit}}" type="text" class="form-control" name="amount[]" value="{{ old('amount') }}" required >

                               
                            </td>
                        
                        
                        
                        
                        <td class="{{ $errors->has('date') ? ' has-error' : '' }}">
                            
                                <input id="date" type="date" value="{{date('Y-m-d', strtotime($grant_head->date))}}" class="form-control" name="date[]" value="{{ old('date') }}" required >

                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                           
                        </td>
                        
                        
                        
                        <td class="col-md-2">
                        <div class="buttons">   
                            <a class="btn btn-primary btn-add btn-sm"> <i class="fa fa-plus"></i></a>
                        </div>
                        </td>
                              </tr>
                              @endforeach
                          </tbody>
                        
</table>
                        <div class="form-group row container clearfix">
                            <div class="col-md-6 ">
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
