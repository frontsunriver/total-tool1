@if($result['products']['success']==1)
	@foreach($result['products']['product_data'] as $key=>$products)
	<div class="col-12 griding" >
		@include('web.common.product')
	</div>

    @endforeach
    <input id="filter_total_record" type="hidden" value="{{$result['products']['total_record']}}">

    @if(count($result['products']['product_data'])> 0 and $result['limit'] > $result['products']['total_record'])
		<style>
			#load_products{
				display: none;
			}
			#loaded_content{
				display: block !important;
			}
			#loaded_content_empty{
				display: none !important;
			}
        </style>
    @endif
    @elseif(count($result['products']['product_data'])==0 or $result['products']['success']==0)
		<style>
            #load_products{
                display: none;
            }
            #loaded_content{
                display: none !important;
            }
            #loaded_content_empty{
                display: block !important;
            }
        </style>
    @endif
