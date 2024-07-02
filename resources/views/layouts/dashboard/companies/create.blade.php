@extends('layouts.app')

@section('content')
    {{--    breadcrumb --}}
    @include('layouts.dashboard.components.breadcrumb', [
        'title' => trans('app.companies_page_title'),
        'first_list_item' => trans('app.companies'),
        'last_list_item' => trans('app.add_branch'),
    ])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <form action="{{ route('companies.store') }}" method="post">
                <div class="card">
                    <div class="card-body">
                        @csrf
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
                                <div class="main-content-label mg-b-5">@lang('app.commercial_register') *</div>
                                <input class="form-control" name="commercial_register" value="{{ old('commercial_register') }}"
                                    placeholder="@lang('app.commercial_register')" type="text">
                                @error('commercial_register')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.logo') *</div>
                                <input class="form-control" name="logo" value="{{ old('logo') }}"
                                    placeholder="@lang('app.logo')" type="text">
                                @error('logo')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.start_of_finanicail_year') *</div>
                                <input class="form-control" name="start_of_finanicail_year" value="{{ old('start_of_finanicail_year') }}"
                                    placeholder="@lang('app.start_of_finanicail_year')" type="date">
                                @error('start_of_finanicail_year')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.end_of_financial_year') *</div>
                                <input class="form-control" name="end_of_financial_year" value="{{ old('end_of_financial_year') }}"
                                    placeholder="@lang('app.end_of_financial_year')" type="date">
                                @error('end_of_financial_year')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>

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
            </form>
        </div>
    </div>

    <!-- End Row -->
@endsection
