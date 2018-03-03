@extends('budget-management.report.base')
@section('action-content')
    <!-- Main content -->
    <style>
        table.dataTable thead > tr > th{
            padding:0px;
        }
    </style>
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-4">
          <h3 class="box-title">Budget and Expenditure Statement</h3>
        </div>
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report.excel') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                <button type="submit" class="btn btn-primary">
                  Export to Excel
                </button>
            </form>
        </div>
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report.pdf') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                <button type="submit" class="btn btn-info">
                  Export to PDF
                </button>
            </form>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ route('report.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Search'])
          @component('layouts.two-cols-date-search-row', ['items' => ['From', 'To'], 
          'oldVals' => [isset($searchingVals) ? $searchingVals['from'] : '', isset($searchingVals) ? $searchingVals['to'] : '']])
          @endcomponent
         @endcomponent
      </form>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12 col-lg-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th width = "10%" aria-label="Name: activate to sort column ascending">Code Of Account</th>
                <th width = "10%" aria-label="Birthday: activate to sort column ascending">Object Classifications</th>
                <th width = "3.25%"  aria-label="Address: activate to sort column ascending">Original Budget Grant</th>
                <th width = "3.25%"  aria-label="Birthday: activate to sort column ascending">Re-Appro sup grant</th>
                <th width = "3.25%"  aria-label="Birthday: activate to sort column ascending">Modified Grant</th>
                <th width = "3.25%"  aria-label="Birthday: activate to sort column ascending">Reviesed Grant</th>
                <th width = "3.25%"  aria-label="Birthday: activate to sort column ascending">Previous Month Expenses </th>
                <th width = "3.25%" aria-label="Birthday: activate to sort column ascending">Present Month Expenses</th>
                <th width = "3.25%" aria-label="Birthday: activate to sort column ascending">Total Expened</th>
                <th width = "3.25%" aria-label="Birthday: activate to sort column ascending">Excess/Lapse Balance</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($grants as $grant)
                <tr role="row" class="odd">
                    <td>{{$grant->code}}</td>
                    <td>{{$grant->name}}</td>
                    <td>{{$original_grant=$grantHead->getOriginalBudgetGrant($grant->id)}}</td>
                    <td>{{$reapro_grant=$grantHead->getReapproSubGrant($grant->id)}}</td>
                    <td>{{$modified_grant=$grantHead->getModifiedGrant($grant->id)}}</td>
                    <td>{{$revised_budget_grant=$original_grant+$modified_grant+$reapro_grant}}</td>
                    <td>{{$previous_month_expenses=$grantHead->getPreviousMonthExpenses($grant->id)}}</td>
                    <td>{{$current_month_expenses=$grantHead->getCurrentMonthExpenses($grant->id)}}</td>
                    <td>{{$total_expenses=$previous_month_expenses+$current_month_expenses}}</td>
                    <td>{{$revised_budget_grant-$total_expenses}}</td> 
                </tr>
            @endforeach
            </tbody>
           
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($grants)}} of {{count($grants)}} entries</div>
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