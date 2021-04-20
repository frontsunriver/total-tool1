<!-- //footer style Eight -->
<footer id="footerEight"  class="footer-area footer-eight footer-desktop d-none d-lg-block d-xl-block">
  <div class="container-fluid p-0">
      <div class="search-content">
          <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 align-self-center">
                    <div class="newsletter">
                        <h5>@lang('website.SUBSCRIBE FOR THE LATEST NEWS AND GET 10% DISCOUNT ON SPECIAL ITEMS')</h5>
                        <div class="block">
                          @if(!empty($result['commonContent']['setting'][118]) and $result['commonContent']['setting'][118]->value==1)

                          <form class="form-inline" >
                            <div class="search-field-module">                           
                              
                              <div class="search-field-wrap">
                                <input type="email" name="email" class="email" placeholder="@lang('website.Your email address here')">
                                <button type="submit" class="btn btn-secondary swipe-to-top" >
                                  @lang('website.Subscribe')</button>
                                  <div class="alert alert-success alert-dismissible success-subscribte" role="alert" style="opacity: 500; display: none;"></div>
                                    <div class="alert alert-danger alert-dismissible error-subscribte" role="alert" style="opacity: 500; display: none;"></div>
                              </div>
                            </div>
                          </form>
                          @endif

                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-3 footer-padding">
        <div class="socials">
            <h5>Follow Us</h5>
            <div class="row">
                <div class="col-12 col-lg-8">
                  <hr>
                </div>
              </div>
            <ul class="list">
              <li>
                @if(!empty($result['commonContent']['setting'][50]->value))
                  <a href="{{$result['commonContent']['setting'][50]->value}}" class="fab fa-facebook-f" target="_blank"></a>
                  @else
                    <a href="#" class="fab fa-facebook-f"></a>
                  @endif
              </li>
              <li>
              @if(!empty($result['commonContent']['setting'][52]->value))
                  <a href="{{$result['commonContent']['setting'][52]->value}}" class="fab fa-twitter" target="_blank"></a>
              @else
                  <a href="#" class="fab fa-twitter"></a>
              @endif</li>
              <li>
              @if(!empty($result['commonContent']['setting'][51]->value))
                  <a href="{{$result['commonContent']['setting'][51]->value}}"  target="_blank"><i class="fab fa-google"></i></a>
              @else
                  <a href="#"><i class="fab fa-google"></i></a>
              @endif
              </li>
              <li>
              @if(!empty($result['commonContent']['setting'][53]->value))
                  <a href="{{$result['commonContent']['setting'][53]->value}}" class="fab fa-linkedin-in" target="_blank"></a>
              @else
                  <a href="#" class="fab fa-linkedin-in"></a>
              @endif
              </li>
            </ul>
            
            <div class="footer-image">
              <h5>@lang('payment method')</h5>
                <div class="row">
                    <div class="col-12 col-lg-8">
                      <hr>
                    </div>
                  </div>
                  <img class="img-fluid" src="{{asset('web/images/miscellaneous/payments.png')}}">
            </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-lg-3 footer-padding">
        <div class="footer-block">
              <h5>Our Services</h5>
              <div class="row">
                  <div class="col-12 col-lg-8">
                    <hr>
                  </div>
                </div>
              <ul class="links-list pl-0 mb-0">
                <li> <a href="{{ URL::to('/')}}"><i class="fa fa-angle-right"></i>@lang('website.Home')</a> </li>
                <li> <a href="{{ URL::to('/shop')}}"><i class="fa fa-angle-right"></i>@lang('website.Shop')</a> </li>
                <li> <a href="{{ URL::to('/orders')}}"><i class="fa fa-angle-right"></i>@lang('website.Orders')</a> </li>
                <li> <a href="{{ URL::to('/viewcart')}}"><i class="fa fa-angle-right"></i>@lang('website.Shopping Cart')</a> </li>
                <li> <a href="{{ URL::to('/wishlist')}}"><i class="fa fa-angle-right"></i>@lang('website.Wishlist')</a> </li>
              </ul>
            
        </div>
      </div>
      <div class="col-12 col-md-6 col-lg-3 footer-padding">
          <h5>@lang('website.Information')</h5>
          <div class="row">
              <div class="col-12 col-lg-8">
                <hr>
              </div>
            </div>
          <ul class="links-list pl-0 mb-0">

                @if(count($result['commonContent']['pages']))
                  @foreach($result['commonContent']['pages'] as $page)
                      <li> <a href="{{ URL::to('/page?name='.$page->slug)}}"><i class="fa fa-angle-right"></i>{{$page->name}}</a> </li>
                  @endforeach
                @endif
                  <li> <a href="{{ URL::to('/contact')}}"><i class="fa fa-angle-right"></i>@lang('website.Contact Us')</a> </li>

          </ul>
      </div>
      <div class="col-12 col-lg-3">
        <div class="contacts">
          <h5>@lang('website.Contact Us')</h5>
          <div class="row">
            <div class="col-12 col-lg-8">
              <hr>
            </div>
          </div>
          <ul class="contact-list  pl-0 mb-0">

            <li> <i class="fas fa-location-arrow"></i><span>{{$result['commonContent']['setting'][4]->value}} {{$result['commonContent']['setting'][5]->value}} {{$result['commonContent']['setting'][6]->value}}, {{$result['commonContent']['setting'][7]->value}} {{$result['commonContent']['setting'][8]->value}}</span> </li>
            <li> <i class="fas fa-phone"></i><span dir="ltr">({{$result['commonContent']['setting'][11]->value}})</span> </li>
            <li> <i class="fas fa-envelope"></i><span> <a href="mailto:{{$result['commonContent']['setting'][3]->value}}">{{$result['commonContent']['setting'][3]->value}}</a> </span> </li>
      
          </ul>
          </div>
      </div>
     
    </div>
  </div>
  <div class="container-fluid p-0">
      <div class="copyright-content">
          <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                  <div class="footer-info">
                    © @lang('website.Copy Rights').  <a href="{{url('/page?name=refund-policy')}}">@lang('website.Privacy')</a>&nbsp;&bull;&nbsp;<a href="{{url('/page?name=term-services')}}">@lang('website.Terms')</a>
                  </div>
                    
                </div>
            </div>
          </div>
        </div>
  </div> 
</footer>
