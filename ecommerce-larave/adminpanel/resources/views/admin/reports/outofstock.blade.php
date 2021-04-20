@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.Productsoutofstock') }} <small>{{ trans('labels.Productsoutofstock') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.Productsoutofstock') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ trans('labels.Productsoutofstock') }} </h3>

            <div class="box-tools pull-right">
              <form action="{{ URL::to('admin/outofstockprint')}}" target="_blank">
                <input type="hidden" name="page" value="invioce">
                <button type='submit' class="btn btn-default pull-right"><i class="fa fa-print"></i> {{ trans('labels.Print') }}</button>
              </form>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>{{ trans('labels.ProductID') }}</th>
                      <th>{{ trans('labels.ProductName') }}</th>
                      <th>{{ trans('labels.Current Stock') }}</th>
                      <th></th>
                    </tr>
                  </thead>
                   <tbody>
                    @foreach ($result['reports'] as  $key=>$report)                   
                      <tr>
                          <td>{{ $report->products_id }}</td>  
                          <td>{{ $report->products_name }}</td>    
                          <td>0</td>    
                          <td>
                          <a data-toggle="tooltip" target="_blank" data-placement="bottom" title="{{ trans('labels.View') }}" href="{{url('admin/inventoryreport?type=all&products_id='.$report->products_id)}}" class="badge bg-light-blue"><i class="fa fa-eye" aria-hidden="true"></i></a>                                                                 
                          </td>                                                                     
                      </tr>
                    @endforeach
                    
                    
                  </tbody>
                </table>
                <div class="col-xs-12" style="background: #eee;">

                  @php
                    if($result['reports']->total()>0){
                      $fromrecord = ($result['reports']->currentpage()-1)*$result['reports']->perpage()+1;
                    }else{
                      $fromrecord = 0;
                    }
                    if($result['reports']->total() < $result['reports']->currentpage()*$result['reports']->perpage()){
                      $torecord = $result['reports']->total();
                    }else{
                      $torecord = $result['reports']->currentpage()*$result['reports']->perpage();
                    }

                  @endphp
                  <div class="col-xs-12 col-md-6" style="padding:30px 15px; border-radius:5px;">
                    <div>Showing {{$fromrecord}} to {{$torecord }}
                        of  {{ $result['reports']->total() }} entries
                    </div>
                  </div>
                <div class="col-xs-12 col-md-6 text-right">
                    {{ $result['reports']->appends(\Request::except('type'))->render() }}
                </div>
              </div>

            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->

    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@endsection
