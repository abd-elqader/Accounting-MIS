@extends('layouts.app')

@section('content')
    {{--    breadcrumb --}}
    @include('layouts.dashboard.components.breadcrumb', [
        'title' => trans('app.supplier_product_invoice_items_page_title'),
        'first_list_item' => trans('app.supplier_product_invoice_items'),
        'last_list_item' => trans('app.show_supplier_product_invoice_items'),
    ])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <div class="card">
                <div class="card-body">
                    <div class="row row-sm mb-4">
                        <div class="col-lg">
                            <div class="main-content-label mg-b-5">@lang('app.count')</div>
                            <label class="form-control">{{ $supplierProductInvoiceItem->count }}</label>
                        </div>
                    </div>

                    <div class="row row-sm mb-4">
                        <div class="col-lg">
                            <div class="main-content-label mg-b-5">@lang('app.price')</div>
                            <label class="form-control">{{ $supplierProductInvoiceItem->price }}</label>
                        </div>

                        <div class="col-lg">
                            <div class="main-content-label mg-b-5">@lang('app.total_items_cost')</div>
                            <label class="form-control">{{ $supplierProductInvoiceItem->total_items_cost }}</label>
                        </div>
                        
                        <div class="col-lg">
                            <div class="main-content-label mg-b-5">@lang('app.product_id')</div>
                            <label class="form-control">{{ $supplierProductInvoiceItem->product_id }}</label>
                        </div>

                        <div class="col-lg">
                            <div class="main-content-label mg-b-5">@lang('app.supplier_product_invoice_id')</div>
                            <label class="form-control">{{ $supplierProductInvoiceItem->SPI_id }}</label>
                        </div>
                    </div>
                </div>

                <div class="card-footer mt-4">
                    <div class="form-group mb-0 mt-3 justify-content-end">
                        <div>
                            <a role="button" href="{{ URL::previous() }}" class="btn btn-primary"><i
                                    class="fa fa-backward pe-2"></i>@lang('app.back')</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- End Row -->
@endsection
