@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  {{ trans('labels.languages') }} <small>{{ trans('labels.ListingAllLanguages') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> {{ trans('labels.languages') }}</li>
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
                                <form  name='registration' id="registration" class="registration" method="get" action="{{url('admin/languages/filter')}}">
                                    <input type="hidden"  value="{{csrf_token()}}">
                                    <div class="input-group-form search-panel ">
                                        <select type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown" name="FilterBy" id="FilterBy"  >
                                            <option value="" selected disabled hidden>{{trans('labels.Filter By')}}</option>
                                            <option value="Language"  @if(isset($filter)) @if  ($filter == "Name") {{ 'selected' }} @endif @endif>{{trans('labels.Language')}}</option>
                                            <option value="Code" @if(isset($filter)) @if  ($filter == "E-mail") {{ 'selected' }}@endif @endif>{{trans('labels.Code')}}</option>
                                        </select>
                                        <input type="text" class="form-control input-group-form " name="parameter" placeholder="Search term..." id="parameter" @if(isset($parameter)) value="{{$parameter}}" @endif >
                                        <button class="btn btn-primary " id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                        @if(isset($parameter,$filter))  <a class="btn btn-danger " href="{{url('admin/languages/display')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                                    </div>
                                </form>
                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                            </div>
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/languages/add')}}" type="button" style="display:inline-block; width: auto; margin-top: 0;" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    @if ($errors)
                                        @if($errors->any())
                                            <div @if ($errors->first()=='Default can not Deleted!!') class="alert alert-danger alert-dismissible" @else class="alert alert-success alert-dismissible" @endif role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{$errors->first()}}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="row default-div hidden">
                                <div class="col-xs-12">
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        {{ trans('labels.DefaultLanguageChangedMessage') }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@sortablelink('languages_id', trans('labels.ID') )</th>
                                            <th>@sortablelink('languages_id',  trans('labels.Default') )</th>
                                            <th>@sortablelink('name',  trans('labels.Language') )</th>
                                            <th>{{ trans('labels.Icon') }}</th>
                                            <th>@sortablelink('code',  trans('labels.Code') )</th>
                                            <th>@sortablelink('sort_order',  trans('labels.Sort') )</th>
                                            <th>{{trans('labels.Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($result['languages'])
                                            @foreach ($result['languages'] as $key=>$languages)
                                                <tr>
                                                    <td>
                                                        {{ $languages->languages_id}}
                                                    </td>
                                                      <td>
                                                        <label>
                                                            <input type="radio" name="languages_id" value="{{ $languages->languages_id}}"  class="default_language" @if($languages->is_default==1) checked @endif >
                                                        </label>
                                                    </td>
                                                    <td>{{ $languages->name }}</td>
                                                    <td><img src="{{asset($languages->path)}}" width="25px" alt=""></td>
                                                    <td>{{ $languages->code }}</td>
                                                    <td>{{ $languages->sort_order }}</td>
                                                    <td>
                                                        <a data-toggle="tooltip" data-placement="bottom" title=" {{ $languages->name }}" href="{{ URL::to('admin/languages/edit/'.$languages->languages_id)}}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        @if($languages->is_default==0)
                                                            <a data-toggle="tooltip" data-placement="bottom" title=" {{ $languages->name }}" id="deleteLanguageId" languages_id ="{{ $languages->languages_id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">{{ trans('labels.Nolanguageexist') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                        @if($result['languages'] != null)
                                        <div class="col-xs-12 text-right">
                                            {{$result['languages']->links()}}
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
            <!-- deletelanguagesModal -->
            <div class="modal fade" id="deleteLanguagesModal" tabindex="-1" role="dialog" aria-labelledby="deleteLanguagesModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteLanguagesModalLabel">{{ trans('labels.DeleteLanguages') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/languages/delete', 'name'=>'deletelanguages', 'id'=>'deletelanguages', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'languages_id')) !!}
                        <div class="modal-body">
                            <p>{{ trans('labels.confrimLanguageDelete') }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deletelanguages">{{ trans('labels.Delete') }}</button>
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
