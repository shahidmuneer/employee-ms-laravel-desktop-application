@extends('system-mgmt.designation_allowances.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">List of Designation allowances</h3>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ route('designation_allowances.create') }}">Add new Designation allowance</a>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ route('designation_allowances.search') }}">
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
                <th width="20%" rowspan="1" colspan="1">Name</th>
                <th width="20%" rowspan="1" colspan="1">Designation</th>
                <th width="20%" rowspan="1" colspan="1">Amount</th>
                <th width="20%" rowspan="1" colspan="1">Date of Allowance</th>
                <th rowspan="1" colspan="2">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($designation_allowances as $designation_allowance)
                <tr role="row" class="odd">
                  <td>{{ $designation_allowance->name }}</td>
                      <td>{{ $designation_allowance->designation->name }}</td>
                      <td>{{ $designation_allowance->amount }}</td>
                      <td>{{ $designation_allowance->date_of_allowance }}</td>
                  <td>
                    <form class="row" method="POST" action="{{ route('designation_allowances.destroy', ['id' => $designation_allowance->id]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ route('designation_allowances.edit', ['id' => $designation_allowance->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                        Update
                        </a>
                        <button type="submit" class="btn btn-danger col-sm-3 col-xs-5 btn-margin">
                          Delete
                        </button>
                    </form>
                  </td>
              </tr>
            @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th width="20%" rowspan="1" colspan="1">Name</th>
                <th width="20%" rowspan="1" colspan="1">Designation</th>
                <th width="20%" rowspan="1" colspan="1">Amount</th>
                <th width="20%" rowspan="1" colspan="1">Date of Allowance</th>
                <th rowspan="1" colspan="2">Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($designation_allowances)}} of {{count($designation_allowances)}} entries</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $designation_allowances->links() }}
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