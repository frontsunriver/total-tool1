@extends('admin.layout')

@section('content')

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

            <h1> {{ trans('labels.Options') }} <small>{{ trans('labels.ListingAllOptions') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.Options') }}</li>
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
                            <h3 class="box-title"> {{ trans('labels.ListingAllOptions') }} </h3>
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/products/attributes/add')}}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
                            </div>
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
                                            <th>{{ trans('labels.ID') }}</th>
                                            <th>{{ trans('labels.Options') }}</th>
                                            <th width="40%">{{ trans('labels.Values') }}</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['attributes'])>0)
                                            @foreach($result['attributes'] as $data)
                                                <tr>
                                                    <td>{{$data->products_options_id}}</td>
                                                    <td dir="ltr">
                                                        @foreach($data->data as $language)
                                                            <strong>{{$language->name}}:</strong>
                                                            @if(count($language->attributes)>0)
                                                                @foreach($language->attributes as $attribute)
                                                                    {{$attribute->options_name}}<br>
                                                                @endforeach
                                                            @else
                                                                --- <br>
                                                            @endif
                                                        @endforeach
                                                        <a href="{{ URL::to('admin/products/attributes/edit')}}/{{$data->products_options_id}}" >{{ trans('labels.Manage Options') }}</a><br>
                                                    </td>
                                                    <td dir="ltr">
                                                        @foreach($data->data as $language)
                                                            <strong>{{$language->name}}:</strong>
                                                            @if(count($language->values)>0)
                                                                @foreach($language->values as $value)
                                                                    {{$value->options_values_name}},
                                                                @endforeach
                                                            @else
                                                                --- <br>
                                                            @endif
                                                            <br>
                                                        @endforeach
                                                        <a href="{{ URL::to('admin/products/attributes/options/values/display')}}/{{$data->products_options_id}}" >{{ trans('labels.Manage Values') }}</a><br>
                                                    </td>
                                                    <td><a option_id="{{$data->products_options_id}}" class="badge bg-red deleteOption"><i class="fa fa-trash " aria-hidden="true"></i></a></td>
                                                </tr>

                                            @endforeach
                                        @endif
                                        </tbody>

                                    </table>

                                    <div class="col-xs-12 text-right">


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

            <!-- deleteAttributeModal -->

            <div class="modal fade" id="deleteattributeModal" tabindex="-1" role="dialog" aria-labelledby="deleteAttributeModalLabel">

                <div class="modal-dialog" role="document">

                    <div class="modal-content">

                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                            <h4 class="modal-title" id="deleteAttributeModalLabel">{{ trans('labels.DeleteOption') }}</h4>

                        </div>

                        {!! Form::open(array('url' =>'admin/products/attributes/delete', 'name'=>'deleteAttribute', 'id'=>'deleteAttribute', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}

                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}

                        {!! Form::hidden('option_id',  '', array('class'=>'form-control', 'id'=>'option_id')) !!}

                        <div class="modal-body">

                            <p>{{ trans('labels.DeleteOptionPrompt') }}</p>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>

                            <button type="submit" class="btn btn-primary" id="deleteAttribute">{{ trans('labels.DeleteOption') }}</button>

                        </div>

                        {!! Form::close() !!}

                    </div>

                </div>

            </div>



            <div class="modal fade" id="productListModal" tabindex="-1" role="dialog" aria-labelledby="productListModalLabel">

                <div class="modal-dialog" role="document">

                    <div class="modal-content">

                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                            <h4 class="modal-title" id="productListModalLabel"></h4>

                        </div>

                        <div class="modal-body">
                            <p><strong>{{ trans('labels.DeletingErrorMessage') }}</strong></p>
                            <ul style="padding:0" id="assciate-products">
                            </ul>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Ok') }}</button>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Main row -->
            <!-- /.row -->
        </section>
        <!-- /.content -->

    </div>

@endsection
