@extends('layouts.app')

@section('content')
    {{--    breadcrumb --}}
    @include('layouts.dashboard.components.breadcrumb', [
        'title' => trans('app.supplier_service_invoice_taxes_page_title'),
        'first_list_item' => trans('app.supplier_service_invoice_tax'),
        'last_list_item' => trans('app.add_supplier_service_invoice_tax'),
    ])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <form action="{{ route('supplier_service_invoice_taxes.store') }}" method="post">
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
                                @livewire('dashboard.supplier-service-invoice')
                                @error('SSI_id')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.value')</div>
                                <input class="form-control" value="{{ old('value') }}" name="value"
                                    placeholder="@lang('app.value')" type="text">

                                @error('value')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.type')</div>
                                <input class="form-control" value="{{ old('type') }}" name="type"
                                    placeholder="@lang('app.type')" type="text">

                                @error('type')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>
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
