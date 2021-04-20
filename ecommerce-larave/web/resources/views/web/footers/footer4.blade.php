<!-- //footer style Four -->
 <footer id="footerFour"  class="footer-area footer-four footer-desktop d-none d-lg-block d-xl-block">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-12 col-lg-3">
          <a href="{{ URL::to('/')}}" class="logo" data-toggle="tooltip" data-placement="bottom" title="@lang('website.logo')">
            @if($result['commonContent']['settings']['sitename_logo']=='name')
            <?=stripslashes($result['commonContent']['settings']['website_name'])?>
            @endif
        
            @if($result['commonContent']['settings']['sitename_logo']=='logo')
            <img class="img-fluid" src="{{asset('').$result['commonContent']['settings']['website_logo']}}" alt="<?=stripslashes($result['commonContent']['settings']['website_name'])?>">
            @endif
        </a>
          <p class="peragraph">
            {{$result['commonContent']['setting'][111]->value}}
              
          </p>  
            <ul class="contact-list  pl-0 mb-0">
              <li> <i class="fas fa-map-marker"></i><span>{{$result['commonContent']['setting'][4]->value}} {{$result['commonContent']['setting'][5]->value}} {{$result['commonContent']['setting'][6]->value}}, {{$result['commonContent']['setting'][7]->value}} {{$result['commonContent']['setting'][8]->value}}</span> </li>
              <li> <i class="fas fa-phone"></i><span dir="ltr">({{$result['commonContent']['setting'][11]->value}})</span> </li>
              <li> <i class="fas fa-envelope"></i><span> <a href="mailto:{{$result['commonContent']['setting'][3]->value}}">{{$result['commonContent']['setting'][3]->value}}</a> </span> </li>

            </ul>

        </div>
        <div class="col-12 col-lg-4">
          <h5>
             @lang('website.Contact Us')
          </h5>
          <div class="form">
            <form enctype="multipart/form-data" action="{{ URL::to('/processContactUs')}}" method="post">
              <input name="_token" value="{{ csrf_token() }}" type="hidden">
              <input type="text" placeholder="@lang('website.Please enter your name')">
              <input type="email" placeholder="@lang('website.Enter Email here')..">
              <textarea name="message"  placeholder="@lang('website.Please enter your message')" rows="5" cols="56"></textarea>
              <span class="help-block error-content" hidden>@lang('website.Please enter your message')</span>
              <button type="submit" class="btn btn-secondary swipe-to-top" >@lang('website.Submit')</button>
            </form>
          </div>
        </div>
        <div class="col-12 col-lg-3">
          @if(!empty($result['commonContent']['setting'][119]) and $result['commonContent']['setting'][119]->value==1)
          
          <div class="newsletter">
            <h5>@lang('website.Newsletter')</h5>
            <div class="block">
              
              <form class="form-inline" >
                <div class="search-field-module">                           
                
                  <div class="search-field-wrap">
                      <input type="email" name="email" id="email" placeholder="@lang('website.Your email address here')">
                      <button type="button" class="btn btn-secondary swipe-to-top">
                      <i class="fa fa-search"></i></button>
                      <div class="alert alert-success alert-dismissible success-subscribte" role="alert" style="opacity: 500; display: none;"></div>

                      <div class="alert alert-danger alert-dismissible error-subscribte" role="alert" style="opacity: 500; display: none;"></div>
                  </div>
                </div>
              </form>
            </div>
        </div>
            @endif

            <div class="socials">
              <h5>@lang('website.Follow Us')</h5>
              <ul class="list">
                <li>
                  @if(!empty($result['commonContent']['setting'][50]->value))
                      <a href="{{$result['commonContent']['setting'][50]->value}}" class="fab fb fa-facebook-square" data-toggle="tooltip" data-placement="bottom" title="@lang('website.facebook')"></a>
                  @else
                  <a href="{{$result['commonContent']['setting'][50]->value}}" class="fab fb fa-facebook-square" data-toggle="tooltip" data-placement="bottom" title="@lang('website.facebook')"></a>
                  @endif
                </li> 
                <li>
                  @if(!empty($result['commonContent']['setting'][52]->value))
                      <a href="{{$result['commonContent']['setting'][52]->value}}"  class="fab tw fa-twitter-square" data-toggle="tooltip" data-placement="bottom" title="@lang('website.twitter')"></a>
                  @else
                      <a href="#" class="fab tw fa-twitter-square" data-toggle="tooltip" data-placement="bottom" title="@lang('website.twitter')"></a>
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
                      <a href="{{$result['commonContent']['setting'][53]->value}}" class="fab ig fa-instagram" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Instagram')"></a>
                  @else
                      <a href="#" class="fab ig fa-instagram" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Instagram')"></a>
                  @endif
                </li>   
              </ul>
          </div>         

        </div>
      </div>
    </div>
    <div class="container-fluid p-0">
        <div class="copyright-content">
            <div class="container">
              <div class="row align-items-center">
                  <div class="col-12 col-md-6">
                    <div class="footer-image">
                        <img class="img-fluid" src="{{asset('web/images/miscellaneous/payments.png')}}">
                    </div>

                  </div>
                  <div class="col-12 col-md-6">
                    <div class="footer-info">
                        © @lang('website.Copy Rights').  <a href="{{url('/page?name=refund-policy')}}">@lang('website.Privacy')</a>&nbsp;&bull;&nbsp;<a href="{{url('/page?name=term-services')}}">@lang('website.Terms')</a>
                    </div>

                  </div>
              </div>
            </div>
          </div>
    </div>
</footer>
