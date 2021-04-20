@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.stockin') }} <small>{{ trans('labels.stockin') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.stockin') }}</li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content"> 
    <!-- Info boxes --> 
    
    <!-- /.row -->
    
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ trans('labels.ProductName') }} : {{ $result['products'][0]->products_name }} @if(!empty($result['products'][0]->products_model)) ( {{ $result['products'][0]->products_model }} )@endif</h3>
          </div>          
          <!-- /.box-header -->
          <div class="box-body">
            
            <div class="row">
              <div class="col-xs-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{ trans('labels.AddedBy') }}</th>
                      <th>{{ trans('labels.AddedDate') }}</th>
                      <th>{{ trans('labels.Stock') }}</th>
                      <th>{{ trans('labels.Reference / Purchase Code') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(!empty($result['products']['history']) and count($result['products']['history']) > 0)
                    @foreach ($result['products']['history'] as  $key=>$history)
                        
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $history->first_name }} {{ $history->last_name }}</td>
                            <td>{{ $history->added_date }}</td>
                            <td>
                                {{ $history->stock }}
                            </td>
                            <td>
                            @if(!empty($history->reference_code))
                                {{ $history->reference_code }}
                            @else
                            	---
                            @endif
                            </td>                           
                        </tr>
                     @endforeach
                     @else
                     <tr><td>{{ trans('labels.Stock is not added yet') }}</td></tr>
                    @endif
                  </tbody>
                </table>
                   
              </div>
                      
                    </div>
          </div>
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
      </div>
      <!-- /.col --> 
    </div>
    
    <!-- Main row --> 
    
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
@endsection 