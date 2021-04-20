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
  <div class="container">
      <div class="top-bar">
          <div class="row">
            <div class="col-12 col-lg-12">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-2">
                        <div class="block">
                            <label>@lang('website.Display')</label>
                            <div class="buttons">
                              <a href="javascript:void(0);" id="grid"><i class="fas fa-th-large"></i></a>
                              <a href="javascript:void(0);" id="list"><i class="fas fa-list"></i></a>
                            </div>
                        </div>
                    </div> 

                    <div class="col-12 col-xl-7 select-bar">
                        <form class="form-inline justify-content-center">
                          @if(!empty($result['categories']))
                            <div class="form-group ">
                                <label>@lang('website.Categories') </label>
                                <div class="select-control">
                                  <select class="form-control" name="category" onchange="this.form.submit()">
                                      @foreach($result['categories'] as $category)
                                      <option value="{{$category->slug}}" @if(app('request')->input('category') == $category->slug) selected @endif>{{$category->categories_name}}</option>                                      
                                          @if(isset($category->childs)){
                                            @foreach($category->childs as $cat)
                                              <option value="{{$cat->slug}}" @if(app('request')->input('category') == $category->slug) selected @endif>-{{$cat->categories_name}}</option>
                                            @endforeach
                                          @endif
                                      @endforeach                                      
                                  </select>
                                </div>
                              
                            </div>
                            @endif
                        </form>
                          
                        
                    </div> 
                    @if($result['products']['success']==1)
                    <div class="col-12 col-xl-3">
                      <form class="form-inline justify-content-end" id="load_products_form">
                      <input type="hidden" name="min_price" id="min_price" value="0">
                      <input type="hidden" name="max_price" id="max_price" value="{{$result['filters']['maxPrice']}}">
                      @if(isset($_GET['price']))
                      <input type="hidden" name="price"  value="{{ $_GET['price'] }}">
                      @endif
                        @if(!empty(app('request')->input('search')))
                         <input type="hidden"  name="search" value="{{ app('request')->input('search') }}">
                        @endif
                        @if(!empty(app('request')->input('category')))
                         <input type="hidden"  name="category" value="@if(app('request')->input('category')!='all'){{ app('request')->input('category') }} @endif">
                        @endif
                         <input type="hidden"  name="load_products" value="1">
                         <input type="hidden"  name="products_style" id="products_style" value="grid">
                         <input type="hidden"  name="products_style" id="pagelayout" value="fullpage">
                          
                          <div class="form-group">
                              <label>@lang('website.Sort')</label> 
                              <div class="select-control">
                                <select name="type" id="sortbytype" class="form-control" >
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
                          
                          <div class="form-group">
                              <label>@lang('website.Limit')</label> 
                              <div class="select-control">
                                <select class="form-control"name="limit" id="sortbylimit" >
                                  <option value="15" @if(app('request')->input('limit')=='15') selected @endif>15</option>
                                  <option value="30" @if(app('request')->input('limit')=='30') selected @endif>30</option>
                                  <option value="60" @if(app('request')->input('limit')=='60') selected @endif>60</option>
                                </select>
                              
                          </div>                          
                          
                    </div>  
                    @endif
                </div>
              
            </div>
          </div>
      </div>  
    </div>
  </div>
</div>
  
  <section id="swap2" class="shop-content shop-topbar shop-one" >
    <div class="container">
      <div class="products-area">
      @if($result['products']['success']==1)
      
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
            <div class="col-12 col-md-6 col-lg-3">
              @include('web.common.product')
            </div>
              <?php }?>
            
              
            @endforeach
            @else
            <div class="col-12">
            <br>
            <h3>@lang('website.No Record Found!')</h3></div>
            @endif
            @include('web.common.scripts.addToCompare')            
        </div>
      @else
      <br>
        <h3>@lang('website.No Record Found!')</h3>
      @endif
        
    </div>
    
    </div>  
  </section> 
  @if($result['categories_status'] == 1)
  <div class="container">
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
  </div>
  @endif
</form>
@include('web.common.scripts.shop_page_load_products')
</section>

