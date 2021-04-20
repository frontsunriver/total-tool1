<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="editManufacturerLabel">{{ trans('labels.EditOptions') }}</h4>
</div>
  {!! Form::open(array('url' =>'admin/addNewProductAttribute', 'name'=>'editAttributeFrom', 'id'=>'editAttributeFrom', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
		  {!! Form::hidden('products_attributes_id',  $result['data']['products_attributes_id'], array('class'=>'form-control', 'id'=>'products_attributes_id')) !!}
		  {!! Form::hidden('products_id',  $result['data']['products_id'], array('class'=>'form-control', 'id'=>'products_id')) !!}
          {!! Form::hidden('language_id',  $result['data']['language_id'], array('class'=>'form-control', 'id'=>'language_id')) !!}
<div class="modal-body">

		<div class="form-group">
              <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.Language') }} </label>
              <div class="col-sm-10 col-md-8">
                  <select class="form-control edit_additional_language_id" name="languages_id">		
                    <option value="" class="field-validate">Choose Language</option>								 
                     @foreach($result['languages'] as $languages)
                      <option value="{{ $languages->languages_id }}"
                      @if($result['data']['language_id'] == $languages->languages_id)
                        selected
                      @endif
                      >{{ $languages->name }}</option>
                     @endforeach										 
                  </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Chooselagnuage') }}</span>
             
              </div>
          </div>
          
          
  <div class="form-group">
	  <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.OptionName') }}
      </label>
	  <div class="col-sm-10 col-md-8">
		   <select class="form-control edit-additional-option-id field-validate" name="products_options_id">											 
			 @foreach($result['options'] as $options)
			  <option
              @if($result['products_attributes'][0]->options_id == $options->products_options_id)
              	selected
              @endif
               option = "{{ $result['products_attributes'][0]->options_id }}" value="{{ $options->products_options_id }}">{{ $options->products_options_name }}</option>
			 @endforeach										 
		  </select>
      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.OptionNameText') }}</span>
	  </div>
	</div>

   <div class="form-group">
	  <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.OptionValues') }}</label>
	  <div class="col-sm-10 col-md-8">
		  <select class="form-control edit-additional-products_options_values_id field-validate" name="products_options_values_id">	
			 @foreach($result['options_value'] as $options_value)
			  <option
              @if($result['products_attributes'][0]->options_values_id == $options_value->products_options_values_id)
              	selected
              @endif
               option = "{{ $result['products_attributes'][0]->options_values_id }}" value="{{ $options_value->products_options_values_id }}">{{ $options_value->products_options_values_name }}</option>
			 @endforeach										 
		 </select>
         <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.OptionValuesText') }}</span>
	  </div>
	</div>

	<div class="form-group">
	  <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.PricePrefix') }}</label>
	  <div class="col-sm-10 col-md-8">
		 {!! Form::text('price_prefix',  $result['products_attributes'][0]->price_prefix , array('class'=>'form-control', 'id'=>'price_prefix')) !!}
         <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.PricePrefixText') }}</span>
							 
	  </div>
	</div>

	<div class="form-group">
	  <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.Price') }}</label>
	  <div class="col-sm-10 col-md-8">
		 {!! Form::text('options_values_price',  $result['products_attributes'][0]->options_values_price, array('class'=>'form-control', 'id'=>'options_values_price')) !!}
         <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.NumericValueError') }}</span>
	  </div>
	</div>
	<div class="alert alert-danger addError" style="display: none; margin-bottom: 0;" role="alert"><i class="icon fa fa-ban"></i>{{ trans('labels.OpitonExistText') }} </div>
    
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
	<button type="button" class="btn btn-primary" id="updateProductAttribute">{{ trans('labels.UpdateOption') }}</button>
</div>
  {!! Form::close() !!}