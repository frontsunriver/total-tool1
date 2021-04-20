@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Withdraw') }} <small>{{ trans('labels.Withdraw Amount') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/deliveryboys/display')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.Delivery Boys') }}</a></li>
            <li class="active">{{ trans('labels.Withdraw') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->

        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                @if (count($errors) > 0)
                                  @if($errors->any())
                                  <div class="alert alert-success alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      {{$errors->first()}}
                                  </div>
                                  @endif
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>@sortablelink('id', trans('labels.ID') )</th>
                                            <th>@sortablelink('first_name', trans('labels.Name') )</th>
                                            <th>@sortablelink('amount', trans('labels.Amount') )</th>
                                            <th width="30%">{{ trans('labels.Notes') }}</th>
                                            <th>@sortablelink('created_at', trans('labels.Request Date') )</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customers-table">
                                        @if (isset($data['withdraw']))
                                        @foreach ($data['withdraw'] as $key=>$vendor)
                                        <tr>
                                            <td>{{ $vendor->payment_withdraw_id }}</td>
                                            <td>
                                                {{ $vendor->first_name }} {{ $vendor->last_name }}
                                            </td>
                                            <td>
                                                {{$data['setting'][19]->value}}{{ $vendor->amount }}
                                            </td>
                                            <td>                                               
                                                {{ $vendor->note }}
                                            </td>
                                            <td>                                               
                                                {{ $vendor->created_at }}
                                            </td>
                                            <td>
                                            <td>
                                                <!-- <a class="btn btn-success pay-popup-boy" payment_id = "{{ $vendor->payment_withdraw_id }}" delveryboy_id = "{{ $vendor->user_id }}" style="width: 100%; margin-bottom: 5px;" href="#">{{ trans('labels.Pay') }}</a> -->
                                            
                                                @if($vendor->status == 0)
                                                <button class="btn btn-default deliveryboy-pay-popup" payment_id = "{{ $vendor->payment_withdraw_id }}" deliveryboy_id = "{{ $vendor->user_id }}" >{{ trans('labels.Pay') }}</button>
                                                @else
                                                <span class="btn btn-success deliveryboy-pay-popup-paid" payment_id = "{{ $vendor->payment_withdraw_id }}" deliveryboy_id = "{{ $vendor->user_id }}">{{ trans('labels.Paid info') }}</span>
                                                @endif 
                                                
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4">{{ trans('labels.NoRecordFound') }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                @if (count($data['withdraw']) > 0)
                                <div class="col-xs-12 text-right">
                                    {!! $data['withdraw']->appends(\Request::except('page'))->render() !!}
                                </div>
                                @endif
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

        <!-- bankinfo -->
        <div class="modal fade" id="vendors-info" tabindex="-1" role="dialog" aria-labelledby="bankinfoModal">
            
        </div>

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

@endsection
