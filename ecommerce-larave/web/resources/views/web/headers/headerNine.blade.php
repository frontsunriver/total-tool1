@include('web.headers.fixedHeader') 
<header id="headerOne" class="header-area header-one  header-desktop d-none d-lg-block d-xl-block">
   <div class="header-mini bg-top-bar">
     <div class="container">
       <div class="row">
         <div class="col-12 col-md-6">
           
             <div class="navbar-lang">              
                @if(count($languages) > 1)
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" >
                      {{	session('language_name')}}
                    </button>
                    <div class="dropdown-menu" >
                      @foreach($languages as $language)
                      <a onclick="myFunction1({{$language->languages_id}})" class="dropdown-item" href="#">                     
                        {{$language->name}}
                      </a>                    
                      @endforeach                   
                    </div>
                </div> 
                @include('web.common.scripts.changeLanguage')
                @endif

                @if(count($currencies) > 1)
                  <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" >
                      {{session('currency_code')}}
                    </button>
                    <div class="dropdown-menu">
                      @foreach($currencies as $currency)
                      <a onclick="myFunction2({{$currency->id}})" class="dropdown-item" href="#">                      
                        <span>{{$currency->code}}</span>
                      </a>
                      @endforeach
                    </div>
                  </div>
                  @include('web.common.scripts.changeCurrency')
                @endif
              </div>
         </div>
         <div class="col-12 col-md-6">
             <ul class="pro-header-options">
               <li>
                   <p><?php if(auth()->guard('customer')->check()){ ?>@lang('website.Welcome') {{auth()->guard('customer')->user()->first_name}}&nbsp;! <?php }?> 
                   </p>
               </li>
               <li class="dropdown">
                   <button class="btn dropdown-toggle" type="button" >
                    @lang('website.My Account') 
                     </button>
                     <div class="dropdown-menu" >

                       <?php if(auth()->guard('customer')->check()){ ?>
                         <a class="dropdown-item" href="{{url('profile')}}" >@lang('website.Profile')</a>
                         <a class="dropdown-item" href="{{url('wishlist')}}" >@lang('website.Wishlist')<span class="total_wishlist"> ({{$result['commonContent']['total_wishlist']}})</span></a>
                         <a class="dropdown-item" href="{{url('compare')}}" >@lang('website.Compare')&nbsp;(<span id="compare">{{$count}}</span>)</a>
                         <a class="dropdown-item" href="{{url('orders')}}" >@lang('website.Orders')</a> 
                         <a class="dropdown-item" href="{{url('shipping-address')}}" >@lang('website.Shipping Address')</a> 
                         <a class="dropdown-item" href="{{url('logout')}}">@lang('website.Logout')</a> 
                        <?php }else{ ?>
                           <a class="dropdown-item" href="{{ URL::to('/login')}}"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;@lang('website.Login/Register')</a> 
            
                        <?php } ?>

                     </div>
               </li>
             </ul>
             
         </div>
       </div>
     </div> 
   </div>
   <div class="header-maxi bg-header-bar">
     <div class="container">
       <div class="row align-items-center">
         <div class="col-12 col-md-12 col-lg-3">
          <a href="{{ URL::to('/')}}" class="logo" data-toggle="tooltip" data-placement="bottom" title="@lang('website.logo')">
            @if($result['commonContent']['settings']['sitename_logo']=='name')
            <?=stripslashes($result['commonContent']['settings']['website_name'])?>
            @endif
        
            @if($result['commonContent']['settings']['sitename_logo']=='logo')
            <img class="img-fluid" src="{{asset('').$result['commonContent']['settings']['website_logo']}}" alt="<?=stripslashes($result['commonContent']['settings']['website_name'])?>">
            @endif
            </a>
         </div>
         
             <div class="col-12 col-sm-6">
             
              <form class="form-inline" action="{{ URL::to('/shop')}}" method="get">   
                <div class="search-field-module">   
                    <input type="hidden" name="category" class="category-value" value="">
                    @include('web.common.HeaderCategories')
                  <button class="btn btn-secondary swipe-to-top dropdown-toggle header-selection" type="button" id="headerOneCartButton"  
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
                    data-toggle="tooltip" data-placement="bottom" title="@lang("website.Choose Any Category")"> 
                    @lang("website.Choose Any Category")
                  </button> 
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="headerOneCartButton">   
                      @php    productCategories(); @endphp                                                                 
                  </div>
                  <div class="search-field-wrap">
                      <input  type="search" name="search" placeholder="@lang('website.Search entire store here')..." data-toggle="tooltip" data-placement="bottom" title="@lang('website.Search Products')" value="{{ app('request')->input('search') }}">
                      <button class="btn btn-secondary swipe-to-top" data-toggle="tooltip" 
                      data-placement="bottom" title="@lang('website.Search Products')">
                      <i class="fa fa-search"></i></button>
                  </div>
                </div>
              </form>
             </div>
           <div class="col-6 col-sm-6 col-md-4 col-lg-3">
            <ul class="pro-header-right-options">
             <li>
              <a href="{{ URL::to('/wishlist')}}" class="btn" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Wishlist')">
                <i class="far fa-heart"></i>
                <span class="badge badge-secondary total_wishlist">{{$result['commonContent']['total_wishlist']}}</span>
              </a>
             </li>
             <li class="dropdown head-cart-content">
              @include('web.headers.cartButtons.cartButton9')                
             </li>
           </ul>
         </div>
       </div>
     </div>
   </div> 
   <div class="header-navbar bg-menu-bar">
       <div class="container">
         <nav id="navbar_header_9" class="navbar navbar-expand-lg  bg-nav-bar">

           <div class="navbar-collapse" >
             <ul class="navbar-nav">
              {!! $result['commonContent']["menusRecursive"] !!}
                   
             </ul>
           </div>
         </nav>
       </div>
   </div>
 </header>