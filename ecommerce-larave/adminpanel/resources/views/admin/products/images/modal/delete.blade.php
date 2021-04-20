<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="deleteProductImageModalLabel">{{ trans('labels.DeleteImages') }}</h4>
</div>
{!! Form::open(array('url' =>'admin/products/images/deleteproductimage', 'name'=>'deleteImageForm', 'id'=>'deleteImageForm', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
{!! Form::hidden('products_id',  $result['data']['products_id'], array('class'=>'form-control', 'id'=>'products_id')) !!}
{!! Form::hidden('id',  $result['data']['id'], array('class'=>'form-control', 'id'=>'id')) !!}
<div class="modal-body">
    <p>{{ trans('labels.DeleteImagesText') }}</p>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Cancel') }}</button>
        <button type="submit" class="btn btn-primary" >{{ trans('labels.Delete') }}</button>
    </div>
    {!! Form::close() !!}
</div>
