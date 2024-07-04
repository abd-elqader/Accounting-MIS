@extends('layouts.app')

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.dashboard.components.breadcrumb',['title' => trans('app.products_page_title'),'first_list_item' => trans('app.products'),'last_list_item' => trans('app.show_product')])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <div class="card">
                <div class="card-body">
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.name')</div>
                                <label class="form-control">{{$product->name}}</label>
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.brand')</div>
                                <label class="form-control">{{$product->brand}}</label>
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.tax')</div>
                                <label class="form-control">{{$product->tax}}</label>
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.stock')</div>
                                <label class="form-control">{{$product->stock}}</label>
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.daily_income')</div>
                                <label class="form-control">{{$product->daily_income}}</label>
                            </div>
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.weekly_income')</div>
                                <label class="form-control">{{$product->weekly_income}}</label>
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.monthly_income')</div>
                                <label class="form-control">{{$product->monthly_income}}</label>
                            </div>
                        </div>


                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.yearly_income')</div>
                                <label class="form-control">{{$product->yearly_income}}</label>
                            </div>
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.category_id')</div>
                                <label class="form-control">{{$product->category_id}}</label>
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.department_id')</div>
                                <label class="form-control">{{$product->department_id}}</label>
                            </div>
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.description')</div>
                                <label class="form-control">{{$product->description}}</label>
                            </div>
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.taxable')</div>
                                <label class="form-control">{{$product->taxable}}</label>
                            </div>
                        </div>


                        <div class="row row-sm mb-4">
                            @forelse ($unit_prices as $unit_price)
                                <div class="col-lg">
                                    <div class="main-content-label mg-b-5">@lang('app.unit_price')</div>
                                    <label class="form-control">{{$unit_price->price}}</label>
                                </div>
                            @empty
                                no unit prices
                            @endforelse
                            
                            
                        </div>

                </div>
            </div>
            <div class="card">
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
