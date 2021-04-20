<footer id="footerMobile" class="footer-area footer-mobile d-lg-none d-xl-none">
  <div class="container-fluid p-0">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-8">
            <div class="single-footer display-mobile">
                <h5>@lang('website.Subscribe for Newsletter')</h5>
                <div class="row">
                  <div class="col-7 col-md-8">
                    <hr>
                  </div>
                </div>
              </div>
              @if(!empty($result['commonContent']['setting'][89]) and $result['commonContent']['setting'][89]->value==1)
                <div class="newsletter">
                    <div class="block">
                      <form class="form-inline mailchimp-form" action="{{url('subscribeMail')}}" >
                            <div class="search">
                              <input type="email" name="email" class="email" placeholder="@lang('website.Your email address here')">
                              <button id="subscribe" class="btn btn-secondary subscribe" type="submit">
                                  @lang('website.Subscribe')
                                </button>
                                <button class="btn-secondary fas fa-location-arrow" type="submit">
                                </button>
                                <div class="alert alert-success alert-dismissible success-subscribte" role="alert" style="opacity: 500; display: none;"></div>

                                <div class="alert alert-danger alert-dismissible error-subscribte" role="alert" style="opacity: 500; display: none;"></div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

        </div>
        <div class="col-12 col-md-4">
          <div class="single-footer display-mobile">
              <h5>@lang('website.Follow Us')</h5>
              <div class="row">
                <div class="col-7 col-md-8">
                  <hr>
                </div>
              </div>
            </div>
              <div class="socials">
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
              </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid px-0  footer-inner">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="single-footer">
            <h5>@lang('website.About Store')</h5>
            <div class="row">
              <div class="col-7 col-md-8">
                <hr>
              </div>
            </div>
            <ul class="contact-list  pl-0 mb-0">
              <li> <i class="fas fa-map-marker"></i><span>{{$result['commonContent']['setting'][4]->value}} {{$result['commonContent']['setting'][5]->value}} {{$result['commonContent']['setting'][6]->value}}, {{$result['commonContent']['setting'][7]->value}} {{$result['commonContent']['setting'][8]->value}}</span> </li>
              <li> <i class="fas fa-phone"></i><span dir="ltr">({{$result['commonContent']['setting'][11]->value}})</span> </li>
              <li> <i class="fas fa-envelope"></i><span> <a href="mailto:sales@brandbychoice.com">{{$result['commonContent']['setting'][3]->value}}</a> </span> </li>

            </ul>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="footer-block">
            <div class="single-footer single-footer-left">
              <h5>Our Services</h5>
              <div class="row">
                  <div class="col-7 col-md-8">
                    <hr>
                  </div>
              </div>
              <ul class="links-list pl-0 mb-0">
                <li> <a href="{{ URL::to('/')}}"><i class="fa fa-angle-right"></i>Home</a> </li>
              <li> <a href="{{ URL::to('/shop')}}"><i class="fa fa-angle-right"></i>Shop</a> </li>
              <li> <a href="{{ URL::to('/orders')}}"><i class="fa fa-angle-right"></i>Orders</a> </li>
              <li> <a href="{{ URL::to('/viewcart')}}"><i class="fa fa-angle-right"></i>Shopping Cart</a> </li>
              <li> <a href="{{ URL::to('/wishlist')}}"><i class="fa fa-angle-right"></i>Wishlist</a> </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4 ">
          <div class="single-footer single-footer-right">
            <h5>@lang('website.Information')</h5>
            <div class="row">
              <div class="col-7 col-md-8">
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
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid p-0">
    <div class="copyright-content">
        <div class="container">
          <div class="row align-items-center">

              <div class="col-12 col-md-6">
                <div class="footer-info">
                  &copy;&nbsp;@lang('website.Copy Rights'). <a href="{{url('/page?name=refund-policy')}}">@lang('website.Privacy')</a>&nbsp;&bull;&nbsp;<a href="{{url('/page?name=term-services')}}">@lang('website.Terms')</a>
                

                </div>

              </div>
              <div class="col-12 col-md-6">
                  <div class="footer-image">
                      <img class="img-fluid" src="{{asset('web/images/miscellaneous/payments.png')}}">
                  </div>

              </div>
          </div>
        </div>
    </div>
  </div>

</footer>
