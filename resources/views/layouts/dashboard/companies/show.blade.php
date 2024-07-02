@extends('layouts.app')

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.dashboard.components.breadcrumb',['title' => trans('app.companies_page_title'),'first_list_item' => trans('app.companies'),'last_list_item' => trans('app.show_company')])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <div class="card">
                <div class="card-body">
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.company_name')</div>
                                <label class="form-control">{{$company->name}}</label>
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.commercial_register')</div>
                                <label class="form-control">{{$company->commercial_register}}</label>
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.logo')</div>
                                <label class="form-control">{{$company->logo}}</label>
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.start_of_finanicail_year')</div>
                                <label class="form-control">{{$company->start_of_finanicail_year}}</label>
                            </div>
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.start_of_finanicail_year')</div>
                                <label class="form-control">{{$company->start_of_finanicail_year}}</label>
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
