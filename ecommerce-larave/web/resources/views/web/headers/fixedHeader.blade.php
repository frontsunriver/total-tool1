
        <header id="stickyHeader" class="header-area header-sticky d-none">
          <div class="header-sticky-inner  bg-sticky-bar">
            <div class="container">
    
                <div class="row align-items-center">
                    <div class="col-12 col-lg-2">
                        <div class="logo">
                          <a href="{{ URL::to('/')}}" class="logo" data-toggle="tooltip" data-placement="bottom" title="@lang('website.logo')">
                            @if($result['commonContent']['settings']['sitename_logo']=='name')
                            <?=stripslashes($result['commonContent']['settings']['website_name'])?>
                            @endif
                        
                            @if($result['commonContent']['settings']['sitename_logo']=='logo')
                            <img class="img-fluid" src="{{asset('').$result['commonContent']['settings']['website_logo']}}" alt="<?=stripslashes($result['commonContent']['settings']['website_name'])?>">
                            @endif
                            </a>

                          </div>
                    </div>
                    <div class="col-12 col-lg-7" style="position: static;">
                      <nav id="navbar_header_9" class="navbar navbar-expand-lg  bg-nav-bar">
                  
                        <div class="navbar-collapse">
                          <ul class="navbar-nav">
                            {!! $result['commonContent']["menusRecursive"] !!}
                                
                          </ul>
                        </div>
                      </nav>
                    </div>
                    <div class="col-12 col-lg-3">
                        <ul class="pro-header-right-options">
                          
                              <li class="dropdown search-field">
                                  <button class="btn btn-light dropdown-toggle" type="button" id="dropdownAccountButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fas fa-search"></i>
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownAccountButton">
                                    <form class="form-inline" action="{{ URL::to('/shop')}}" method="get">
                                          <div class="search-field-module">
                                              <input type="text" class="form-control" id="inlineFormInputGroup0" name="search" placeholder="@lang('website.Search entire store here')...">
                                              <button class="btn" type="submit">
                                                  <i class="fas fa-search"></i>
                                              </button>
                                          </div>
                                        </form>
                                    
                                  </div>
                                </li>
                            <li class="dropdown profile-tags">
                              <button class="btn btn-light dropdown-toggle" type="button" id="dropdownAccountButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-user"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownAccountButton">
                                <?php if(auth()->guard('customer')->check()){ ?>
                                  <a class="dropdown-item" href="{{url('profile')}}">@lang('website.Profile')</a>
                                  <a class="dropdown-item" href="{{url('wishlist')}}">@lang('website.Wishlist')</a>
                                  <a class="dropdown-item" href="{{url('compare')}}">@lang('website.Compare')&nbsp;(<span id="compare">0</span>)</a>
                                  <a class="dropdown-item" href="{{url('orders')}}">@lang('website.Orders')</a>
                                  <a class="dropdown-item" href="{{url('logout')}}">@lang('website.Logout')</a>
                                <?php }else{ ?>
                                  <a class="dropdown-item" href="{{url('login')}}">@lang('website.Login/Register')</a>                    
                                <?php } ?>
                                
                              </div>
                            </li>
                            <li>
                              <a href="{{ URL::to('/wishlist')}}" class="btn btn-light" >
                                  <i class="far fa-heart"></i>
                                  <span class="badge badge-secondary total_wishlist">{{$result['commonContent']['total_wishlist']}}</span>
                              </a>
                            </li>
          
                            <li class="dropdown head-cart-content-fixed">
                              @include('web.headers.cartButtons.cartButtonFixed')    
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
          </div> 
        </header>
