<!-- login Content -->
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

<section class="page-area pro-content">
	<div class="container"> 

		<div class="row justify-content-center">
			<div class="col-12 col-sm-12 col-md-6 justify-content-center">
				@if(Session::has('loginError'))
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<span class="">@lang('website.Error'):</span>
						{!! session('loginError') !!}

						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif

				@if(Session::has('success'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<span class="">@lang('website.success'):</span>
						{!! session('success') !!}

						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif

				@if( count($errors) > 0)
					@foreach($errors->all() as $error)
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<span class="sr-only">@lang('website.Error'):</span>
						{{ $error }}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</button>
					</div>
					@endforeach
				@endif

				@if(Session::has('error'))
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<span class="sr-only">@lang('website.Error'):</span>
						{!! session('error') !!}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif

				@if(Session::has('success'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<span class="sr-only">@lang('website.Success'):</span>
						{!! session('success') !!}

						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif

			</div>
		</div>
	  
	  
		<div class="row justify-content-center">	   
		  
		
		  <div class="col-12 col-sm-12 col-md-6">
			  
			<div class="col-12 my-5 px-0">
				
				<ul class="nav nav-tabs" id="registerTab" role="tablist">
					<li class="nav-item">
					  <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">@lang('website.Login')</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="signup" aria-selected="false">@lang('website.Signup')</a>
					</li>
					
				  </ul>
				  <div class="tab-content" id="registerTabContent">
					<div class="tab-pane fade show active form-validate-login" id="login" role="tabpanel" aria-labelledby="login-tab">
						<div class="registration-process">
						<form  enctype="multipart/form-data"   action="{{ URL::to('/process-login')}}" method="post">
							{{csrf_field()}}
							<div class="from-group mb-3">
								<div class="col-12"> <label for="inlineFormInputGroup">@lang('website.Email')</label></div>
								<div class="input-group col-12">
								<input type="email" name="email" id="email" placeholder="@lang('website.Please enter your valid email address')"class="form-control email-validate-login">
								<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your valid email address')</span>
							</div>
						</div>
						<div class="from-group mb-3">
								<div class="col-12"> <label for="inlineFormInputGroup">@lang('website.Password')</label></div>
								<div class="input-group col-12">
									<input type="password" name="password" id="password-login" placeholder="Please Enter Password" class="form-control password-login">
									<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your password')</span>										</div>
							</div>
							  <div class="col-12 col-sm-12">
								  <button class="btn btn-secondary swipe-to-top">@lang('website.Login')</button>
								<a href="{{ URL::to('/forgotPassword')}}" class="btn btn-link">@lang('website.Forgot Password')</a>

								@if($result['checkout_button'] == 1)
									<p style="text-align:center; margin-top:30px;">
										<strong>OR</strong>
									</p>
									<a href="{{url('/guest_checkout')}}" type="submit" class="btn btn-light swipe-to-top btn-block">
										@lang('website.Guest Checkout')
									</a>
									@endif

							  </div>
						</form>
						</div>
						
					</div>
					<div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
						<div class="registration-process">
						<form name="signup" enctype="multipart/form-data" class="form-validate" action="{{ URL::to('/signupProcess')}}" method="post">
							{{csrf_field()}}

							<div class="from-group mb-3">
								<div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>@lang('website.First Name')</label></div>
								<div class="input-group col-12">
									<input  name="firstName" type="text" class="form-control field-validate" id="firstName" placeholder="@lang('website.Please enter your first name')" value="{{ old('firstName') }}">
									<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your first name')</span>
								</div>
							</div>
							<div class="from-group mb-3">
								<div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>@lang('website.Last Name')</label></div>
								<div class="input-group col-12">
									<input  name="lastName" type="text" class="form-control field-validate field-validate" id="lastName" placeholder="@lang('website.Please enter your first name')" value="{{ old('lastName') }}">
									<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your last name')</span>
								</div>
							</div>
								<div class="from-group mb-3">
									<div class="col-12"> <label for="inlineFormInputGroup">@lang('website.Date of Birth')</label></div>
									<div class="input-group col-12 date">
										<input  name="customers_dob" type="text" class="form-control customers_dob" data-provide="datepicker" id="customers_dob" placeholder="@lang('website.Please enter your date of birth')" value="{{ old('customers_dob') }}">
										<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your date of birth')</span>
									</div>
								</div>
								<div class="from-group mb-3">
									<div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>@lang('website.Email Adrress')</label></div>
									<div class="input-group col-12">
										<input  name="email" type="text" class="form-control email-validate" id="inlineFormInputGroup" placeholder="@lang('website..Please enter your valid email address')" value="{{ old('email') }}">
										<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your valid email address')</span>
									</div>
								</div>
								<div class="from-group mb-3">
									<div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>@lang('website.Password')</label></div>
									<div class="input-group col-12">
										<input name="password" id="password" type="password" class="form-control password"  placeholder="@lang('website.Please enter your password')">
										<span class="form-text text-muted error-content" hidden >@lang('website.Please enter your password')</span>

									</div>
								</div>
								<div class="from-group mb-3">
									<div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>@lang('website.Confirm Password')</label></div>
										<div class="input-group col-12">
											<input type="password" class="form-control password" id="re_password" name="re_password" placeholder="@lang('website.Please enter your password')">
											<span class="form-text text-muted error-content" hidden>@lang('website.Please re-enter your password')</span>
											<span class="form-text text-muted error-content re-password-content" hidden>@lang('website.Password does not match the confirm password')</span>
										</div>
									</div>
									<div class="from-group mb-3">
										<div class="col-12" > <label for="inlineFormInputGroup"><strong  style="color: red;">*</strong>@lang('website.Gender')</label></div>
										<div class="input-group col-12">
											<select class="form-control field-validate" name="gender" id="inlineFormCustomSelect">
												<option selected value="">@lang('website.Choose...')</option>
												<option value="0" @if(!empty(old('gender')) and old('gender')==0) selected @endif)>@lang('website.Male')</option>
												<option value="1" @if(!empty(old('gender')) and old('gender')==1) selected @endif>@lang('website.Female')</option>
											</select>
											<span class="form-text text-muted error-content" hidden>@lang('website.Please select your gender')</span>
										</div>
									</div>
									<div class="from-group mb-3">
										<div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong>@lang('website.Phone Number')</label></div>
										<div class="input-group col-12">
											<input  name="phone" type="text" class="form-control phone-validate" id="phone" placeholder="@lang('website.Please enter your valid phone number')" value="{{ old('phone') }}">
											<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your valid phone number')</span>
										</div>
									</div>
									<div class="from-group mb-3">
										<div class="input-group col-12">
											<input required style="margin:4px;"class="form-controlt checkbox-validate" type="checkbox">
											@lang('website.Creating an account means you are okay with our')  @if(!empty($result['commonContent']['pages'][3]->slug))&nbsp;<a href="{{ URL::to('/page?name='.$result['commonContent']['pages'][3]->slug)}}">@endif @lang('website.Terms and Services')@if(!empty($result['commonContent']['pages'][3]->slug))</a>@endif, @if(!empty($result['commonContent']['pages'][1]->slug))<a href="{{ URL::to('/page?name='.$result['commonContent']['pages'][1]->slug)}}">@endif @lang('website.Privacy Policy')@if(!empty($result['commonContent']['pages'][1]->slug))</a> @endif &nbsp; and &nbsp; @if(!empty($result['commonContent']['pages'][2]->slug))<a href="{{ URL::to('/page?name='.$result['commonContent']['pages'][2]->slug)}}">@endif @lang('website.Refund Policy') @if(!empty($result['commonContent']['pages'][3]->slug))</a>@endif.
											<span class="form-text text-muted error-content" hidden>@lang('website.Please accept our terms and conditions')</span>
										</div>
									</div>

									

							  <div class="col-12 col-sm-12">
								<button type="submit" class="btn btn-light swipe-to-top">@lang('website.Create an Account') </button>
							</div>
						</form>
						</div>
					</div>
					<div class="registration-socials">
						<div class="row align-items-center justify-content-center">
							
								<div class="col-12">
									@lang('website.Access Your Account Through Your Social Networks')
								</div>
								<div class="col-12 right">
									@if($result['commonContent']['setting'][61]->value==1)
										<a href="login/google" type="button" class="btn btn-google"><i class="fab fa-google-plus-g"></i>&nbsp; @lang('website.Google') </a>
									@endif
									@if($result['commonContent']['setting'][2]->value==1)
										<a  href="login/facebook" type="button" class="btn btn-facebook"><i class="fab fa-facebook-f"></i>&nbsp;@lang('website.Facebook')</a>
									@endif

								  </div>
							</div>
						</div>
				  </div>
			</div>
		  </div>

		</div>
	</div>
  </section>