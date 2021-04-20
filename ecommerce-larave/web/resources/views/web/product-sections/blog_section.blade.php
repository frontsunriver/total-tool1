
  @if(!empty($result['news']['news_data']))
  <section class="pro-content pro-blog">
    <div class="container">
      <div class="row justify-content-center">
          <div class="col-12 col-lg-6">
            <div class="pro-heading-title">
                <h2> @lang('website.From our News') 
                </h2>
                <p>@lang('website.From our News Text') 
                </p>
            </div>
          </div>
      </div>
    </div>
    <div class="general-product">
      <div class="container  p-0">
          <div class="blog-carousel-js">
             @foreach($result['news']['news_data'] as $key=>$news_data)

             <div class="">
							<div class="blog">
							  <div class="blog-thumbnail">
                    <span class="date-tag badge">{{date('d-M-Y', strtotime($news_data->created_at))}}</span>
                    <a href="{{ URL::to('/news-detail/'.$news_data->news_slug)}}">
                      <img class="img-thumbnail" src="{{asset('').$news_data->image_path}}" width="100%" alt="{{$news_data->news_name}}">
                    </a>
                    <div class="over"></div>
							  </div>
							  <div class="blog-detial">
								  <span class="tag">
									 {{$news_data->categories_name}}                              
								  </span>
								  <h5><a href="{{ URL::to('/news-detail/'.$news_data->news_slug)}}">
									{{$news_data->news_name}}</a>
								  </h5>
								
									  <div class="blog-description">
                      <p>
                      <?php
                        $descriptions = strip_tags($news_data->news_description);
                        echo stripslashes($descriptions);
                      ?>
                      </p>
									  </div>
									  <span class="blink"><a href="{{ URL::to('/news-detail/'.$news_data->news_slug)}}"> @lang('website.Read More') .. </a></span>
							  </div>
							 
							</div>
						</div>
              @endforeach

              
              
          </div>  
      </div>
    </div>  
</section>
@endif