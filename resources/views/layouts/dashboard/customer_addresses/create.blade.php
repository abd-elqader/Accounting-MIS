@extends('layouts.app')

@section('content')
    {{--    breadcrumb --}}
    @include('layouts.dashboard.components.breadcrumb', [
        'title' => trans('app.customer_addresses_page_title'),
        'first_list_item' => trans('app.customer_addresses'),
        'last_list_item' => trans('app.add_customer_addresses'),
    ])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <form action="{{ route('customer_addresses.store') }}" method="post">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.type') *</div>
                                <select class="form-control" name="type">
                                    <option value="{{ \App\Enum\AddressTypeEnum::HOME}}">@lang('app.home')</option>
                                    <option value="{{ \App\Enum\AddressTypeEnum::WORK}}">@lang('app.work')</option>
                                    <option value="{{ \App\Enum\AddressTypeEnum::COMUNICATION}}">@lang('app.comunication')</option>
                                </select>
                                @error('type')
                                    <div class="text-danger"> {{ $message }} </div>
                                @enderror
                            </div>
                            <div class="col-lg">
                                @livewire('dashboard.customer')
                                @error('customer_id')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.postal_code')</div>
                                <input class="form-control" value="{{ old('postal_code') }}" name="postal_code"
                                    placeholder="@lang('app.postal_code')" type="text">

                                @error('postal_code')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.description')</div>
                                <input class="form-control" value="{{ old('description') }}" name="description"
                                    placeholder="@lang('app.description')" type="text">

                                @error('description')
                                    <div class="text-danger"> {{ $message }}</div>
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
