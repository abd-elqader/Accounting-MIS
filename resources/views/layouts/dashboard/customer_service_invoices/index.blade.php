@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endsection

@section('content')
    {{--    breadcrumb --}}
    @include('layouts.dashboard.components.breadcrumb', [
        'title' => trans('app.customer_service_invoices_page_title'),
        'first_list_item' => trans('app.customer_service_invoices'),
        'last_list_item' => trans('app.all_customer_service_invoices'),
    ])
    {{--    end breadcrumb --}}


    <!--start filters section -->
    @include('layouts.dashboard.customer_service_invoices.components.filters')
    <!--end filterd section -->
    <!--Row-->
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <a class="btn btn-primary" href="{{ route('customer_service_invoices.create') }}"><i
                                    class="fe fe-plus me-2"></i>@lang('app.new')</a>
                            <div class="btn-group ms-2 mt-2 mb-2">
                                <div class="dropdown">
                                    <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary"
                                        data-bs-toggle="dropdown" id="dropdownMenuButton" type="button">@lang('app.actions')
                                        <i class="fas fa-caret-down ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow: auto">
                        {!! $dataTable->table(['class' => 'table-data table table-bordered text-nowrap border-bottom']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}
@endsection
