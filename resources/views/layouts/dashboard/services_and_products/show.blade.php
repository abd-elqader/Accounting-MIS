@extends('layouts.app')

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => trans('locations_page_title'),'first_list_item' => trans('app.locations'),'last_list_item' => trans('app.add_locations')])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <div class="card">
                <div class="card-body">
                    <div class="row row-sm mb-4">
                        <div class="col-lg">
                            <div class="main-content-label mg-b-5">@lang('app.title')</div>
                            <label class="form-control">{{ $service->name }}</label>
                        </div>

                         <div class="col-lg">
                            <div class="main-content-label mg-b-5">@lang('app.status')</div>
                            <label class="form-control">{{ $service->status }}</label>
                        </div>

                        {{-- <div class="col-lg">
                            <div class="main-content-label mg-b-5">@lang('app.number_of_parts')</div>
                            <label class="form-control">{{ $location->areas->count() ?? ""}}</label>
                        </div>

                        <div class="col-lg">
                            <div class="main-content-label mg-b-5">@lang('app.name of parent')</div>
                            <label class="form-control">{{$location->city->title ?? "don't have one"}}</label>
                        </div> --}}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- End Row -->

@endsection
