@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Theme Setting') }}
          @if($data['section_id'] == 1)
          <small>Home Page...</small>
          @elseif($data['section_id'] == 2)
          <small>Cart Page Settings...</small>
          @elseif($data['section_id'] == 3)
          <small>Blog Page Settings...</small>
          @elseif($data['section_id'] == 4)
          <small>Detail Page Settings...</small>
          @elseif($data['section_id'] == 5)
          <small>Shop Page Settings...</small>
          @elseif($data['section_id'] == 7)
            <small>Colors Settings</small>
          
          @elseif($data['section_id'] == 8)
          <small>@lang('labels.Login Page Settings') </small>
          @elseif($data['section_id'] == 9)
          <small>@lang('labels.News Page Settings') </small>
          @elseif($data['section_id'] == 10)
          <small>@lang('labels.News Page Settings') </small>
          @elseif($data['section_id'] == 11)
          <small>@lang('labels.Product Card Style') </small>

          @elseif($data['section_id'] == 12)
          <small>@lang('labels.Categorywidget') </small>

          @elseif($data['section_id'] == 13)
          <small>@lang('labels.Categories Section') </small>
                 
                       
          @else
          <small>Contact Page Settings...</small>
          @endif

          </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li >{{ trans('labels.link_site_settings') }}</li>
            <li >{{ trans('labels.Theme Setting') }}</li>
            @if($data['section_id'] == 1)
            <li class="active">Home Page</li>
            @elseif($data['section_id'] == 2)
            <li class="active">Cart Page Settings</li>
            @elseif($data['section_id'] == 3)
            <li class="active">Blog Page Settings</li>
            @elseif($data['section_id'] == 4)
            <li class="active">Detail Page Settings</li>
            @elseif($data['section_id'] == 5)
            <li class="active">Shop Page Settings</li>
            @elseif($data['section_id'] == 6)
            <li class="active">Shop Page Settings</li>
            @elseif($data['section_id'] == 7)
            <li class="active">Colors Settings</li>
            @elseif($data['section_id'] == 8)
            <li class="active">@lang('labels.Login Page Settings') </li>
            @elseif($data['section_id'] == 9)
            <li class="active">@lang('labels.News Page Settings') </li>            
            @elseif($data['section_id'] == 10)
            
            @elseif($data['section_id'] == 11)
              <li class="active">@lang('labels.Product Card Style') </li>
            @elseif($data['section_id'] == 12)
              <li class="active">@lang('labels.Categorywidget') </li>
            @elseif($data['section_id'] == 13)
            <li class="active">@lang('labels.Categories Section') </li>
            @endif


        </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="box-shadow:none;">

        <div class="row">
          <div class="col-md-2">
          </div>
            <div class="col-md-8">
                    <div class="box-header">
                        @if($data['section_id'] == 1)
                        <h3 class="box-title">Home Page Settings </h3>
                        @elseif($data['section_id'] == 2)
                        <h3 class="box-title">Cart Page Settings </h3>
                        @elseif($data['section_id'] == 3)
                        <h3 class="box-title">Blog Page Settings </h3>
                        @elseif($data['section_id'] == 4)
                        <h3 class="box-title">Detail Page Settings </h3>
                        @elseif($data['section_id'] == 5)
                        <h3 class="box-title">Shop Page Settings </h3>
                        @elseif($data['section_id'] == 6)
                        <h3 class="box-title">Contact Page Settings</h3>
                        @elseif($data['section_id'] == 8)
                        <h3 class="box-title">@lang('labels.Login Page Settings') </h3>
                        @elseif($data['section_id'] == 9)
                        <h3 class="box-title">@lang('labels.News Page Settings') </h3>
                        @elseif($data['section_id'] == 10)
                        <h3 class="box-title">@lang('labels.Banner Transition Settings') </h3>
                        @elseif($data['section_id'] == 11)
                        <h3 class="box-title">@lang('labels.Product Card Style') </h3>
                        @elseif($data['section_id'] == 12)
                        <h3 class="box-title">@lang('labels.Categorywidget') </h3>
                        @elseif($data['section_id'] == 13)
                        <h3 class="box-title">@lang('labels.Categories Section') </h3>
                        @else
                        <h3 class="box-title">Colors Settings</h3>
                        @endif
                    </div>

                    <!-- /.box-header -->
                    <div id="app">
                        <div class="row">
                            <div class="col-xs-12">
                                <div style="box-shadow: 2px 4px 21px lightgrey"class="box box-info">
                                    @if($data['section_id'] == 1)

                                    <?php  $dataa = json_encode(array('data' =>$data,'current_theme' => $current_theme)); 
                                    ?>
                                    
                                    <theme-component :data="{{$dataa}}"></theme-component>
                                    @endif
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
                                        {!! Form::open(array('url' =>'admin/theme/setting/setPages', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                        <input type="hidden" name="page" value="{{$data['section_id']}}" />

                                      @if($data['section_id'] == 2)
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.cart') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control field-validate" onchange="showCartImage();" id="cart_id" name="cart_id">
                                                      @foreach($data['cart'] as $cart)
                                                        <?php  if($cart['id'] == $current_theme->cart){ ?>
                                                          <option selected value="{{$cart['id']}}">{{$cart['name']}}</option>
                                                        <?php }else{ ?>
                                                          <option value="{{$cart['id']}}">{{$cart['name']}}</option>
                                                        <?php } ?>
                                                      @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.cart') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    <img id="cart_image1" style="display: none" width="350px;" src="{{asset('images/prototypes/cart1.png')}}" />
                                                    <img id="cart_image2"  style="display: none" width="350px;" src="{{asset('images/prototypes/cart2.png')}}" />

                                                </div>
                                            </div>

                                      @endif
                                      @if($data['section_id'] == 3)
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.news') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control field-validate" name="news_id">
                                                  @foreach($data['blog'] as $news)
                                                    <?php  if($news['id'] == $current_theme->news){ ?>
                                                      <option selected value="{{$news['id']}}">{{$news['name']}}</option>
                                                    <?php }else{ ?>
                                                      <option value="{{$news['id']}}">{{$news['name']}}</option>
                                                    <?php } ?>
                                                  @endforeach
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.news') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                      @endif
                                        @if($data['section_id'] == 4)
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.detail') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control field-validate" onchange="showDetailImage();" id="detail_id" name="detail_id">
                                                  @foreach($data['detail'] as $detail)
                                                    <?php  if($detail['id'] == $current_theme->detail){ ?>
                                                      <option selected value="{{$detail['id']}}">{{$detail['name']}}</option>
                                                    <?php }else{ ?>
                                                      <option value="{{$detail['id']}}">{{$detail['name']}}</option>
                                                    <?php } ?>
                                                  @endforeach
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.detail') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                <img id="detail_image1" style="display: none" width="350px;" src="{{asset('images/prototypes/detail1.png')}}" />
                                                <img id="detail_image2" style="display: none" width="350px;" src="{{asset('images/prototypes/detail2.png')}}" />
                                                <img id="detail_image3" style="display: none" width="350px;" src="{{asset('images/prototypes/detail3.png')}}" />
                                                <img id="detail_image4" style="display: none" width="350px;" src="{{asset('images/prototypes/detail4.png')}}" />
                                                <img id="detail_image5" style="display: none" width="350px;" src="{{asset('images/prototypes/detail5.png')}}" />
                                                <img id="detail_image6" style="display: none" width="350px;" src="{{asset('images/prototypes/detail6.png')}}" />

                                            </div>
                                        </div>
                                        @endif
                                        @if($data['section_id'] == 5)
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.shop') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control field-validate" onchange="showShopImage();" id="shop_id" name="shop_id">
                                                  @foreach($data['shop'] as $shop)
                                                    <?php  if($shop['id'] == $current_theme->shop){ ?>
                                                      <option selected value="{{$shop['id']}}">{{$shop['name']}}</option>
                                                    <?php }else{ ?>
                                                      <option value="{{$shop['id']}}">{{$shop['name']}}</option>
                                                    <?php } ?>
                                                  @endforeach
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.shop') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                <img id="shop_image1" style="display: none" width="350px;" src="{{asset('images/prototypes/shop1.png')}}" />
                                                <img id="shop_image2" style="display: none" width="350px;" src="{{asset('images/prototypes/shop2.png')}}" />
                                                <img id="shop_image3" style="display: none" width="350px;" src="{{asset('images/prototypes/shop3.png')}}" />
                                                <img id="shop_image4" style="display: none" width="350px;" src="{{asset('images/prototypes/shop4.png')}}" />
                                                <img id="shop_image5" style="display: none" width="350px;" src="{{asset('images/prototypes/shop5.png')}}" />

                                            </div>
                                        </div>
                                        @endif
                                          @if($data['section_id'] == 6)
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.contact') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select  class="form-control field-validate"  onchange="showContactImage();" id="contact_id" name="contact_id">
                                                  @foreach($data['contact'] as $contact)
                                                    <?php  if($contact['id'] == $current_theme->contact){ ?>
                                                      <option selected value="{{$contact['id']}}">{{$contact['name']}}</option>
                                                    <?php }else{ ?>
                                                      <option value="{{$contact['id']}}">{{$contact['name']}}</option>
                                                    <?php } ?>
                                                  @endforeach
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.contact') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                <img id="contact_image1" style="display: none" width="350px;" src="{{asset('images/prototypes/contact1.png')}}" />
                                                <img id="contact_image2"  style="display: none" width="350px;" src="{{asset('images/prototypes/contact2.png')}}" />
                                            </div>
                                        </div>
                                        @endif
                                        @if($data['section_id'] == 7)
                                      <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">Colors</label>
                                          <div class="col-sm-10 col-md-4">
                                            <select name="web_color_style" class="form-control">
                                                <option @if($data['settings'][81]->value == 'app')
                                                        selected
                                                        @endif
                                                        value="app">Default</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.1')
                                                        selected
                                                        @endif
                                                        value="app.theme.1"> @lang('labels.app_theme_2')</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.2')
                                                        selected
                                                        @endif
                                                        value="app.theme.2"> @lang('labels.app_theme_3')</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.3')
                                                        selected
                                                        @endif
                                                        value="app.theme.3"> @lang('labels.app_theme_4')</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.4')
                                                        selected
                                                        @endif
                                                        value="app.theme.4"> @lang('labels.app_theme_5')</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.5')
                                                        selected
                                                        @endif
                                                        value="app.theme.5"> @lang('labels.app_theme_6')</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.6')
                                                        selected
                                                        @endif
                                                        value="app.theme.6"> @lang('labels.app_theme_7')</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.7')
                                                        selected
                                                        @endif
                                                        value="app.theme.7"> @lang('labels.app_theme_8')</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.8')
                                                        selected
                                                        @endif
                                                        value="app.theme.8"> @lang('labels.app_theme_9')</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.9')
                                                        selected
                                                        @endif
                                                        value="app.theme.9"> Orange</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.10')
                                                        selected
                                                        @endif
                                                        value="app.theme.10"> Cameo</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.11')
                                                        selected
                                                        @endif
                                                        value="app.theme.11"> Americano</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.12')
                                                        selected
                                                        @endif
                                                        value="app.theme.12"> Cranberry</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.13')
                                                        selected
                                                        @endif
                                                        value="app.theme.13"> Pale Sky</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.14')
                                                        selected
                                                        @endif
                                                        value="app.theme.14"> Sheen Green</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.15')
                                                        selected
                                                        @endif
                                                        value="app.theme.15"> Cyan / Aqua</option>
                                                        
                                                <option @if($data['settings'][81]->value == 'app.theme.16')
                                                        selected
                                                        @endif
                                                        value="app.theme.16"> Crete</option>
                                                <option @if($data['settings'][81]->value == 'app.theme.17')
                                                        selected
                                                        @endif
                                                        value="app.theme.17"> Downy </option>
                                                <option @if($data['settings'][81]->value == 'app.theme.18')
                                                        selected
                                                        @endif
                                                        value="app.theme.18"> Tonys Pink </option>
                                                <option @if($data['settings'][81]->value == 'app.theme.19')
                                                        selected
                                                        @endif
                                                        value="app.theme.19"> Black </option>
                                                        
                                                        
                                            </select> 
                                          </div>
                                      </div>
                                      @endif

                                      @if($data['section_id'] == 8)
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Login') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select  class="form-control field-validate"  onchange="showLoginImage();" id="login_id" name="login_id">
                                                  @foreach($data['login'] as $login)
                                                    <?php  if($login['id'] == $current_theme->login){ ?>
                                                      <option selected value="{{$login['id']}}">{{$login['name']}}</option>
                                                    <?php }else{ ?>
                                                      <option value="{{$login['id']}}">{{$login['name']}}</option>
                                                    <?php } ?>
                                                  @endforeach
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.login') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                <img id="login_image1" style="display: none" width="350px;" src="{{asset('images/prototypes/login1.png')}}" />
                                                <img id="login_image2"  style="display: none" width="350px;" src="{{asset('images/prototypes/login2.png')}}" />
                                            </div>
                                        </div>
                                        @endif

                                        @if($data['section_id'] == 9)
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.News') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select  class="form-control field-validate"  onchange="showNewsImage();" id="news_id" name="news_id">
                                                  @foreach($data['news'] as $news)
                                                    <?php  if($news['id'] == $current_theme->news){ ?>
                                                      <option selected value="{{$news['id']}}">{{$news['name']}}</option>
                                                    <?php }else{ ?>
                                                      <option value="{{$news['id']}}">{{$news['name']}}</option>
                                                    <?php } ?>
                                                  @endforeach
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.News') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                <img id="news_image1" style="display: none" width="350px;" src="{{asset('images/prototypes/news1.png')}}" />
                                                <img id="news_image2"  style="display: none" width="350px;" src="{{asset('images/prototypes/news2.png')}}" />
                                            </div>
                                        </div>
                                        @endif

                                        @if($data['section_id'] == 10)
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Transition') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select  class="form-control field-validate"  onchange="showTransitionImage();" id="transitions_id" name="transitions_id">
                                                  @foreach($data['transitions'] as $transition)
                                                    <?php  if($transition['id'] == $current_theme->transitions){ ?>
                                                      <option selected value="{{$transition['id']}}">{{$transition['name']}}</option>
                                                    <?php }else{ ?>
                                                      <option value="{{$transition['id']}}">{{$transition['name']}}</option>
                                                    <?php } ?>
                                                  @endforeach
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Transition') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                <img id="transition_image1" style="display: none" width="350px;" src="{{asset('images/prototypes/transition1.png')}}" />
                                                <img id="transition_image2"  style="display: none" width="350px;" src="{{asset('images/prototypes/transition2.png')}}" />
                                                <img id="transition_image1" style="display: none" width="350px;" src="{{asset('images/prototypes/transition3.png')}}" />
                                                <img id="transition_image2"  style="display: none" width="350px;" src="{{asset('images/prototypes/transition4.png')}}" />
                                                <img id="transition_image1" style="display: none" width="350px;" src="{{asset('images/prototypes/transition5.png')}}" />
                                            </div>
                                        </div>
                                        @endif                                      
                                        @if($data['section_id'] == 11)
                                      <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">@lang('labels.Product Card Style')</label>
                                          <div class="col-sm-10 col-md-4">
                                            <select name="web_card_style" class="form-control">
                                              <option @if($data['settings'][129]->value == '1')
                                                selected
                                                @endif
                                                value="1"> @lang('labels.Style1')</option>    
                                                <option @if($data['settings'][129]->value == '2')
                                                    selected
                                                    @endif
                                                    value="2"> @lang('labels.Style2')</option>    
                                                <option @if($data['settings'][129]->value == '3')
                                                    selected
                                                    @endif
                                                    value="3"> @lang('labels.Style3')</option>   
                                                <option @if($data['settings'][129]->value == '4')
                                                    selected
                                                    @endif
                                                    value="4"> @lang('labels.Style4')</option>  
                                                <option @if($data['settings'][129]->value == '5')
                                                    selected
                                                    @endif
                                                    value="5"> @lang('labels.Style5')</option>   
                                                    
                                                <option @if($data['settings'][129]->value == '6')
                                                    selected
                                                    @endif
                                                    value="6"> @lang('labels.Style6')</option>   
                                                    
                                                <option @if($data['settings'][129]->value == '7')
                                                selected
                                                @endif
                                                value="7"> @lang('labels.Style7')</option>    
                                                
                                                <option @if($data['settings'][129]->value == '8')
                                                selected
                                                @endif
                                                value="8"> @lang('labels.Style8')</option>     
                                                
                                                <option @if($data['settings'][129]->value == '9')
                                                selected
                                                @endif
                                                value="9"> @lang('labels.Style9')</option>               
                                                
                                                <option @if($data['settings'][129]->value == '10')
                                                selected
                                                @endif
                                                value="10"> @lang('labels.Style10')</option>   
                                                <option @if($data['settings'][129]->value == '11')
                                                selected
                                                @endif
                                                value="11"> @lang('labels.Style11')</option> 
                                                <option @if($data['settings'][129]->value == '12')
                                                selected
                                                @endif
                                                value="12"> @lang('labels.Style12')</option>
                                                <option @if($data['settings'][129]->value == '13')
                                                selected
                                                @endif
                                                value="13"> @lang('labels.Style13')</option>
                                                <option @if($data['settings'][129]->value == '14')
                                                selected
                                                @endif
                                                value="14"> @lang('labels.Style14')</option>
                                                <option @if($data['settings'][129]->value == '15')
                                                selected
                                                @endif
                                                value="15"> @lang('labels.Style15')</option>

                                                <!-- quantity cards -->
                                                <option @if($data['settings'][129]->value == '16')
                                                selected
                                                @endif
                                                value="16"> @lang('labels.Style16')</option>
                                                <option @if($data['settings'][129]->value == '17')
                                                selected
                                                @endif
                                                value="17"> @lang('labels.Style17')</option>
                                                
                                                <option @if($data['settings'][129]->value == '18')
                                                selected
                                                @endif
                                                value="18"> @lang('labels.Style18')</option>
                                                
                                                <!-- <option @if($data['settings'][129]->value == '19')
                                                selected
                                                @endif
                                                value="19"> @lang('labels.Style19')</option>
                                                
                                                
                                                <option @if($data['settings'][129]->value == '20')
                                                selected
                                                @endif
                                                value="20"> @lang('labels.Style20')</option>
                                                
                                                
                                                <option @if($data['settings'][129]->value == '21')
                                                selected
                                                @endif
                                                value="21"> @lang('labels.Style21')</option>   -->
                                                        
                                                        
                                            </select> 
                                          </div>
                                      </div>
                                      @endif   

                                      @if($data['section_id'] == 12)
                                      <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">@lang('labels.Categories Icons / Image')</label>
                                          <div class="col-sm-10 col-md-4">
                                            <select name="home_categories_img_icn" class="form-control">
                                              <option @if($result['commonContent']['setting']['home_categories_img_icn'] == 'Image')
                                                selected
                                                @endif
                                                value="Image"> @lang('labels.Image')</option> 
                                              <option @if($result['commonContent']['setting']['home_categories_img_icn'] == 'Icon')
                                                selected
                                                @endif
                                                value="Icon"> @lang('labels.Icon')</option>  
                                            </select> 
                                          </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="name" class="col-sm-2 col-md-3 control-label">@lang('labels.Number Of Records')</label>
                                        <div class="col-sm-10 col-md-4">
                                        <input type="number" class="form-control" name="home_categories_records" value="{{$result['commonContent']['setting']['home_categories_records']}}"> 
                                        </div>
                                      </div>                                     
                                      
                                      @endif  
                                      @if($data['section_id'] == 13)
                                      @php
                                      $cat_array = explode(',',$result['commonContent']['setting']['home_category']);                                   
                                      @endphp
                                      
                                      <div class="field_wrapper">
                                        
                                        @foreach ($cat_array as $key=>$item)
                                        <div class="form-group ">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">@lang('labels.ChooseCategory')</label>
                                          <div class="col-sm-10 col-md-4 content-remove">
                                            <select name="home_category[]" class="form-control">
                                              <option value=""> @lang('labels.ChooseCategory')</option> 
                                                @if(!empty($categories) and count($categories)>0)
                                                  @foreach($categories as $category)
                                                  <option 
                                                  value="{{$category->id}}"  @if($category->id == $item))  selected @endif> {{$category->name}}</option>  
                                                  @endforeach
                                                @endif
                                            </select>
                                          </div>
                                          <div class="col-sm-2">  
                                            @if($key == 0)                                        
                                            <a href="javascript:void(0);" class="btn btn-default add_button" title="Add field"><i class="fa fa-plus"></i></a>
                                            @else
                                            <a href="javascript:void(0);" class="btn btn-danger remove_button" title="Add field"><i class="fa fa-remove"></i></a>
                                            @endif
                                          </div>

                                          </div>
                                       
                                          
                                        @endforeach

                                        
                                        </div>

                                      {{-- <div class="field_wrapper">
                                            <div>
                                                  <input type="text" name="field_name[]" value=""/>
                                                  <a href="javascript:void(0);" class="add_button" title="Add field"><img src="add-icon.png"/></a>
                                              </div>
                                          </div> --}}
                                      @endif 
                                        
                                        <!-- /.box-body -->
                                        @if($data['section_id'] != 1)
                                        <div class=" text-center">
                                            <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }} </button>
                                        </div>
                                        @endif
                                        @if($data['section_id'] == 1)
                                        <div class=" text-center">
                                            <a href="{{url('/')}}" class="btn btn-default">Back </a>
                                        </div>
                                        @endif
                                        <!-- /.box-footer -->
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->

        <!-- /.row -->
    </section>
</div>
<script src="{{asset('web/js/app.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function(){
      var maxField = 10; //Input fields increment limitation
      var addButton = $('.add_button'); //Add button selector
      var wrapper = $('.field_wrapper'); //Input field wrapper
     // var fieldHTML = '<div><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="remove-icon.png"/></a></div>'; //New input field html 
     var fieldHTML = '<div class="form-group"><label for="name" class="col-sm-2 col-md-3 control-label">@lang("labels.ChooseCategory")</label><div class="col-sm-10 col-md-4"><select name="home_category[]" class="form-control"><option value=""> @lang("labels.ChooseCategory")</option> @if(!empty($categories) and count($categories)>0) @foreach($categories as $category) <option value="{{$category->id}}"> {{$category->name}}</option>  @endforeach @endif </select> </div> <div class="col-sm-2">   <a href="javascript:void(0);" class="btn btn-danger remove_button" title="Add field"><i class="fa fa-remove"></i></a></div> </div>'
      var x = 1; //Initial field counter is 1
      
      //Once add button is clicked
      $(addButton).click(function(){
          //Check maximum number of input fields
          if(x < maxField){ 
              x++; //Increment field counter
              $(wrapper).append(fieldHTML); //Add field html
          }
      });
      
      //Once remove button is clicked
      $(wrapper).on('click', '.remove_button', function(e){
          e.preventDefault();
          $(this).parents('.form-group').remove(); //Remove field html
          x--; //Decrement field counter
      });
  });
</script>

@endsection
