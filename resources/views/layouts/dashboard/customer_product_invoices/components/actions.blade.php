<div>
    <button data-bs-toggle="dropdown" class="btn btn-primary blue-logo btn-block" aria-expanded="false">@lang('app.actions')
        <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i>
    </button>
    <div class="dropdown-menu">
        
            <a href="{{route('customer_product_invoices.show',$model->id)}}" class="dropdown-item">@lang('app.show')</a>
        

            <a href="{{route('customer_product_invoices.edit',$model->id)}}" class="dropdown-item">@lang('app.edit')</a>
        

            <button name="delete" data-href="{{route('customer_product_invoices.destroy', $model->id)}}" role="button" class="dropdown-item">@lang('app.delete')</button>
        
    </div>
</div>




