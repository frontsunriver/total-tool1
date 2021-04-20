@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Rating / Reviews') }} <small>{{ trans('labels.Listing Rating / Reviews') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/deliveryboys/display')}}"><i class="fa fa-users"></i> {{ trans('labels.Listing Delivery Boys') }}</a></li>
            <li class="active">{{ trans('labels.Rating / Reviews') }}</li>
        </ol>
    </section>
<style>
.checked {
  color: orange;
}
</style>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->

        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="col-xs-12">
                        </hr>
                            <h3>{{ trans('labels.Reviews and Rating of') }} {{$result['averagerating'][0]->first_name}} {{$result['averagerating'][0]->last_name}}</h4>
                        </hr>
                        </br>
                    </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="panel panel-default panel-sale text-center">
                                <div class="panel-heading">{{ trans('labels.Average Ratings') }}</div>
                                <div class="panel-body">
                                    <div class="count">
                                        {{$result['averagerating'][0]->rating}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="panel panel-default panel-sale text-center">
                                <div class="panel-heading">{{ trans('labels.Total User Rated') }}</div>
                                <div class="panel-body">
                                    <div class="count">
                                        {{$result['averagerating'][0]->total_user_rated}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        </br>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                </hr>
                                    <h3>{{ trans('labels.Rating / Reviews') }}</h4>
                                </hr>
                            </div>
                        </div>
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
                                            <th>{{ trans('labels.Users') }}</th>
                                            <th>{{ trans('labels.Rating') }}</th>
                                            <th>{{ trans('labels.Descriptions') }}</th>
                                            <th>{{ trans('labels.Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($result['indvidualratings']))
                                        @foreach ($result['indvidualratings'] as $key=>$rating)
                                        <tr>
                                            <td>{{ $rating->customers_name }}</td>  
                                            <td>                                                
                                                @for($i=1; $i<=5; $i++)
                                                    @if($rating->reviews_rating>=$i)
                                                        <span class="fa fa-star checked"></span>                                                
                                                    @else
                                                        <span class="fa fa-star"></span>   
                                                    @endif    
                                                @endfor
                                            </td>  
                                            <td>{{ $rating->reviews_text }}</td>  
                                            <td>{{ date_format(date_create($rating->created_at), 'Y-m-d') }}</td>  
                                            <td>
                                                <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteTaxRateId" tax_rates_id ="{{ $rating->reviews_id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                                
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>

        <div class="modal fade" id="deleteTaxRateModal" tabindex="-1" role="dialog" aria-labelledby="deletetaxRateModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteTaxRateModalLabel">{{ trans('labels.Delete') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/deliveryboys/ratings/delete', 'name'=>'deletetaxRate', 'id'=>'deletetaxRate', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'tax_rates_id')) !!}
                        <div class="modal-body">
                            <p>{{ trans('labels.DeleteText') }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deletetaxRate">{{ trans('labels.Delete') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        <!-- /.row -->

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

@endsection
