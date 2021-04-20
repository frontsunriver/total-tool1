
<script type="text/javascript">
window.onload = function() {


}
jQuery(document).on('click', '#apply_options_btn', function(e){
	if (jQuery('input:checkbox.filters_box:checked').length > 0) {
      	jQuery('#filters_applied').val(1);
		jQuery('#apply_options_btn').removeAttr('disabled');
	} else {
      	jQuery('#filters_applied').val(0);
		jQuery('#apply_options_btn').attr('disabled',true);
    }
	jQuery('#load_products_form').submit();
	jQuery('#test').submit();

})


//sortby
document.getElementById('sortbytype').addEventListener('change',function(){
	jQuery("#load_products_form").submit();

});

//sortby
document.getElementById('sortbylimit').addEventListener('change',function(){
	jQuery("#load_products_form").submit();

});

//Display grid/list 3 Column
jQuery(document).ready(function () {

	
    jQuery('#list').on('click', function(){
		jQuery( '#products_style' ).val( 'list' );
        jQuery( '#swap .col-12' ).removeClass( 'griding' );
        jQuery( '#swap .col-12' ).removeClass( 'col-lg-4' );
        jQuery( '#swap .col-12' ).removeClass( 'col-sm-6' );
		jQuery( '#swap .col-12' ).addClass( 'listing' );	
		

		jQuery( '#swap2 .col-12' ).removeClass( 'griding' );
        jQuery( '#swap2 .col-12' ).removeClass( 'col-md-6' );
		jQuery( '#swap2 .col-12' ).removeClass( 'col-lg-3' );
		jQuery( '#swap2 .col-12' ).addClass( 'listing' );

        jQuery( this ).addClass( 'active' );
		jQuery( '#grid' ).removeClass( 'active' );
				<?php foreach($result['products']['product_data'] as $key=>$products){ ?>

					jQuery( '#cart_button<?php echo $products->products_id; ?>' ).show();
					jQuery( '#view_button<?php echo $products->products_id; ?>' ).show();
					jQuery( '#added_button<?php echo $products->products_id; ?>' ).show();
					jQuery( '#cart_button2<?php echo $products->products_id; ?>' ).show();
					jQuery( '#view_button2<?php echo $products->products_id; ?>' ).show();
					jQuery( '#added_button2<?php echo $products->products_id; ?>' ).show();
					jQuery( '#out_button<?php echo $products->products_id; ?>' ).show();

				<?php }?>
    });
    jQuery('#grid').on('click', function(){

		jQuery( '#products_style' ).val( 'grid' );
		
        jQuery( '#swap .col-12' ).removeClass( 'listing' );
        jQuery( '#swap .col-12' ).addClass( 'col-lg-4' );
        jQuery( '#swap .col-12' ).addClass( 'col-sm-6' );
        
		jQuery( '#swap .col-12' ).addClass( 'griding' );
		
		

		jQuery( '#swap2 .col-12' ).addClass( 'griding' );
        jQuery( '#swap2 .col-12' ).addClass( 'col-md-6' );
		jQuery( '#swap2 .col-12' ).addClass( 'col-lg-3' );
		jQuery( '#swap2 .col-12' ).removeClass( 'listing' );

		jQuery( this ).addClass( 'active' );
        jQuery( '#list' ).removeClass( 'active' );
<?php foreach($result['products']['product_data'] as $key=>$products){ ?>

				jQuery( '#cart_button<?php echo $products->products_id; ?>' ).hide();
				jQuery( '#view_button<?php echo $products->products_id; ?>' ).hide();
				jQuery( '#added_button<?php echo $products->products_id; ?>' ).hide();
				jQuery( '#cart_button2<?php echo $products->products_id; ?>' ).hide();
				jQuery( '#view_button2<?php echo $products->products_id; ?>' ).hide();
				jQuery( '#added_button2<?php echo $products->products_id; ?>' ).hide();
				jQuery( '#out_button<?php echo $products->products_id; ?>' ).hide();

<?php }?>


    });


});

//load more products
	jQuery(document).on('click', '#load_products', function(e){
	// jQuery('#loader').css('display','flex');
		$('#load_products').html("<img src='{{ asset('web/images/miscellaneous/ajax-loader.gif') }}' /> ");
		setTimeout(() => {
			var page_number = jQuery('#page_number').val();
			var total_record = jQuery('#total_record').val();
			var products_style = jQuery('#products_style').val();
			var pagelayout = jQuery('#pagelayout').val();
			
			var formData = jQuery("#load_products_form").serialize();
			jQuery.ajax({
			headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
				url: '{{ URL::to("/filterProducts")}}',
				type: "POST",
				data: formData,
				success: function (res) {
					if(jQuery.trim().res==0){
						jQuery('#load_products').hide();
						jQuery('#loaded_content').show();
					}else{
						page_number++;
						jQuery('#page_number').val(page_number);
						jQuery('#swap .row').append(res);
						jQuery('#swap2 .row').append(res);
						var record_limit = jQuery('#record_limit').val();
						var showing_record = page_number*record_limit;
						if(total_record<=showing_record){
							jQuery('.showing_record').html(total_record);
							jQuery('#load_products').hide();
							jQuery('#loaded_content').show();
						}else{
							jQuery('.showing_record').html(showing_record);
						}
					}

					
					if(pagelayout !== undefined){
						if(products_style == 'list'){
							jQuery( '#swap2 .col-12' ).removeClass( 'griding' );
							jQuery( '#swap2 .col-12' ).removeClass( 'col-md-6' );
							jQuery( '#swap2 .col-12' ).removeClass( 'col-lg-3' );
							jQuery( '#swap2 .col-12' ).addClass( 'listing' );

						}else{
							jQuery( '#swap2 .col-12' ).addClass( 'griding' );
							jQuery( '#swap2 .col-12' ).addClass( 'col-md-6' );
							jQuery( '#swap2 .col-12' ).addClass( 'col-lg-3' );
							jQuery( '#swap2 .col-12' ).removeClass( 'listing' );
						}
					}else{
						if(products_style == 'list'){
							jQuery( '#swap .col-12' ).removeClass( 'griding' );
							jQuery( '#swap .col-12' ).removeClass( 'col-lg-4' );
							jQuery( '#swap .col-12' ).removeClass( 'col-sm-6' );
							jQuery( '#swap .col-12' ).addClass( 'listing' );

						}else{
							jQuery( '#swap .col-12' ).removeClass( 'listing' );
							jQuery( '#swap .col-12' ).addClass( 'col-lg-4' );
							jQuery( '#swap .col-12' ).addClass( 'col-sm-6' );				
							jQuery( '#swap .col-12' ).addClass( 'griding' );
						}
					}

					

					$('#load_products').html('Load More');
				},
			});
		}, 300);
	});


</script>
