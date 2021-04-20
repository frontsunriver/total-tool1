
      <!-- //footer style Ten -->
      <footer id="footerTen"  class="footer-area footer-ten footer-desktop d-none d-lg-block d-xl-block">
          <div class="container-fluid p-0">
              <div class="brands-content ">
                  <div class="container">
                    <div class="row">
                      <div class="col-12">
                        <img class="img-fluid" src="{{asset('web/images/brands/brands-content.jpg')}}">
                        </div>
                    </div>
                  </div>
                </div>
          </div>
            <div class="container">
              <div class="row">
                <div class="col-12 col-md-6 col-lg-5">
                    <h5>@lang('website.About Store')</h5>
                  <div class="row">
                    <div class="col-12 col-lg-8">
                      <hr>
                    </div>
                  </div>
                    <p>
                      {{$result['commonContent']['setting'][111]->value}}
                    </p>
                </div>
                <div class="col-12 col-lg-7">
                  <div class="row">
                    <div class="col-12 col-md-6 col-lg-3">
                      <h5>@lang('website.Information')</h5>
                      <div class="row">
                        <div class="col-12 col-lg-11">
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
                    <div class="col-12 col-lg-5">
                        <h5>@lang('website.Contact Us')</h5>
                        <div class="row">
                          <div class="col-12 col-lg-8">
                            <hr>
                          </div>
                        </div>
                        <ul class="contact-list  pl-0 mb-0">
                          <li> <i class="fas fa-map-marker"></i><span>{{$result['commonContent']['setting'][4]->value}} {{$result['commonContent']['setting'][5]->value}} {{$result['commonContent']['setting'][6]->value}}, {{$result['commonContent']['setting'][7]->value}} {{$result['commonContent']['setting'][8]->value}}</span> </li>
                          <li> <i class="fas fa-phone"></i><span dir="ltr">({{$result['commonContent']['setting'][11]->value}})</span> </li>
                          <li> <i class="fas fa-envelope"></i><span> <a href="mailto:{{$result['commonContent']['setting'][3]->value}}">{{$result['commonContent']['setting'][3]->value}}</a> </span> </li>
                        </ul>

                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                      <div class="single-footer single-footer-left">
                        <h5>@lang('website.Follow Us')</h5>
                        <div class="row">
                          <div class="col-12 col-lg-11">
                            <hr>
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
                        <div class="footer-image mt-4">
                            <a href="#"><img class="img-fluid" src="{{asset('web/images/miscellaneous/payments.png')}}"></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            

            <div class="container-fluid p-0">
              <div class="copyright-content">
                  <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-8">
                          <div class="newsletter">
                            <div class="block">
                              <h5>@lang('website.SUBSCRIBE FOR LATEST UPDATES')</h5>
                              @if(!empty($result['commonContent']['setting'][118]) and $result['commonContent']['setting'][118]->value==1)

                              <form class="form-inline mailchimp-form" action="{{url('subscribeMail')}}" >
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

                              {{-- <h5>@lang('website.Subscribe')</h5>
                              <form class="form-inline">
                                <div class="search">
                                  <input type="email" name="email" id="email" placeholder="@lang('website.Your email address here')">
                                  <button class="btn-secondary fas fa-location-arrow"  id="subscribe"  type="submit">
                                  </button>
                                </div>
                              </form> --}}
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-4">
                          <div class="footer-info">
                              <p>© @lang('website.Copy Rights').  <a href="{{url('/page?name=refund-policy')}}">@lang('website.Privacy')</a>&nbsp;&bull;&nbsp;<a href="{{url('/page?name=term-services')}}">@lang('website.Terms')</a></p>
                          </div>
                        </div>
                  </div>
                  </div>
              </div>
          </div>
      </footer>
