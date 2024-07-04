@extends('layouts.app')

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.dashboard.components.breadcrumb', [
        'title' => trans('app.customer_product_invoice_page_title'),
        'first_list_item' => trans('app.customer_product_invoice'),
        'last_list_item' => trans('app.edit_customer_product_invoice'),
    ])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <form action="{{ route('customer_service_invoices.update', $customerServiceInvoice->id) }}" method="post">

                <div class="card">
                    <div class="card-body">
                        @csrf
                        @method('put')
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.total_invoice') *</div>
                                <input class="form-control" name="total_invoice" value="{{ $customerServiceInvoice->total_invoice}}"
                                    placeholder="@lang('app.total_invoice')" type="text">
                                @error('total_invoice')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>
                            <div class="col-lg">
                                @livewire('dashboard.customer', ['selected_customer' => $customerServiceInvoice->customer_id])
                                @error('customer_id')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.reversed')</div>
                                <input class="form-control" value="{{ $customerServiceInvoice->reversed }}" name="reversed"
                                    placeholder="@lang('app.reversed')" type="text">

                                @error('reversed')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.due_date')</div>
                                <input class="form-control" value="{{ $customerServiceInvoice->due_date }}" name="due_date"
                                    placeholder="@lang('app.due_date')" type="date">
                                @error('due_date')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.creation_date')</div>
                                <input class="form-control" value="{{ $customerServiceInvoice->creation_date }}" name="creation_date"
                                    placeholder="@lang('app.creation_date')" type="date">
                                @error('creation_date')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                    </div>



                    
                </div>

                <!-- start invoice items -->
                <div class="card">
                    <div class="card-header">
                        <div class="mb-3">
                            <button id="add_invoice_item" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('app.add_invoice_item')}}</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3  invoice_items">
                            @forelse ($invoiceItems as $invoiceItem)
                                <!-- start invoice item html -->
                                    <div id="invoice_item" style="display: none !important">
                                        <div class="mb-3 invoice_item">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row mb-3 g-3">
                                                        <div class="col-lg">
                                                            @livewire('dashboard.service', ['field_name'=> 'invoice_items_service_id[]', 'selected_service' => $invoiceItem->service_id])
                                                            @error('invoice_items[0].service_id')
                                                                <div class="text-danger"> {{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg">
                                                            <label>{{ __('app.count') }} *</label>
                                                            <input type="text" name="invoice_items_count[]" class="form-control" value="{{ $invoiceItem->count }}">
                                                            @error("invoice_items[0].count")
                                                                <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-4 invoice_items_buttons">
                                                            <button type="button" class="btn btn-danger remove_invoice_item"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- end invoice item html -->

                            @empty
                                
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- end invoice items -->

                <!-- start invoice taxs -->
                <div class="card">
                    <div class="card-header">
                        <div class="mb-3">
                            <button id="add_invoice_tax" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('app.add_invoice_tax')}}</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3  invoice_taxs">
                            @forelse ($invoiceTaxes as $invoiceTax)
                                
                            @empty
                                
                            @endforelse
                        </div>
                    </div>
                    <div class="card-footer mt-4">
                        <div class="form-group mb-0 mt-3 justify-content-end">
                            <div>
                                <button type="submit" class="btn btn-primary"><i
                                        class="fa fa-save pe-2"></i>@lang('app.submit')</button>

                                <a role="button" href="{{ URL::previous() }}" class="btn btn-primary"><i
                                        class="fa fa-backward pe-2"></i>@lang('app.back')</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end invoice taxs -->
            </form>
        </div>
    </div>

    <!-- End Row -->

@endsection


@section('script')
<!-- start invoice item html -->
<div id="invoice_item" style="display: none !important">
    <div class="mb-3 invoice_item">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3 g-3">
                    <div class="col-lg">
                        @livewire('dashboard.service', ['field_name'=> 'invoice_items_service_id[]'])
                        @error('invoice_items[0].service_id')
                            <div class="text-danger"> {{ $message }}</div>
                        @enderror
                    </div>
                    <!-- <div class="col-lg-4">
                        <label>{{ __('lang.price') }} *</label>
                        <input type="text" name="price[]" class="form-control">
                        @error("invoice_items[0].price")
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div> -->
                    <!-- <div class="col-lg-4">
                        <label>{{ __('app.total_items_cost') }} *</label>
                        <input type="text" name="total_items_cost[]" class="form-control">
                        @error("invoice_items[0].total_items_cost")
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div> -->
                    <div class="col-lg">
                        <label>{{ __('app.count') }} *</label>
                        <input type="text" name="invoice_items_count[]" class="form-control">
                        @error("invoice_items[0].count")
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-4 invoice_items_buttons">
                        <button type="button" class="btn btn-danger remove_invoice_item"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<!-- end invoice item html -->

<!-- start invoice tax html -->
<div id="invoice_tax" style="display: none !important">
    <div class="mb-3 invoice_tax">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3 g-3">
                    <div class="col-lg">
                        @livewire('dashboard.tax', ['field_name'=> 'invoice_taxes_tax_id[]'])
                        @error('invoice_taxes[0].tax_id')
                            <div class="text-danger"> {{ $message }}</div>
                        @enderror
                    </div>                    
                </div>
                <div class="row mb-3 g-3">
                    <div class="invoice_taxs_buttons">
                        <button type="button" class="btn btn-danger remove_invoice_tax"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end invoice tax html -->
<script>
    $(document).ready(function(){
        $('body').on('click', '#create_invoice', function(e){
            e.preventDefault();
            var form = $('#invoice_form');
            var url = form.attr('action');
            var invoice_number = $('#invoice_items_form').val();
            var data = form.serialize();
            $.ajax({
                url:url,
                method:"post",
                data: data,
                beforeSend:function(){
                    $(".load_content").show();
                },
                success:function(responsetext){
                    $(".load_content").hide();
                    $(".alert_message").text('{{ __("lang.success_operation") }}');
                    $(".alert_message").fadeIn().delay(2000).fadeOut();
                },
                error: function(data_error, exception){
                    $(".load_content").hide();
                    if(exception == "error"){
                        $(".alert_message").text(data_error.responseJSON.message);
                        $(".alert_message").fadeIn().delay(2000).fadeOut();
                    }
                }

            });
        });
    });
</script>
<!-- start append invoice item -->
<script>
    $(document).ready(function(){
        $('#add_invoice_item').click(function(){
            var element = $('#invoice_item').html();
            $('.invoice_items').append(element);
        });
        $('.invoice_items').on('click', '.remove_invoice_item', function(){
            var element = $(this).parents('.invoice_item')
            element.remove();
        });
        $('.invoice_items').on('change', 'input[name="invoice_items_count[]"]', function(){
            $(this).prev('input[name="price[]"]').val("10");
        });


    });
</script>
<!-- end append invoice item -->

<!-- start append invoice tax -->
<script>
    $(document).ready(function(){
        $('#add_invoice_tax').click(function(){
            var element = $('#invoice_tax').html();
            $('.invoice_taxs').append(element);
        });
        $('.invoice_taxs').on('click', '.remove_invoice_tax', function(){
            var element = $(this).parents('.invoice_tax')
            element.remove();
        });
        $('#invoice_submit_button').click(function(e){
            e.preventDefault();
            
            var url = $('#invoice_form').attr("action");
            var data = $('#invoice_form').serialize();
            $.ajax({
                url:url,
                method:"post",
                data:data,
                beforeSend:function(){
                    $(".load_content").show();
                },
                success:function(responsetext){
                    // $('.alert_message').removeClass('alert-danger').addClass('alert-success');
                    // $(".load_content").hide();
                    // $(".alert_message").text('{{ __("app.success_operation") }}');
                    // $(".alert_message").fadeIn().delay(2000).fadeOut();
                    $(location).attr('href', "{{ route('customer_service_invoices.index') }}");
                },
                error: function(data_error, exception){
                    $(".load_content").hide();
                    if(exception == "error"){
                        $('.alert_message').removeClass('alert-success').addClass('alert-danger');
                        $(".alert_message").text(data_error.responseJSON.message);
                        $(".alert_message").fadeIn().delay(2000).fadeOut();
                        $(".errors ul").text("");
                        $.each(data_error.responseJSON.errors, function(key, value) {
                            $(".errors ul").append("<li>" + key + ": " + value + "</li>");
                        });
                        $(".errors").show();
                    }
                }
            });
        });

    });
</script>
<!-- end append invoice tax -->
@endsection