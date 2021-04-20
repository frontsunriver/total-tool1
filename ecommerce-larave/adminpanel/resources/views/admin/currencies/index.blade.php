@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.Currencies') }} <small>{{ trans('labels.ListingAllCurrencies') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.Currencies') }}</li>
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
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/currencies/add')}}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
                            </div>
                            </br>
                        </div>

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
                                            <th>{{ trans('labels.Title') }}</th>
                                            <th>{{ trans('labels.code') }}</th>
                                            <th>{{ trans('labels.symbol') }}</th>
                                            <th>{{ trans('labels.Position') }}</th>
                                            <th style="display: none">{{ trans('labels.decimal_point') }}</th>
                                            <th style="display: none">{{ trans('labels.thousands_point') }}</th>
                                            <th>{{ trans('labels.decimal_places') }}</th>
                                            <th>{{ trans('labels.value') }}</th>
                                            <th style="display: none">@sortablelink('created_at', trans('labels.created_at') )</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($currencies)>0)
                                            @foreach ($currencies as $key=>$currency)
                                                    <tr>
                                                        <td>{{ $key+1 }} @if($currency->id==1) <span class="label label-success">{{ trans('labels.is_default') }}</span>@endif</td>
                                                        <td>{{ $currency->title }}</td>
                                                        <td>{{ $currency->code }}</td>
                                                        <td>{{ $currency->symbol_left }}
                                                            {{ $currency->symbol_right }}
                                                        </td>

                                                        <td>
                                                            @if(!empty($currency->symbol_left))
                                                                @lang('labels.Left')
                                                            @else
                                                                @lang('labels.Right')
                                                            @endif
                                                        </td>

                                                        <td style="display: none">{{ $currency->decimal_point }}</td>
                                                        <td style="display: none">{{ $currency->thousands_point }}</td>
                                                        <td>{{ $currency->decimal_places }}</td>
                                                        <td>{{ $currency->value }}</td>
                                                        <td style="display: none">
                                                            <strong>{{ trans('labels.AddedDate') }}: </strong> {{ $currency->created_at }}<br>
                                                            <strong>{{ trans('labels.ModifiedDate') }}: </strong>{{ $currency->updated_at }}
                                                        </td>
                                                        <td>
                                                        @if($currency->id!=1)
                                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{url('admin/currencies/edit/'. $currency->id) }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                            <a id="delete" category_id="{{$currency->id}}" href="#" class="badge bg-red " ><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                        @else
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{url('admin/currencies/edit/'. $currency->id) }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        @endif
                                                        </td>
                                                    </tr>

                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7">{{ trans('labels.NoRecordFound') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    @if($currencies != null)
                                      <div class="col-xs-12 text-right">
                                          {{$currencies->links()}}
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

            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteModalLabel">{{ trans('labels.Delete') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/currencies/delete', 'name'=>'deleteBanner', 'id'=>'deleteBanner', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'category_id')) !!}
                        <div class="modal-body">
                            <p>{{ trans('labels.DeleteText') }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteBanner">{{ trans('labels.Delete') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
