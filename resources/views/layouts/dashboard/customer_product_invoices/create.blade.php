@extends('layouts.app')

@section('content')
    {{--    breadcrumb --}}
    @include('layouts.dashboard.components.breadcrumb', [
        'title' => trans('app.customer_product_invoices_page_title'),
        'first_list_item' => trans('app.customer_product_invoice'),
        'last_list_item' => trans('app.add_customer_product_invoice'),
    ])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <form action="{{ route('customer_product_invoices.store') }}" method="post">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.total_invoice') *</div>
                                <input class="form-control" name="total_invoice" value="{{ old('total_invoice') }}"
                                    placeholder="@lang('app.total_invoice')" type="text">
                                @error('total_invoice')
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
                                <div class="main-content-label mg-b-5">@lang('app.reversed')</div>
                                <input class="form-control" value="{{ old('reversed') }}" name="reversed"
                                    placeholder="@lang('app.reversed')" type="text">

                                @error('reversed')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.due_date')</div>
                                <input class="form-control" value="{{ old('due_date') }}" name="due_date"
                                    placeholder="@lang('app.due_date')" type="date">

                                @error('due_date')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.creation_date')</div>
                                <input class="form-control" value="{{ old('creation_date') }}" name="creation_date"
                                    placeholder="@lang('app.creation_date')" type="date">

                                @error('creation_date')
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
