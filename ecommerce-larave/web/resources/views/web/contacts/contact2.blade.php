<!-- contact Content -->
<style>
.contact-content .contact-info li {
    width: 100%;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}
</style>
<div class="container-fuild">
  <nav aria-label="breadcrumb">
      <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('website.Contact Us')</li>
          </ol>
      </div>
    </nav>
</div> 

<section class="pro-content">
        
  <div class="container">
    <div class="page-heading-title">
        <h2> @lang('website.Contact Us') 
        </h2>
     
        </div>
</div>

<section class="contact-content">

  <div class="container"> 
    <div class="row">
      <div class="col-12 col-sm-12">
        <div class="row">
            <div class="col-12 col-lg-8">
              
                <div class="form-start">
                  @if(session()->has('success') )
                     <div class="alert alert-success">
                         {{ session()->get('success') }}
                     </div>
                  @endif
                  <form enctype="multipart/form-data" action="{{ URL::to('/processContactUs')}}" method="post">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                      <label class="first-label" for="email">@lang('website.Full Name')</label>
                      <div class="input-group"> 
                        
                        <input type="text" class="form-control" id="name" name="name" placeholder="@lang('website.Please enter your name')" aria-describedby="inputGroupPrepend" required>
                        <div class="help-block error-content invalid-feedback" hidden>@lang('website.Please enter your name')</div>
                      
                      </div>
                      <label for="email">@lang('website.Email')</label>
                      <div class="input-group">                     
                          <input type="email"  name="email" class="form-control" id="validationCustomUsername" placeholder="@lang('website.Enter Email here').." aria-describedby="inputGroupPrepend" required>
                          <div class="help-block error-content invalid-feedback" hidden>@lang('website.Please enter your valid email address')</div>
                      </div>  
                      <label for="email">@lang('website.Message')</label>
                      <textarea type="text" name="message"  placeholder="@lang('website.write your message here')..." rows="5" cols="56"></textarea>
                      <div class="help-block error-content invalid-feedback" hidden>@lang('website.Please enter your message')</div>

                      <button type="submit" class="btn btn-secondary swipe-to-top">@lang('website.Submit') <i class="fas fa-location-arrow"></i>                 
                     
                    </form>
                </div>
          </div>    
          <div class="col-12 col-lg-4 contact-main">
            <div class="row">
              <div class="col-6">
                  
                  <ul class="contact-logo pl-0 mb-0">
                    <li> <i class="fas fa-mobile-alt"></i><br>@lang('website.CONTACT US') </li>
                    <li> <i class="fas fa-map-marker"></i><br>@lang('website.ADDRESS')
                    </li>
                    <li> <i class="fas fa-envelope"></i><br>@lang('website.EMAIL ADDRESS') </li>
                    <li> <i class="fas fa-tty"></i><br><phone dir="ltr">@lang('website.FAX')</phone></li>
                  </ul>
              </div>  
              <div class="col-6 right">
                <ul class="contact-info  pl-0 mb-0">
                  <li><font>
                    <a href="#" dir="ltr"><br>{{$result['commonContent']['setting'][11]->value}}</a>
                  </font> </li>
                  <li> <font><a href="#">@lang('website.Ecommerce')<br>@lang('website.Demo Store 3654123')</a></font></li>
                  <li> <font><a href="mailto:{{$result['commonContent']['setting'][3]->value}}"><br>{{$result['commonContent']['setting'][3]->value}}</a> </font></li>
                  <li><font><a href="#" dir="ltr"><br>{{$result['commonContent']['setting'][11]->value}}</a> </font></li>
                </ul>
              </div>  
            </div>
              
             
             <p style="margin-top:30px;"">
              @lang('website.Contact us text')
             </p>
          </div>
       
           
        </div>
      </div>
    </div>
    
  </div>

</section>

</section>