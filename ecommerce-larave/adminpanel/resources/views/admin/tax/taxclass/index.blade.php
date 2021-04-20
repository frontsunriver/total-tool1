@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  {{ trans('labels.TaxClasses') }} <small>{{ trans('labels.ListingTaxClasses') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> {{ trans('labels.TaxClasses') }}</li>
            </ol>
        </section>

        <!--  content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="col-lg-6 form-inline" id="contact-form">
                                <form  name='registration' id="registration" class="registration" method="get" action="{{url('admin/tax/taxclass/filter')}}">
                                    <input type="hidden"  value="{{csrf_token()}}">
                                    <div class="input-group-form search-panel ">
                                        <select type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown" name="FilterBy" id="FilterBy"  >
                                            <option value="" selected disabled hidden>{{ trans('labels.Filter By') }}</option>
                                            <option value="Title"  @if(isset($name)) @if  ($name == "Title") {{ 'selected' }} @endif @endif>{{ trans('labels.Title') }}</option>
                                            <option value="Description" @if(isset($name)) @if  ($name == "Description") {{ 'selected' }}@endif @endif>{{ trans('labels.Description') }}</option>
                                        </select>
                                        <input type="text" class="form-control input-group-form " name="parameter" placeholder="Search term..." id="parameter" @if(isset($param)) value="{{$param}}" @endif >
                                        <button class="btn btn-primary " id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                        @if(isset($param,$name))  <a class="btn btn-danger " href="{{url('admin/tax/taxclass/display')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                                    </div>
                                </form>
                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                            </div>
                            <div class="box-tools pull-right">
                                <a href="{{url('admin/tax/taxclass/add')}}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddTaxClass') }}</a>
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
                                            <th>@sortablelink('tax_class_id', trans('labels.ID') )</th>
                                            <th>@sortablelink('tax_class_title', trans('labels.Title') )</th>
                                            <th>@sortablelink('tax_class_description', trans('labels.Description') )</th>
                                            <th>@sortablelink('created_at', trans('labels.Date') )</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($tax_class as $key=>$data)
                                            <tr>
                                                <td>{{ $data->tax_class_id }}</td>
                                                <td>{{ $data->tax_class_title }}</td>
                                                <td width="30%">{{ $data->tax_class_description }}</td>
                                                <td>
                                                    <strong>{{ trans('labels.AddedDate') }}: </strong>{{ $data->created_at }}<br>
                                                    <strong>{{ trans('labels.LastModified') }}: </strong>{{ $data->updated_at }}
                                                </td>
                                                <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="{{url('admin/tax/taxclass/edit/'. $data->tax_class_id) }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteTaxClassId" tax_class_id ="{{ $data->tax_class_id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    @if($tax_class != null)
                                      <div class="col-xs-12 text-right">
                                          {{$tax_class->links()}}
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
            <!-- deleteTaxClassModal -->
            <div class="modal fade" id="deleteTaxClassModal" tabindex="-1" role="dialog" aria-labelledby="deleteTaxClassModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteTaxClassModalLabel">{{ trans('labels.DeleteTaxClass') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/tax/taxclass/delete', 'name'=>'deleteTaxClass', 'id'=>'deleteTaxClass', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'tax_class_id')) !!}
                        <div class="modal-body">
                            <p>{{ trans('labels.DeleteTaxClassText') }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteTaxClass">{{ trans('labels.Delete') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <!--  row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
