@extends('web.layout')
@section('content')


<div class="container-fuild">
	<nav aria-label="breadcrumb">
		<div class="container">
			<ol class="breadcrumb">
			  <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
			  <li class="breadcrumb-item active" aria-current="page">@lang('website.Login')</li>

			</ol>
		</div>
	  </nav>
  </div> 

<!-- page Content -->
<section class="page-area">
  <div class="container">
      <div class="row justify-content-center">

        <div class="col-12 col-sm-12 col-md-6">
          @if(Session::has('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                  <span class="">@lang('website.error'):</span>
                  {!! session('error') !!}

                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          @endif
          <div class="col-12 my-5">

             <h5>Forgot Password</h5>
             <hr style="margin-bottom: 0;">
                <div class="tab-content" id="registerTabContent">
                  <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                      <div class="registration-process">
                      <form name="signup" enctype="multipart/form-data" class="form-validate"  action="{{ URL::to('/processPassword')}}" method="post">
                        {{csrf_field()}}
                          <div class="from-group mb-3">
                            <div class="col-12"> <label for="inlineFormInputGroup">@lang('website.Email')</label></div>
                            <div class="input-group col-12">
                              <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="fas fa-lock"></i></div>
                              </div>
                              <input class="form-control" type="email" name="email" id="email"placeholder="@lang('website.Please enter your valid email address')">
                              <span class="help-block error-content" hidden>@lang('website.Please enter your valid email address')</span>                            </div>
                          </div>
                            <div class="col-12 col-sm-12">
                                <button type="submit"  class="btn btn-secondary">@lang('website.Send')</button>

                            </div>
                      </form>
                      </div>

                  </div>

                  <div class="registration-socials">
                      <div class="row align-items-center justify-content-center">

                              <div class="col-12 col-sm-12 col-xl-5 mb-1">
                                  
                                  @lang('website.Access Your Account Through Your Social Networks')
                              </div>
                              <div class="col-auto">
                                  <a href="login/google"  class="btn btn-google"><i class="fab fa-google-plus-g"></i>&nbsp;@lang('website.Google') </a>
                                  <a href="login/facebook" class="btn btn-facebook"><i class="fab fa-facebook-f"></i>&nbsp;@lang('website.Facebook')</a>
                                </div>
                          </div>
                      </div>
                </div>
          </div>
        </div>

      </div>
  </div>
</section>


@endsection
