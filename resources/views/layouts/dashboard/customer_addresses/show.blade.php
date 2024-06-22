@extends('layouts.app')

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.dashboard.components.breadcrumb',['title' => trans('app.customer_addresses_page_title'),'first_list_item' => trans('app.customer_addresses'),'last_list_item' => trans('app.show_customer_addresses')])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <div class="card">
                <div class="card-body">
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.type')</div>
                                <label class="form-control">{{$customerAddresses->type}}</label>
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.customer_id')</div>
                                <label class="form-control">{{$customerAddresses->customer_id}}</label>
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.postal_code')</div>
                                <label class="form-control">{{$customerAddresses->postal_code}}</label>
                            </div>
                        </div>
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.description')</div>
                                <label class="form-control">{{$customerAddresses->description}}</label>
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
