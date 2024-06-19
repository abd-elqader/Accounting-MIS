<div>
    <button data-bs-toggle="dropdown" class="btn btn-primary blue-logo btn-block" aria-expanded="false">@lang('app.actions')
        <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i>
    </button>
    <div class="dropdown-menu">
        
            <a href="{{route('suppliers.show',$model->id)}}" class="dropdown-item">@lang('app.show')</a>
        

            <a href="{{route('suppliers.edit',$model->id)}}" class="dropdown-item">@lang('app.edit')</a>
        

            <button name="delete" data-href="{{route('suppliers.destroy', $model->id)}}" role="button" class="dropdown-item">@lang('app.delete')</button>
        
    </div>
</div>




