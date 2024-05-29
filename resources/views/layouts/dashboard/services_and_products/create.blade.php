@extends('layouts.app')

@section('content')
    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb', [
        'title' => trans('app.services_page_title'),
        'first_list_item' => trans('app.services'),
        'last_list_item' => trans('app.add_service'),
    ])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('services.store') }}" method="post">
                @csrf
                {{-- start services --}}
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-12 col-sm-12"> <!--div-->

                        <div class="card">
                            <div class="card-header">
                                <h3>@lang('app.services')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row row-sm mb-4">
                                    <div class="col-lg">
                                        <div class="main-content-label mg-b-5">@lang('app.name') *</div>
                                        <input class="form-control" name="name" value="{{ old('name') }}"
                                            placeholder="@lang('app.name')" type="text">
                                        @error('name')
                                            <div class="text-danger"> {{ $message }} </div>
                                        @enderror
                                    </div>

                                    <div class="col-lg">

                                        <div class="main-content-label mg-b-5">@lang('app.status') *</div>
                                        <select class="form-control" name="status">
                                            <option value="1" selected>@lang('app.active')</option>
                                            <option value="0">@lang('app.inactive')</option>
                                        </select>

                                        @error('status')
                                            <div class="text-danger"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="row row-sm mb-4">
                                    <div class="col-lg" id="city">
                                        @livewire('location.cities', ['cities_status' => $cities_status])
                                        @error('city_id')
                                            <div class="text-danger"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    {{-- end services --}}

                    {{-- start actons buttons --}}
                    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
                        <div class="card">
                            <div class="card-body">
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
                    </div>
                    {{-- end actions buttons --}}
            </form>
        </div>
    </div>

    <!-- End Row -->
@endsection
