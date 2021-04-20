@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.EditMenu') }} <small>{{ trans('labels.EditMenu') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/menus')}}"><i class="fa fa-gears"></i> {{ trans('labels.ListingAllMenu') }}</a></li>
                <li class="active">{{ trans('labels.EditMenu') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.EditMenu') }} </h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                    <!--<div class="box-header with-border">
                          <h3 class="box-title">{{ trans('labels.EditPage') }}</h3>
                        </div>-->
                                        <!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">
                                            @if( count($errors) > 0)
                                                @foreach($errors->all() as $error)
                                                    <div class="alert alert-success" role="alert">
                                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                                        <span class="sr-only">{{ trans('labels.Error') }}:</span>
                                                        {{ $error }}
                                                    </div>
                                                @endforeach
                                            @endif

                                            {!! Form::open(array('url' =>'admin/updatemenu', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                            {!! Form::hidden('id',  $result['menus'][0]->id, array('class'=>'form-control', 'id'=>'id')) !!}
                                            

                                            @foreach($result['description'] as $description_data)
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Name') }} ({{ $description_data['language_name'] }}) </label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="menuName_<?=$description_data['languages_id']?>" class="form-control field-validate" value="{{$description_data['name']}}" >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Name') }} ({{ $description_data['language_name'] }})</span>

                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>

                                            @endforeach
                                            <div class="form-group">
                                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Type') }} </label>
                                              <div class="col-sm-10 col-md-4">
                                                <select required id="select_id" onchange="showPageSelect()" class="form-control" name="type">
                                                      <option>{{ trans('labels.Select Type') }}</option>
                                                      <option @if($result['menus'][0]->type == 0) selected @endif value="0">{{ trans('labels.External Link') }}</option>
                                                      <option @if($result['menus'][0]->type == 1) selected @endif value="1">{{ trans('labels.Link') }}</option>
                                                      <option @if($result['menus'][0]->type == 2) selected @endif value="2">{{ trans('labels.Content Page') }}</option>
                                                      <option @if($result['menus'][0]->type == 5) selected @endif value="5">{{ trans('labels.Page') }}</option>
                                                      <option @if($result['menus'][0]->type == 3) selected @endif value="3">{{ trans('labels.Category') }}</option>
                                                      <option @if($result['menus'][0]->type == 4) selected @endif value="4">{{ trans('labels.Product') }}</option>
                                                </select>
                                              <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                              {{ trans('labels.GeneralStatusText') }}</span>
                                              </div>
                                            </div>
                                            <div class="form-group external_link @if($result['menus'][0]->type != 0) hidden @endif">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.External_Link') }}<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    <input value="{{$result['menus'][0]->link}}" name="external_link" class="form-control menu">
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group link @if($result['menus'][0]->type != 1) hidden @endif">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Link') }}<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    
                                                    @if($result['menus'][0]->type == 1)
                                                    <input value="{{$result['menus'][0]->link}}" name="link" class="form-control menu">
                                                    @else
                                                    <input value="" name="link" class="form-control menu">
                                                    @endif
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group page @if($result['menus'][0]->type != 2) hidden @endif">
                                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Content Page') }} </label>
                                              <div class="col-sm-10 col-md-4">
                                                <select class="form-control" name="page_id">
                                                  @foreach($result['pages'] as $page)
                                                      <option @if($result['menus'][0]->link == $page->slug) selected @endif value="{{$page->slug}}">{{ $page->name}}</option>
                                                  @endforeach
                                                </select>
                                              <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                              {{ trans('labels.GeneralStatusText') }}</span>
                                              </div>
                                            </div>

                                            <div class="form-group category @if($result['menus'][0]->type != 3) hidden @endif">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Category') }} </label>
                                                <div class="col-sm-10 col-md-4">
                                                  <select class="form-control" name="category_slug">
                                                    @foreach($result['categories'] as $category)
                                                        <option value="{{$category->slug}}" @if($result['menus'][0]->link == $category->slug) selected @endif >{{ $category->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                {{ trans('labels.GeneralStatusText') }}</span>
                                                </div>
                                            </div>
    
                                            <div class="form-group product @if($result['menus'][0]->type != 4) hidden @endif">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Product') }} </label>
                                                <div class="col-sm-10 col-md-4">
                                                  <select class="form-control" name="product_slug">
                                                    @foreach($result['products'] as $product)
                                                        <option value="{{$product->products_slug}}" @if($result['menus'][0]->link == $product->products_slug) selected @endif>{{ $product->products_name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                {{ trans('labels.GeneralStatusText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group pages2 @if($result['menus'][0]->type != 5) hidden @endif">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Page') }} </label>
                                                <div class="col-sm-10 col-md-4">
                                                  <select class="form-control" name="pages2">
                                                    <option value="/" @if($result['menus'][0]->link == '/') selected @endif >@lang('labels.Home')</option>
                                                    <option value="/shop" @if($result['menus'][0]->link == '/shop') selected @endif>@lang('labels.Shop')</option>
                                                    <option value="/news" @if($result['menus'][0]->link == '/news') selected @endif>@lang('labels.News')</option>
                                                    <option value="/contact" @if($result['menus'][0]->link == '/contact') selected @endif>@lang('labels.Contact Us')</option>
                                                  </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                {{ trans('labels.GeneralStatusText') }}</span>
                                                </div>
                                            </div>

                                            <script>
                                              function showPageSelect(){
                                                   var d = document.getElementById("select_id").value;
                                                   if(d == 0){
                                                        jQuery('.external_link').removeClass("hidden");
                                                        jQuery('.link').addClass("hidden");
                                                        jQuery('.page').addClass("hidden");
                                                        jQuery('.category').addClass("hidden");
                                                        jQuery('.product').addClass("hidden");
                                                        jQuery('.pages2').addClass("hidden");
                                                    }
                                                    else if(d == 1) {
                                                        jQuery('.external_link').addClass("hidden");
                                                        jQuery('.link').removeClass("hidden");
                                                        jQuery('.page').addClass("hidden");    
                                                        jQuery('.category').addClass("hidden");
                                                        jQuery('.product').addClass("hidden");  
                                                        jQuery('.pages2').addClass("hidden");                                         
                                                    }else if(d == 2) {
                                                        jQuery('.external_link').addClass("hidden");
                                                        jQuery('.link').addClass("hidden");
                                                        jQuery('.page').removeClass("hidden");
                                                        jQuery('.category').addClass("hidden");
                                                        jQuery('.product').addClass("hidden");
                                                        jQuery('.pages2').addClass("hidden");
                                                    }else if(d == 3) {
                                                        jQuery('.external_link').addClass("hidden");
                                                        jQuery('.link').addClass("hidden");
                                                        jQuery('.page').addClass("hidden");
                                                        jQuery('.category').removeClass("hidden");
                                                        jQuery('.product').addClass("hidden");
                                                        jQuery('.pages2').addClass("hidden");
                                                    }else if(d == 4) {
                                                        jQuery('.external_link').addClass("hidden");
                                                        jQuery('.link').addClass("hidden");
                                                        jQuery('.page').addClass("hidden");
                                                        jQuery('.category').addClass("hidden");
                                                        jQuery('.product').removeClass("hidden");
                                                        jQuery('.pages2').addClass("hidden");
                                                    }else if(d == 5) {
                                                        jQuery('.external_link').addClass("hidden");
                                                        jQuery('.link').addClass("hidden");
                                                        jQuery('.page').addClass("hidden");
                                                        jQuery('.category').addClass("hidden");
                                                        jQuery('.product').addClass("hidden");
                                                        jQuery('.pages2').removeClass("hidden");
                                                        
                                                    }
                                              }
                                            </script>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="1"  @if($result['menus'][0]->status=='1') selected @endif>{{ trans('labels.Active') }}</option>
                                                        <option value="0"  @if($result['menus'][0]->status=='0') selected @endif>{{ trans('labels.InActive') }}</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.StatusPageText') }}</span>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                <a href="{{ URL::to('admin/menus')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                            </div>

                                            <!-- /.box-footer -->
                                            {!! Form::close() !!}
                                        </div>
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
    <script src="{!! asset('plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>
    <script type="text/javascript">
        $(function () {

            //for multiple languages
            @foreach($result['languages'] as $languages)
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('editor_{{$languages->languages_id}}');

            @endforeach

            //bootstrap WYSIHTML5 - text editor
            $(".textarea").wysihtml5();

        });
    </script>
@endsection
