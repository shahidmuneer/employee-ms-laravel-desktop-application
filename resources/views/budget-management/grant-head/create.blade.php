@extends('budget-management.grant.base')
@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Add New Grant Head</div>
                <div class="panel-body">
                    <form  role="form" method="POST" action="{{ route('grant-head.store') }}">
                        {{ csrf_field() }}

                        <div class="form-horizontal">
                       <div class="form-group {{ $errors->has('date') ? ' has-error' : '' }}">
                            <label for="date" class="col-md-4 control-label"> Date</label>

                            <div class="col-md-6">
                                <input id="date" type="date" class="form-control" name="date" value="{{ old('date') }}" required >

                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        
<!--                         <div class="form-group {{ $errors->has('grant_id') ? ' has-error' : '' }}">
                            <label for="date" class="col-md-4 control-label"> Grant</label>

                           
                        </div>-->
                            
                            
                            
                    
                            
                            
                        <div class="form-group {{ $errors->has('type_id') ? ' has-error' : '' }}">
                            <label for="date" class="col-md-4 control-label">Type</label>

                            <div class="col-md-6">
                                 <select class="form-control" id="type_id" name="type_id">
                                     <option value="1">Original Budget Grant</option>
                                     <option value="2">Re-Appro Sup Grant</option>
                                     <option value="3">Modified Grant</option>
                                     <option value="4">Original Budget Grant</option>
                                     <option value="5">Expense</option>
                                </select>
                            </div>
                        </div>
                            
                        </div>
                        
                     <table class="table table-bordered">
                         
                        <thead>
                            <tr>
                           
            
                        
                        
                                <th class="col-lg-2">Grant</th>
                         <th class="col-lg-2 text-center">
                            Debit/Credit
                        </th>
                        
                     
                            <th class="col-md-2 text-center">
                               Amount
                            </th>
                
                        
                        
                         
                            
                            <th class="col-md-2">
                               Action
                            </th>
                            
                     </tr>
                          </thead>
                          <tbody >
                              
 <?php
 $grant_count=count($grants)-1;
 ?>
                              @foreach($grants as $top_grant)
                          
                              <tr>
                       <td class="col-lg-2">  
                            <select class="form-control" id="grant_id" name="grant_id[]">        
                            @foreach ($grants as $grant)    
                            <option {{$top_grant->id==$grant->id?"selected":""}}
                                value="{{$grant->id}}">{{$grant->name}}
                            </option>
                            @endforeach
                            </select>
                       </td>
                            <td class="col-md-2">
                                
                                <select name="doc[]" id="doc" class="form-control">
                                    <option value="0">Debit</option>
                                    <option value="1">Credit</option>
                                    
                                </select>
                            </td>
                            <td class="col-md-2">
                                <input id="amount" type="number" class="form-control" name="amount[]" value="{{ old('amount') }}" required >
                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </td>
                        
                        
                        
                        
                        
                        
                        <td class="col-md-2">
                        <div class="buttons">   
                            <a class="btn btn-primary {{$loop->index!=$grant_count?"btn-remove":"btn-add"}} btn-sm"> 
                                <i class="fa {{$loop->index!=$grant_count?"fa-remove":"fa-plus"}}"></i></a>
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
