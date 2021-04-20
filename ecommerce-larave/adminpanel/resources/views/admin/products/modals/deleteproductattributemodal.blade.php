<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="deleteProductAttributeModalLabel">{{ trans('labels.DeleteOption') }}</h4>
</div>
{!! Form::open(array('url' =>'admin/products/attach/attribute/default/delete', 'name'=>'deleteattributeform', 'id'=>'deleteattributeform', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
{!! Form::hidden('products_id',  $result['data']['products_id'], array('class'=>'form-control', 'id'=>'products_id')) !!}
{!! Form::hidden('products_attributes_id',  $result['data']['products_attributes_id'], array('class'=>'form-control', 'id'=>'products_attributes_id')) !!}
<div class="modal-body">
    <p>{{ trans('labels.DeleteOptionText') }}</p>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Cancel') }}</button>
        <button type="button" class="btn btn-primary" id="deleteProductAttribute">{{ trans('labels.DeleteOption') }}</button>
    </div>
    {!! Form::close() !!}
</div>
