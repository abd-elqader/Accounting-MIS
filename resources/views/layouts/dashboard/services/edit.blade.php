@extends('layouts.app')

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.dashboard.components.breadcrumb',['title' => trans('app.services_page_title'),'first_list_item' => trans('app.services'),'last_list_item' => trans('app.edit_service')])
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
        <form action="{{route('services.update', $service->id)}}" method="post">

            <div class="card">
                <div class="card-body">
                        @csrf
                        @method('put')
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.service_name') *</div>
                                <input class="form-control" name="name" value="{{$service->name}}" placeholder="@lang('app.service_name')"
                                       type="text">
                                @error('name')
                                    <div class="text-danger"> {{$message}} </div>
                                @enderror
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.brand') *</div>
                                <input class="form-control" value="{{$service->brand}}" name="brand" placeholder="@lang('app.service_phone')"
                                       type="text">
                                @error('brand')
                                    <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.tax')</div>
                                <input class="form-control" value="{{$service->tax}}" name="tax" placeholder="@lang('app.service_phone')"
                                       type="text">
                                @error('tax')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.stock')</div>
                                <input class="form-control" value="{{$service->stock}}" name="stock"
                                       placeholder="@lang('app.stock')" type="text">

                                @error('stock')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.daily_income')</div>
                                <input class="form-control" value="{{$service->daily_income}}" name="daily_income"
                                       placeholder="@lang('app.daily_income')" type="text">

                                @error('daily_income')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.weekly_income')</div>
                                <input class="form-control" value="{{$service->weekly_income}}" name="weekly_income" placeholder="@lang('app.weekly_income')"
                                       type="text">

                                @error('weekly_income')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row row-sm mb-4">

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.monthly_income')</div>
                                <input class="form-control" value="{{$service->monthly_income}}" name="monthly_income" placeholder="@lang('app.monthly_income')"
                                       type="text">

                                @error('monthly_income')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.yearly_income')</div>
                                <input class="form-control" value="{{$service->yearly_income}}" name="yearly_income" placeholder="@lang('app.yearly_income')"
                                       type="text">

                                @error('yearly_income')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            <div class="col-lg-12">
                                <div class="main-content-label mg-b-5">@lang('app.description') *</div>
                                <textarea name="description" class="form-control">{{$service->description}}</textarea>
                                @error('description')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input name="taxable" class="form-check-input" type="checkbox" value="1" id="flexSwitchCheckChecked" @if($service->taxable) checked @endif>
                                <label class="form-check-label" for="flexSwitchCheckChecked">@lang('app.taxable')</label>
                            </div>
                        </div>

                        <hr>
                        <div class="row row-sm mb-4">
                            {{-- start the product unit prices --}}
                            <div class="mb-3  product-unit-prices">
                                <div class="mb-3">
                                    <button id="add-product-unit-price" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('app.add_unit_price')}}</button>
                                </div>

                                

                                @forelse ($unit_prices as $unit_price)
                                    <div class="mb-3 unit-price">
                                        <div class="card">
                                            <div class="card-body">
                                                {{-- start update form --}}
                                                <div class="row mb-3 g-3">
                                                    <div class="col-lg-4">
                                                        <label>{{ __('app.price') }} *</label>
                                                        <input type="text" name="unit_prices_price[]" class="form-control" value="{{$unit_price->price}}">
                                                        @error("unit_prices[0].price")
                                                            <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg">
                                                        @livewire('dashboard.currency', ['field_name'=> 'unit_prices_currency_id[]', 'selected_currency' => $unit_price->currency_id])
                                                        @error('unit_prices[0].currency_id')
                                                            <div class="text-danger"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-3 g-3">
                                                    <div class="unit-price-buttons">
                                                        <button type="button" class="btn btn-danger remove-unit-price"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                                {{-- end update form --}}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    no unit prices
                                @endforelse
                                
                                
                            </div>
                            {{-- end the product unit prices --}}
                        </div>

                </div>
            </div>
            <div class="card">
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
        </form>
        </div>
    </div>

    <!-- End Row -->

@endsection


@section('script')
<!-- start unit prices html -->
<div id="unit_price" style="display: none !important">
    <div class="mb-3 unit-price">
        <div class="card">
            <div class="card-body">
                {{-- start update form --}}
                <div class="row mb-3 g-3">
                    <div class="col-lg-4">
                        <label>{{ __('app.price') }} *</label>
                        <input type="text" name="unit_prices_price[]" class="form-control">
                        @error("unit_prices[0].price")
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg">
                        @livewire('dashboard.currency', ['field_name'=> 'unit_prices_currency_id[]'])
                        @error('unit_prices[0].currency_id')
                            <div class="text-danger"> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3 g-3">
                    <div class="unit-price-buttons">
                        <button type="button" class="btn btn-danger remove-unit-price"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
                {{-- end update form --}}
            </div>
        </div>
    </div>
</div>
<!-- end unit prices html -->

<script>
    $(document).ready(function(){
        $('#add-product-unit-price').click(function(){
            var element = $('#unit_price').html();
            $('.product-unit-prices').append(element);
        });
        $('.product-unit-prices').on('click', '.remove-unit-price', function(){
            var element = $(this).parents('.unit-price')
            element.remove();
        });
        $('#product_submit_button').click(function(e){
            e.preventDefault();
            var url = $('#product_form').attr("action");
            var data = $('#product_form').serialize();
            $.ajax({
                url:url,
                method:"post",
                data:data,
                beforeSend:function(){
                    $(".load_content").show();
                },
                success:function(responsetext){
                    $(".load_content").hide();
                    $(".alert_message").text('{{ __("lang.success_operation") }}');
                    $(".alert_message").fadeIn().delay(2000).fadeOut();
                    $(location).attr('href', "{{ route('products.index') }}");
                },
                error: function(data_error, exception) {
                    $(".load_content").hide();
                    if(exception == "error"){
                        $(".errors ul").text("");
                        console.log($(".errors ul"));
                        $.each(data_error.responseJSON.errors, function(key, value) {
                            $(".errors ul").append("<li>" + key + ": " + value + "</li>");
                        });
                        $('.errors').show();
                    }
                }
            });
        });

    });
</script>

@endsection