<!-- //footer style Five  -->

<footer id="footerFive"  class="footer-area footer-nine footer-desktop d-none d-lg-block d-xl-block pro-content">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4">
          <div class="row">
            <div class="col-10">
                <div class="footer-image mb-4">
                  <h5>@lang('website.DOWNLOAD OUR APP')</h5>
                  <a href="#"><img class="img-fluid" src="web/images/miscellaneous/google-play-btn.png" alt="google-btn"></a>
                  <a href="#"><img class="img-fluid" src="web/images/miscellaneous/app-store-btn.png" alt="appstore"></a>
                </div>
                <div class="footer-image mb-3">
                    <h5>@lang('website.We Using safe payments')</h5>
                      <img class="img-fluid" src="web/images/miscellaneous/payments.png" alt="image">
                  </div>
            </div>
          </div>
      </div>
      <div class="col-12 col-md-6 col-lg-8">
        <div class="row">
          <div class="col-12 col-md-6 col-lg-3">
                <div class="single-footer single-footer-left">
                  <h5>@lang('website.Our Services')</h5>
                  <ul class="links-list pl-0 mb-0">
                    <li> <a href="{{ URL::to('/')}}"><i class="fa fa-angle-right"></i>@lang('website.Home')</a> </li>
                    <li> <a href="{{ URL::to('/shop')}}"><i class="fa fa-angle-right"></i>@lang('website.Shop')</a> </li>
                    <li> <a href="{{ URL::to('/orders')}}"><i class="fa fa-angle-right"></i>@lang('website.Orders')</a> </li>
                    <li> <a href="{{ URL::to('/viewcart')}}"><i class="fa fa-angle-right"></i>@lang('website.Shopping Cart')</a> </li>
                    <li> <a href="{{ URL::to('/wishlist')}}"><i class="fa fa-angle-right"></i>@lang('website.Wishlist')</a> </li>           
                  </ul>
                </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <h5>@lang('website.Information')</h5>
            <ul class="links-list pl-0 mb-0">
              @if(count($result['commonContent']['pages']))
                  @foreach($result['commonContent']['pages'] as $page)
                      <li> <a href="{{ URL::to('/page?name='.$page->slug)}}"><i class="fa fa-angle-right"></i>{{$page->name}}</a> </li>
                  @endforeach
              @endif
                  <li> <a href="{{ URL::to('/contact')}}"><i class="fa fa-angle-right"></i>@lang('website.Contact Us')</a> </li>
            </ul>
          </div>
          <div class="col-12 col-lg-5">
              <h5>@lang('website.Contact Us')</h5>
              <ul class="contact-list  pl-0 mb-0">
                <li> <i class="fas fa-map-marker"></i><span>{{$result['commonContent']['setting'][4]->value}} {{$result['commonContent']['setting'][5]->value}} {{$result['commonContent']['setting'][6]->value}}, {{$result['commonContent']['setting'][7]->value}} {{$result['commonContent']['setting'][8]->value}}</span> </li>
              <li> <i class="fas fa-phone"></i><span dir="ltr">({{$result['commonContent']['setting'][11]->value}})</span> </li>
              <li> <i class="fas fa-envelope"></i><span> <a href="mailto:{{$result['commonContent']['setting'][3]->value}}">{{$result['commonContent']['setting'][3]->value}}</a> </span> </li>
              </ul>
              
          </div>
        </div>
          
      </div>
      
    </div>
    
  </div>
  <div class="container-fluid p-0">
      <div class="social-content">
          <div class="container">
            <div class="social-div">
              <div class="row align-items-center justify-content-between">
                
                <div class="col-12 col-md-4">
                      
                      <div class="footer-info">
                        © @lang('website.Copy Rights').  <a href="{{url('/page?name=refund-policy')}}">@lang('website.Privacy')</a>&nbsp;&bull;&nbsp;<a href="{{url('/page?name=term-services')}}">@lang('website.Terms')</a>
                      </div>
                </div>
                <div class="col-12 col-md-4">
                        <ul class="social">

                            <li>
                              @if(!empty($result['commonContent']['setting'][50]->value))
                                  <a href="{{$result['commonContent']['setting'][50]->value}}" class="fab fa-facebook-f" data-toggle="tooltip" data-placement="bottom" title="@lang('website.facebook')"></a>
                              @else
                              <a href="{{$result['commonContent']['setting'][50]->value}}" class="fab fa-facebook-f" data-toggle="tooltip" data-placement="bottom" title="@lang('website.facebook')"></a>
                              @endif
                            </li> 
                            <li>
                              @if(!empty($result['commonContent']['setting'][52]->value))
                                  <a href="{{$result['commonContent']['setting'][52]->value}}"  class="fab fa-twitter" data-toggle="tooltip" data-placement="bottom" title="@lang('website.twitter')"></a>
                              @else
                                  <a href="#" class="fab fa-twitter" data-toggle="tooltip" data-placement="bottom" title="@lang('website.twitter')"></a>
                              @endif
                            </li>
            
                            <li>
                              @if(!empty($result['commonContent']['setting'][51]->value))
                                  <a href="{{$result['commonContent']['setting'][51]->value}}" class="fab sk fa-google" data-toggle="tooltip" data-placement="bottom" title="@lang('website.google')"></a>
                              @else
                                  <a href="#"><i class="fab sk fa-google"  data-toggle="tooltip" data-placement="bottom" title="@lang('website.google')"></i></a>
                              @endif
                            </li>
            
                            <li>
                              @if(!empty($result['commonContent']['setting'][53]->value))
                                  <a href="{{$result['commonContent']['setting'][53]->value}}" class="fab fa-instagram" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Instagram')"></a>
                              @else
                                  <a href="#" class="fab fa-instagram" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Instagram')"></a>
                              @endif
                            </li>

                        </ul>
                </div>
              </div>
          </div>
          </div>  
      </div>
  </div>
</footer>

