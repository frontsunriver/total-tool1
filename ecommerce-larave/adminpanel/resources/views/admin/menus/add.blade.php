@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Menus') }} <small>{{ trans('labels.AddMenus') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/menus')}}"><i class="fa fa-database"></i>{{ trans('labels.Menus') }}</a></li>
            <li class="active">{{ trans('labels.AddMenus') }}</li>
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
                        <h3 class="box-title">{{ trans('labels.AddMenus') }} </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!-- form start -->
                                    <br>
                                    @if (count($errors) > 0)
                                    @if($errors->any())
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{$errors->first()}}
                                    </div>
                                    @endif
                                    @endif
                                    <div class="box-body">

                                        {!! Form::open(array('url' =>'admin/addnewmenu', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                        <div class="form-group" hidden>
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Menu') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control" name="parent_id">
                                                  <option value="0">Leave as Parent</option>
                                                  @foreach($result['menus'] as $menu)
                                                    <option value="{{$menu->id}}">{{$menu->name}}</option>
                                                  @endforeach
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.ChooseMainMenu') }}</span>
                                            </div>
                                        </div>

                                        @foreach($result['languages'] as $languages)
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Name') }}<span style="color:red;">*</span> ({{ $languages->name }})</label>
                                            <div class="col-sm-10 col-md-4">
                                                <input required name="menuName_<?=$languages->languages_id?>" class="form-control menu">
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.SubMenuName') }} ({{ $languages->name }}).</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                        @endforeach

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Type') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            <select required id="select_id" onchange="showPageSelect()" class="form-control" name="type">
                                                  <option>{{ trans('labels.Select Type') }}</option>
                                                  <option value="0">{{ trans('labels.External Link') }}</option>
                                                  <option value="1">{{ trans('labels.Link') }}</option>
                                                  <option value="2">{{ trans('labels.Content Page') }}</option>
                                                  <option value="5">{{ trans('labels.Page') }}</option>
                                                  <option value="3">{{ trans('labels.Category') }}</option>
                                                  <option value="4">{{ trans('labels.Product') }}</option>
                                            </select>
                                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                          {{ trans('labels.GeneralStatusText') }}</span>
                                          </div>
                                        </div>
                                        <div class="form-group external_link hidden">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.External_Link') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-4">
                                                <input name="external_link" class="form-control menu">
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.SubMenuName') }} ({{ $languages->name }}).</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group link hidden">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Link') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-4">
                                                <input name="link" class="form-control menu">
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.SubMenuName') }} ({{ $languages->name }}).</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group page hidden">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Content Page') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            <select class="form-control" name="page_id">
                                              <option value="">Select Page</option>
                                              @foreach($result['pages'] as $page)
                                                  <option value="{{$page->slug}}">{{ $page->name}}</option>
                                              @endforeach
                                            </select>
                                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                          {{ trans('labels.GeneralStatusText') }}</span>
                                          </div>
                                        </div>
                                        
                                        <div class="form-group category hidden">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Category') }} </label>
                                            <div class="col-sm-10 col-md-4">
                                              <select class="form-control" name="category_slug">
                                                @foreach($result['categories'] as $category)
                                                    <option value="{{$category->slug}}">{{ $category->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                            {{ trans('labels.GeneralStatusText') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group product hidden">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Product') }} </label>
                                            <div class="col-sm-10 col-md-4">
                                              <select class="form-control" name="product_slug">
                                                @foreach($result['products'] as $product)
                                                    <option value="{{$product->products_slug}}">{{ $product->products_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                            {{ trans('labels.GeneralStatusText') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group pages2 hidden">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Page') }} </label>
                                            <div class="col-sm-10 col-md-4">
                                              <select class="form-control" name="pages2">
                                                <option value="/">@lang('labels.Home')</option>
                                                <option value="/shop">@lang('labels.Shop')</option>
                                                <option value="/news">@lang('labels.News')</option>
                                                <option value="/contact">@lang('labels.Contact Us')</option>
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
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            <select class="form-control" name="status">
                                                  <option value="1">{{ trans('labels.Active') }}</option>
                                                  <option value="0">{{ trans('labels.Inactive') }}</option>
                                            </select>
                                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                          {{ trans('labels.GeneralStatusText') }}</span>
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

@endsection
