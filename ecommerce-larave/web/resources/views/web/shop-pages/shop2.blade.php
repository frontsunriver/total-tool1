  <!-- Shop Page One content -->
  <div class="container-fuild">
    <nav aria-label="breadcrumb">
        <div class="container">
        <ol class="breadcrumb">
              @if(!empty($result['category_name']) and !empty($result['sub_category_name']))
              <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
              <li  class="breadcrumb-item"><a href="{{ URL::to('/shop')}}">@lang('website.Shop')</a></li>
             <li  class="breadcrumb-item"><a href="{{ URL::to('/shop?category='.$result['category_slug'])}}">{{$result['category_name']}}</a></li>
             <li  class="breadcrumb-item active">{{$result['sub_category_name']}}</li>
             @elseif(!empty($result['category_name']) and empty($result['sub_category_name']))
             <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
             <li  class="breadcrumb-item active"><a href="{{ URL::to('/shop')}}">@lang('website.Shop')</a></li>

             <li class="breadcrumb-item active">{{$result['category_name']}}</li>
             @else
             <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
             <li class="breadcrumb-item active">@lang('website.Shop')</li>
             @endif
            </ol>
        </div>
      </nav>
  </div> 
  
   
      
    <section class="pro-content">
          <div class="container">
              <div class="page-heading-title">
                  <h2> @lang('website.Shop')  
                  </h2>
              
                  </div>
          </div>
          
          <section class="shop-content shop-two">
                  
            <div class="container">
                <div class="row">
                  
                  <div class="col-12 col-lg-9">
                    @if($result['products']['success']==1)
                      <div class="products-area">
                        <div class="top-bar">
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-lg-6">
                                          <div class="block">
                                              <label>@lang('website.Display')</label>
                                              <div class="buttons">
                                                <a href="javascript:void(0);" id="grid"><i class="fas fa-th-large"></i></a>
                                                <a href="javascript:void(0);" id="list"><i class="fas fa-list"></i></a>
                                                </div>
                                          </div>
                                        </div> 
                                        <div class="col-12 col-lg-6">
                                          
  
                                          <form class="form-inline justify-content-end" id="load_products_form">
                                            @if(!empty(app('request')->input('search')))
                                             <input type="hidden"  name="search" value="{{ app('request')->input('search') }}">
                                            @endif
                                            @if(!empty(app('request')->input('category')))
                                             <input type="hidden"  name="category" value="@if(app('request')->input('category')!='all'){{ app('request')->input('category') }} @endif">
                                            @endif
                                             <input type="hidden"  name="load_products" value="1">
                                             <input type="hidden"  name="products_style" id="products_style" value="grid">
               
                                            
                                            <div class="form-group">
                                                <label>@lang('website.Sort')</label>
                                                <div class="select-control">
                                                <select name="type" id="sortbytype" class="form-control">
                                                  <option value="desc" @if(app('request')->input('type')=='desc') selected @endif>@lang('website.Newest')</option>
                                                  <option value="atoz" @if(app('request')->input('type')=='atoz') selected @endif>@lang('website.A - Z')</option>
                                                  <option value="ztoa" @if(app('request')->input('type')=='ztoa') selected @endif>@lang('website.Z - A')</option>
                                                  <option value="hightolow" @if(app('request')->input('type')=='hightolow') selected @endif>@lang('website.Price: High To Low')</option>
                                                  <option value="lowtohigh" @if(app('request')->input('type')=='lowtohigh') selected @endif>@lang('website.Price: Low To High')</option>
                                                  <option value="topseller" @if(app('request')->input('type')=='topseller') selected @endif>@lang('website.Top Seller')</option>
                                                  <option value="special" @if(app('request')->input('type')=='special') selected @endif>@lang('website.Special Products')</option>
                                                  <option value="mostliked" @if(app('request')->input('type')=='mostliked') selected @endif>@lang('website.Most Liked')</option>
                                                  </select>
                                                </div>
                                              </div>
  
               
                                              
                                              <div class="form-group">
                                                <label>@lang('website.Limit')</label>
                                                <div class="select-control">
                                                  <select class="form-control"name="limit"id="sortbylimit">
                                                    <option value="15" @if(app('request')->input('limit')=='15') selected @endif>15</option>
                                                    <option value="30" @if(app('request')->input('limit')=='30') selected @endif>30</option>
                                                    <option value="60" @if(app('request')->input('limit')=='60') selected @endif>60</option>
                                                    </select>
                                                  </div>
                                                </div>
                      
                                                 
                                              </div>
                                    </div>
                                  
                                </div>
                            </div>
                        </div> 
                        <section id="swap" class="shop-content" >
                              <div class="products-area">
                                  <div class="row">  
                                    @if($result['categories_status'] == 1)
                                      @foreach($result['products']['product_data'] as $key=>$products)   
                                      <?php 
                                        $is_status = false;
                                        if(!empty($products->categories)){
                                          foreach($products->categories as $key=>$category){
                                              if($category->categories_status == 1)
                                                $is_status = true;                                         
                                          } 
                                        }

                                        if($is_status == true){
                                        ?>
                                      <div class="col-12 col-lg-4 col-sm-6 griding">
                                        @include('web.common.product')
                                      </div>   
                                        <?php }?>                                
                                        
                                      @endforeach
                                      @else
                                    <div class="col-12 col-lg-4 col-sm-6 griding">
                                    <br>
                                    <h3>@lang('website.No Record Found!')</h3></div>
                                    @endif

                                    @include('web.common.scripts.addToCompare')
                                      
                                  </div>
                              </div> 
                        </section>  
                      </div>
                      @if($result['categories_status'] == 1)
  
                        <div class="pagination justify-content-between ">
                              <input id="record_limit" type="hidden" value="{{$result['limit']}}">
                              <input id="total_record" type="hidden" value="{{$result['products']['total_record']}}">
                              <label for="staticEmail" class="col-form-label"> @lang('website.Showing')&nbsp;<span class="showing_record">{{$result['limit']}}</span>&nbsp;@lang('website.of')&nbsp;<span class="showing_total_record">{{$result['products']['total_record']}}</span> &nbsp;@lang('website.results')</label>
                              
                            <div class=" justify-content-end col-6">
                                <input type="hidden" value="1" name="page_number" id="page_number">
                           <?php
                                    if(!empty(app('request')->input('limit'))){
                                        $record = app('request')->input('limit');
                                    }else{
                                        $record = '15';
                                    }
                                ?>
                                <button class="btn btn-dark" type="button" id="load_products"
                                @if(count($result['products']['product_data']) < $record )
                                    style="display:none"
                                @endif
                                >@lang('website.Load More')</button>
                            </div>
                    </div>
                    @endif
                    @else
                  <h3>@lang('website.No Record Found!')</h3>
                  @endif
  
                  </div>

                  <div class="col-12 col-lg-3  d-lg-block d-xl-block right-menu"> 
                    <div class="right-menu-categories">
                      @include('web.common.shopCategories')
                      @php    shopCategories(); @endphp 
                     </div>
            @if(!empty($result['categories']))
             <form enctype="multipart/form-data" name="filters" id="test" method="get">
               <input type="hidden" name="min_price" id="min_price" value="0">
               <input type="hidden" name="max_price" id="max_price" value="{{$result['filters']['maxPrice']}}">
              @if(isset($_GET['price']))
              <input type="hidden" name="price"  value="{{ $_GET['price'] }}">
              @endif
               @if(app('request')->input('category'))
                <input type="hidden" name="category" value="{{app('request')->input('category')}}">
               @endif
               @if(app('request')->input('filters_applied')==1)
               <input type="hidden" name="filters_applied" id="filters_applied" value="1">
               <input type="hidden" name="options" id="options" value="<?php echo implode(',',$result['filter_attribute']['options'])?>">
               <input type="hidden" name="options_value" id="options_value" value="<?php echo implode(',' , $result['filter_attribute']['option_values'])?>">
               @else
               <input type="hidden" name="filters_applied" id="filters_applied" value="0">
               @endif
               <div class="range-slider-main">
                 <h2>@lang('website.Price Range')</h2>
                 <div class="wrapper">
                     <div class="range-slider">
                         <input onChange="getComboA(this)" name="price" type="text" class="js-range-slider" value="" />
                     </div>
                     <div class="extra-controls form-inline">
                       <div class="form-group">
                           <span>
                             @if(session('symbol_left') != null)
                             <font>{{session('symbol_left')}}</font>
                             @else
                             <font>{{session('symbol_right')}}</font>
                             @endif
                                 <input type="text"  class="js-input-from form-control" value="0" />
                           </span>
                               <font>-</font>
                               <span>
                                 @if(session('symbol_left') != null)
                                 <font>{{session('symbol_left')}}</font>
                                 @else
                                 <font>{{session('symbol_right')}}</font>
                                 @endif
                                   <input  type="text" class="js-input-to form-control" value="0" />
                                   <input  type="hidden" class="maximum_price" value="{{$result['filters']['maxPrice']}}">
                                   </span>
                     </div>
                       </div>
                 </div>
               </div>
               @include('web.common.scripts.slider')
                     @if(count($result['filters']['attr_data'])>0)
                     @foreach($result['filters']['attr_data'] as $key=>$attr_data)
                     <div class="color-range-main">
                       <h1 @if(count($result['filters']['attr_data'])==$key+1) last @endif>{{$attr_data['option']['name']}}</h1>
                         <div class="block">
                                <div class="card-body">
                                 <ul class="list" style="list-style:none; padding: 0px;">
                                     @foreach($attr_data['values'] as $key=>$values)
                                     <li >
                                         <div class="form-check">
                                           <label class="form-check-label">
                                             <input class="form-check-input filters_box" name="{{$attr_data['option']['name']}}[]" type="checkbox" value="{{$values['value']}}" 								 									<?php
                                             if(!empty($result['filter_attribute']['option_values']) and in_array($values['value_id'],$result['filter_attribute']['option_values'])) print 'checked';
                                             ?>>
                                             {{$values['value']}}
                                           </label>
                                         </div>
                                     </li>
                                     @endforeach
                                 </ul>
                             </div>
                         </div>
  
                       </div>
                     @endforeach
                     @endif
                     <div class="color-range-main">
  
                     <div class="alret alert-danger" id="filter_required">
                     </div>
  
                     <div class="button">
                     <?php
                 $url = '';
                       if(isset($_REQUEST['category'])){
                   $url = "?category=".$_REQUEST['category'];
                   $sign = '&';
                 }else{
                   $sign = '?';
                 }
                 if(isset($_REQUEST['search'])){
                   $url.= $sign."search=".$_REQUEST['search'];
                 }
               ?>
                   <a href="{{ URL::to('/shop')}}" class="btn btn-dark" id="apply_options"> @lang('website.Reset') </a>
                      @if(app('request')->input('filters_applied')==1)
                   <button type="button" class="btn btn-secondary" id="apply_options_btn"> @lang('website.Apply')</button>
                     @else
                   <!--<button type="button" class="btn btn-secondary" id="apply_options_btn" disabled> @lang('website.Apply')</button>-->
                     <button type="button" class="btn btn-secondary" id="apply_options_btn" > @lang('website.Apply')</button>
                     @endif
                 </div>
               </div>
                     @if(count($result['commonContent']['homeBanners'])>0)
                      @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                         @if($homeBanners->type==7)
                         <div class="img-main">
                             <a href="{{ $homeBanners->banners_url}}" ><img class="img-fluid" src="{{asset('').$homeBanners->path}}"></a>
                         </div>
                       @endif
                      @endforeach
                     @endif
               </form>
               @endif
                    
  
              @if(!empty($result['commonContent']['manufacturers']) and count($result['commonContent']['manufacturers'])>0)
              <div class="range-slider-main">
                  <a class=" main-manu" data-toggle="collapse" href="#brands" role="button" aria-expanded="true" aria-controls="men-cloth">
                    @lang('website.Brands')   
                  </a>
                  <div class="sub-manu collapse show multi-collapse" id="brands">
                    
                    <ul class="unorder-list">
                      @foreach ($result['commonContent']['manufacturers'] as $item)
                      <li class="list-item">
                        <a class="brands-btn list-item" href="{{ URL::to('/shop?brand='.$item->manufacturer_name)}}" role="button"><i class="fas fa-angle-right"></i>{{$item->manufacturer_name}}</a>
                      </li>
                      @endforeach
                    </ul>    
                  </div> 
              </div> 
              @endif               
  
              </div>
            </form>
                                
  
                  </div>
                </div>
              
            </div>
            @include('web.common.scripts.shop_page_load_products')
        </section> 
     
    </section>
    
   </section>
  
  
  