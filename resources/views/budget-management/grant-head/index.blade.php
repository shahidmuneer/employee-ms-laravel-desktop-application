@extends('budget-management.grant-head.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">List of Grants</h3>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ route('grant-head.create') }}">Add new Grant</a>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ route('grant-head.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Search'])
          @component('layouts.two-cols-search-row', ['items' => ['Name'], 
          'oldVals' => [isset($searchingVals) ? $searchingVals['name'] : '']])
          @endcomponent
        @endcomponent
      </form>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
                <tr >
                    <th><input type="checkbox" id="selectall"></th>
                <th width="10%" rowspan="1" colspan="1">ID</th>
                
                <th width="10%" rowspan="1" colspan="1">Grant</th>
                
                <th width="10%" rowspan="1" colspan="1">Debit</th>
                <th width="10%" rowspan="1" colspan="1">Credit</th>
                <th width="30%" rowspan="1" colspan="1">date</th>
                <th width="30%" rowspan="1" colspan="1">Description</th>
                <th rowspan="1">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($grantHeads as $grantHead)
                <tr role="row" class="odd">
                    
                    <th><input type="checkbox" id="checkbox" name="id" value="{{$grantHead->id}}"></th>
                  <td>{{$loop->index+1}}</td>
                  <td>{{ $grantHead->grant->name }}</td>
                  <td>{{ $grantHead->debit }}</td>
                  <td>{{ $grantHead->credit }}</td>
                  <td>{{ $grantHead->date }}</td>
                  <td>{{ $grantHead->description }}</td>
                  <td>
                    <form class="row" method="POST" action="{{ route('grant-head.destroy', ['id' => $grantHead->id]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ route('grant-head.edit', ['id' => $grantHead->id]) }}" class="btn btn-warning fa fa-edit btn-margin">
                     edit
                        </a>
                        <button type="submit" class="btn btn-danger fa fa-trash btn-margin">
                          Delete
                        </button>
                    </form>
                  </td>
              </tr>
            @endforeach
            </tbody>
            <tfoot>
               <tr>
                   <th></th>
                <th width="10%" rowspan="1" colspan="1">ID</th>
                <th width="10%" rowspan="1" colspan="1">Code</th>
                <th width="20%" rowspan="1" colspan="1">Main Name</th>
                <th width="30%" rowspan="1" colspan="1">Name</th>
                <th rowspan="1">Action</th>
              </tr>
            </tfoot>
          </table>
            <form id="editForm" action="{{route('grant-head.edit', ['id' => "all"] )}}" method="get">
               {{csrf_field()}}
               <input type="hidden" name="id" id="editids">
                <div class="form-group">
                    <div class="col-lg-4">
                        <button id="edit" class="btn btn-primary">Edit</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($grantHeads)}} of {{count($grantHeads)}} entries</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $grantHeads->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection