@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.application_settings') }} <small>{{ trans('labels.application_settings') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.application_settings') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.application_settings') }} </h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">
                                            @if( count($errors) > 0)
                                                @foreach($errors->all() as $error)
                                                    <div class="alert alert-success" role="alert">
                                                        <span class="icon fa fa-check" aria-hidden="true"></span>
                                                        <span class="sr-only">{{ trans('labels.Setting') }}:</span>
                                                        {{ $error }}
                                                    </div>
                                                @endforeach
                                            @endif

                                            {!! Form::open(array('url' =>'admin/updateSetting', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                                            <h4>{{ trans('labels.generalSetting') }} </h4>
                                            <hr>

                                            

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.homeStyle') }}

                                                </label>
                                                
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="home_style" class="form-control">
                                                    
                                                    
                                                        <option @if($result['commonContent']['setting']['home_style'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Style1') }}</option>
                                                        <option @if($result['commonContent']['setting']['home_style'] == '2')
                                                                selected
                                                                @endif
                                                                value="2"> {{ trans('labels.Style2') }}</option>
                                                        <option @if($result['commonContent']['setting']['home_style'] == '3')
                                                                selected
                                                                @endif
                                                                value="3"> {{ trans('labels.Style3') }}</option>
                                                        <option @if($result['commonContent']['setting']['home_style'] == '4')
                                                                selected
                                                                @endif
                                                                value="4"> {{ trans('labels.Style4') }}</option>
                                                        <option @if($result['commonContent']['setting']['home_style'] == '5')
                                                                selected
                                                                @endif
                                                                value="5"> {{ trans('labels.Style5') }}</option>
                                                        <option @if($result['commonContent']['setting']['home_style'] == '6')
                                                                selected
                                                                @endif
                                                                value="6"> {{ trans('labels.Style6') }}</option>
                                                        <option @if($result['commonContent']['setting']['home_style'] == '7')
                                                                selected
                                                                @endif
                                                                value="7"> {{ trans('labels.Style 7') }}</option>
                                                        <option @if($result['commonContent']['setting']['home_style'] == '8')
                                                                selected
                                                                @endif
                                                                value="8"> {{ trans('labels.Style 8') }}</option>
                                                        <option @if($result['commonContent']['setting']['home_style'] == '9')
                                                                selected
                                                                @endif
                                                                value="9"> {{ trans('labels.Style 9') }}</option>
                                                        <option @if($result['commonContent']['setting']['home_style'] == '10')
                                                                selected
                                                                @endif
                                                                value="10"> {{ trans('labels.Style 10') }}</option>


                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.homeStyleText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Card Style') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="card_style" id="card_style" class="form-control">
                                                  
                                                        <option @if($result['commonContent']['setting']['card_style'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Style1') }}</option>
                                                        <option @if($result['commonContent']['setting']['card_style'] == '2')
                                                                selected
                                                                @endif
                                                                value="2"> {{ trans('labels.Style2') }}</option>
                                                        <option @if($result['commonContent']['setting']['card_style'] == '3')
                                                                selected
                                                                @endif
                                                                value="3"> {{ trans('labels.Style3') }}</option>
                                                        <option @if($result['commonContent']['setting']['card_style'] == '4')
                                                                selected
                                                                @endif
                                                                value="4"> {{ trans('labels.Style4') }}</option>
                                                        <option @if($result['commonContent']['setting']['card_style'] == '5')
                                                                selected
                                                                @endif
                                                                value="5"> {{ trans('labels.Style5') }}</option>
                                                        <option @if($result['commonContent']['setting']['card_style'] == '6')
                                                                selected
                                                                @endif
                                                                value="6"> {{ trans('labels.Style6') }}</option>
                                                        <option @if($result['commonContent']['setting']['card_style'] == '7')
                                                                selected
                                                                @endif
                                                                value="7"> {{ trans('labels.Style 7') }}</option>
                                                        <option @if($result['commonContent']['setting']['card_style'] == '8')
                                                                selected
                                                                @endif
                                                                value="8"> {{ trans('labels.Style 8') }}</option>
                                                        <option @if($result['commonContent']['setting']['card_style'] == '9')
                                                                selected
                                                                @endif
                                                                value="9"> {{ trans('labels.Style 9') }}</option>
                                                        <option @if($result['commonContent']['setting']['card_style'] == '10')
                                                                selected
                                                                @endif
                                                                value="10"> {{ trans('labels.Style 10') }}</option>

                                                        <option @if($result['commonContent']['setting']['card_style'] == '11')
                                                                selected
                                                                @endif
                                                                value="11"> {{ trans('labels.Style 11') }}</option>

                                                        <option @if($result['commonContent']['setting']['card_style'] == '12')
                                                                selected
                                                                @endif
                                                                value="12"> {{ trans('labels.Style 12') }}</option>

                                                        <option @if($result['commonContent']['setting']['card_style'] == '13')
                                                                selected
                                                                @endif
                                                                value="13"> {{ trans('labels.Style 13') }}</option>

                                                        <option @if($result['commonContent']['setting']['card_style'] == '14')
                                                                selected
                                                                @endif
                                                                value="14"> {{ trans('labels.Style 14') }}</option>

                                                        <option @if($result['commonContent']['setting']['card_style'] == '15')
                                                                selected
                                                                @endif
                                                                value="15"> {{ trans('labels.Style 15') }}</option>

                                                        <option @if($result['commonContent']['setting']['card_style'] == '16')
                                                                selected
                                                                @endif
                                                                value="16"> {{ trans('labels.Style 16') }}</option>

                                                        <option @if($result['commonContent']['setting']['card_style'] == '17')
                                                                selected
                                                                @endif
                                                                value="17"> {{ trans('labels.Style 17') }}</option>

                                                        <option @if($result['commonContent']['setting']['card_style'] == '18')
                                                                selected
                                                                @endif
                                                                value="18"> {{ trans('labels.Style 18') }}</option>

                                                        <option @if($result['commonContent']['setting']['card_style'] == '19')
                                                                selected
                                                                @endif
                                                                value="19"> {{ trans('labels.Style 19') }}</option>

                                                        <option @if($result['commonContent']['setting']['card_style'] == '20')
                                                                selected
                                                                @endif
                                                                value="20"> {{ trans('labels.Style 20') }}</option>

                                                        <option @if($result['commonContent']['setting']['card_style'] == '21')
                                                                selected
                                                                @endif
                                                                value="21"> {{ trans('labels.Style 21') }}</option>

                                                        <option @if($result['commonContent']['setting']['card_style'] == '22')
                                                                selected
                                                                @endif
                                                                value="22"> {{ trans('labels.Style 22') }}</option>
                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.Please choose card style') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Banner Style') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                
                                                    <select name="banner_style" class="form-control">
                                                        <option @if($result['commonContent']['setting']['banner_style'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Style1') }}</option>
                                                        <option @if($result['commonContent']['setting']['banner_style'] == '2')
                                                                selected
                                                                @endif
                                                                value="2"> {{ trans('labels.Style2') }}</option>
                                                        <option @if($result['commonContent']['setting']['banner_style'] == '3')
                                                                selected
                                                                @endif
                                                                value="3"> {{ trans('labels.Style3') }}</option>
                                                        <option @if($result['commonContent']['setting']['banner_style'] == '4')
                                                                selected
                                                                @endif
                                                                value="4"> {{ trans('labels.Style4') }}</option>
                                                        <option @if($result['commonContent']['setting']['banner_style'] == '5')
                                                                selected
                                                                @endif
                                                                value="5"> {{ trans('labels.Style5') }}</option>
                                                        <option @if($result['commonContent']['setting']['banner_style'] == '6')
                                                                selected
                                                                @endif
                                                                value="6"> {{ trans('labels.Style6') }}</option>
                                                       
                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.Please choose banner style') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.categoryStyle') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                
                                                
                                                    <select name="category_style" class="form-control">
                                                        <option @if($result['commonContent']['setting']['category_style']  == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.categories1') }}</option>
                                                        <option @if($result['commonContent']['setting']['category_style']  == '2')
                                                                selected
                                                                @endif
                                                                value="2"> {{ trans('labels.categories2') }}</option>
                                                        <option @if($result['commonContent']['setting']['category_style']  == '3')
                                                                selected
                                                                @endif
                                                                value="3"> {{ trans('labels.categories3') }}</option>
                                                        <option @if($result['commonContent']['setting']['category_style']  == '4')
                                                                selected
                                                                @endif
                                                                value="4"> {{ trans('labels.categories4') }}</option>
                                                        <option @if($result['commonContent']['setting']['category_style']  == '5')
                                                                selected
                                                                @endif
                                                                value="5"> {{ trans('labels.categories5') }}</option>
                                                        <option @if($result['commonContent']['setting']['category_style']  == '6')
                                                                selected
                                                                @endif
                                                                value="6"> {{ trans('labels.categories6') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.categoryStyleText') }}</span>
                                                </div>
                                            </div>
                                        
                                            
                                            <div class="form-group android-hide"id="cart1style" @if($result['commonContent']['setting']['card_style'] != '1')
                                                style="display: none"
                                                @endif>
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.DisplayCartButton') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                               
                                                
                                                    <select name="cart_button" class="form-control">
                                                    
                                                        <option @if($result['commonContent']['setting']['cart_button'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Show') }}</option>
                                                        <option @if($result['commonContent']['setting']['cart_button'] == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.Hide') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.DisplayCartButtonText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group android-hide">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.packageName') }}

                                                </label>
                                                
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('share_app_url',  $result['commonContent']['setting']['share_app_url'], array('class'=>'form-control', 'id'=>'share_app_url')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.packageNameText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group android-hide"  style="display: none">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.googleAnalyticId') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                

                                                
                                                    {!! Form::text('google_analytic_id',  $result['commonContent']['setting']['google_analytic_id'], array('class'=>'form-control', 'id'=>'google_analytic_id')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.googleAnalyticIdText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group android-hide" style="display: none">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.LazzyLoadingEffect') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                               
                                                    <select name="lazzy_loading_effect" class="form-control">
                                                   
                                                        <option
                                                                @if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'android')
                                                                selected
                                                                @endif
                                                                value="android"> {{ trans('labels.Android') }}</option>
                                                        <option
                                                                @if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'ios-small')
                                                                selected
                                                                @endif
                                                                value="ios-small"> {{ trans('labels.IOSSmall') }}</option>
                                                        <option
                                                                @if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'bubbles')
                                                                selected
                                                                @endif
                                                                value="bubbles"> {{ trans('labels.Bubbles') }}</option>
                                                        <option
                                                                @if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'circles')
                                                                selected
                                                                @endif
                                                                value="circles"> {{ trans('labels.Circles') }}</option>
                                                        <option
                                                                @if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'crescent')
                                                                selected
                                                                @endif
                                                                value="crescent"> {{ trans('labels.Crescent') }}</option>
                                                        <option
                                                                @if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'dots')
                                                                selected
                                                                @endif
                                                                value="dots"> {{ trans('labels.Dots') }}</option>
                                                        <option
                                                                @if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'lines')
                                                                selected
                                                                @endif
                                                                value="lines"> {{ trans('labels.Lines') }}</option>
                                                        <option
                                                                @if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'ripple')
                                                                selected
                                                                @endif
                                                                value="ripple"> {{ trans('labels.Ripple') }}</option>
                                                        <option
                                                                @if( $result['commonContent']['setting']['lazzy_loading_effect'] == 'spiral')
                                                                selected
                                                                @endif
                                                                value="spiral"> {{ trans('labels.Spiral') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.LazzyLoadingEffectText') }}</span>
                                                </div>
                                            </div>

                                            <hr>
                                            <h4>{{ trans('labels.displayPages') }} </h4>
                                            <hr>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.wishListPage') }}

                                                </label>
                                                
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="wish_list_page" class="form-control">
                                                        <option @if($result['commonContent']['setting']['wish_list_page'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Show') }}</option>
                                                        <option @if($result['commonContent']['setting']['wish_list_page'] == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.Hide') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.wishListPageText') }}</span>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.editProfilePage') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="edit_profile_page" class="form-control">
                                                        <option @if($result['commonContent']['setting']['edit_profile_page']  == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Show') }}</option>
                                                        <option @if($result['commonContent']['setting']['edit_profile_page']  == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.Hide') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.editProfilePageText') }}</span>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.shippingAddressPage') }}

                                                </label>
                                               
                                                <div class="col-sm-10 col-md-4">
                                                
                                                    <select name="shipping_address_page" class="form-control">
                                                        <option @if($result['commonContent']['setting']['shipping_address_page'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Show') }}</option>
                                                        <option @if($result['commonContent']['setting']['shipping_address_page'] == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.Hide') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.shippingAddressPageText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.myOrdersPage') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="my_orders_page" class="form-control">
                                                    
                                                        <option @if($result['commonContent']['setting']['my_orders_page']  == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Show') }}</option>
                                                        <option @if($result['commonContent']['setting']['my_orders_page']  == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.Hide') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.myOrdersPageText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.contactUsPage') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="contact_us_page" class="form-control">
                                                        <option @if($result['commonContent']['setting']['contact_us_page'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Show') }}</option>
                                                        <option @if($result['commonContent']['setting']['contact_us_page'] == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.Hide') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.contactUsPageText') }}</span>
                                                </div>
                                            </div>

                                            

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.aboutUsPage') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="about_us_page" class="form-control">
                                                        <option @if($result['commonContent']['setting']['about_us_page']  == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Show') }}</option>
                                                        <option @if($result['commonContent']['setting']['about_us_page']  == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.Hide') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.aboutUsPageText') }}</span>
                                                </div>
                                            </div>
                                            

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.newsPage') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="news_page" class="form-control">
                                                        <option @if($result['commonContent']['setting']['news_page'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Show') }}</option>
                                                        <option @if($result['commonContent']['setting']['news_page'] == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.Hide') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.newsPageText') }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.introPage') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="intro_page" class="form-control">
                                                        <option @if($result['commonContent']['setting']['intro_page'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Show') }}</option>
                                                        <option @if($result['commonContent']['setting']['intro_page'] == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.Hide') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.introPageText') }}</span>
                                                </div>
                                            </div>
                                            

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.shareapp') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="share_app" class="form-control">
                                                        <option @if($result['commonContent']['setting']['share_app'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Show') }}</option>
                                                        <option @if($result['commonContent']['setting']['share_app'] == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.Hide') }}</option>

                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.shareappText') }}</span>
                                                </div>
                                            </div>
                                            

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.rateapp') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="rate_app" class="form-control">
                                                        <option @if($result['commonContent']['setting']['rate_app'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Show') }}</option>
                                                        <option @if($result['commonContent']['setting']['rate_app'] == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.Hide') }}</option>

                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.rateappText') }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.settingPage') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="setting_page" class="form-control">
                                                        <option @if($result['commonContent']['setting']['setting_page'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Show') }}</option>
                                                        <option @if($result['commonContent']['setting']['setting_page'] == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.Hide') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.settingPageText') }}</span>
                                                </div>
                                            </div>
                                            
                                            <hr>
                                            <h4>{{ trans('labels.LocalNotification') }} </h4>
                                            <hr>


                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Title') }}

                                                </label>
                                                
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('notification_title', $result['commonContent']['setting']['notification_title'], array('class'=>'form-control', 'id'=>'notification_title')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.NotificationTitleText') }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Detail') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('notification_text', $result['commonContent']['setting']['notification_text'], array('class'=>'form-control', 'id'=>'notification_text')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.NotificationDetailtext') }}</span>
                                                </div>
                                            </div>
                                           
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.NotificationDuration') }}</label>
                                                <div class="col-sm-10 col-md-4">

                                                    <select class="form-control" name="notification_duration">
                                                        <option value="day" @if($result['commonContent']['setting']['notification_duration']=='day') selected @endif>{{ trans('labels.Day') }}</option>
                                                        <option value="month" @if($result['commonContent']['setting']['notification_duration']=='month') selected @endif>{{ trans('labels.Month') }}</option>
                                                        <option value="year" @if($result['commonContent']['setting']['notification_duration']=='year') selected @endif>{{ trans('labels.Year') }}</option>
                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.NotificationDurationText') }}</span>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }} </button>
                                            <a href="{{ URL::to('admin/dashboard/this_month')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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

    <!-- /.row -->

    <!-- Main row -->

    <!-- /.row -->
    </section>
    <!-- /.content -->
    </div>
@endsection
