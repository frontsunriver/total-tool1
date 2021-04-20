<div class="modal-dialog " role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="bankinfoModalLabel">{{ trans('labels.Bank Info') }}</h4>
        </div>
        {!! Form::open(array('url' =>'admin/deliveryboys/withdraw/pay', 'name'=>'payform', 'id'=>'payform', 'method'=>'post',
        'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
        {!! Form::hidden('payment_withdraw_id', $data['withdraw']->payment_withdraw_id, array('class'=>'form-control', 'id'=>'payments_id')) !!}
        <div class="modal-body">
            <div class="table-responsive ">
                <table class="table">
                    <tbody>
                        
                        <tr>
                            <th class="text-right" width="50%">{{ trans('labels.Account Title') }}</th>
                            <td class="text-left">{{$data['deliveryboys']->bank_name}}</td>
                        </tr>
                        <tr>
                            <th class="text-right">{{ trans('labels.Account Number') }}</th>
                            <td class="text-left">{{$data['deliveryboys']->bank_account_number}}</td>
                        </tr>
                        <tr>
                            <th class="text-right">{{ trans('labels.Routing Number') }}</th>
                            <td class="text-left">{{$data['deliveryboys']->bank_routing_number}}</td>
                        </tr>
                        <tr>
                            <th class="text-right">{{ trans('labels.IBAN') }}</th>
                            <td class="text-left">{{$data['deliveryboys']->bank_iban}}</td>
                        </tr>
                        <tr>
                            <th class="text-right">{{ trans('labels.Swift') }}</th>
                            <td class="text-left">{{$data['deliveryboys']->bank_swift}}</td>
                        </tr>
                        <tr>
                            <th class="text-right">{{ trans('labels.Amount') }}</th>
                            <td class="text-left">{{$data['setting'][19]->value}}{{ $data['withdraw']->amount }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">{{ trans('labels.Bank Address') }}</th>
                            <td class="text-left">{{$data['deliveryboys']->bank_address}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
            
        </div>
        {!! Form::close() !!}
    </div>
</div>