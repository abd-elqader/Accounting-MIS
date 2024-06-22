@extends('layouts.app')

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.dashboard.components.breadcrumb',['title' => trans('app.suppliers_page_title'),'first_list_item' => trans('app.suppliers'),'last_list_item' => trans('app.edit_country')])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
        <form action="{{route('suppliers.update', $supplier->id)}}" method="post">

            <div class="card">
                <div class="card-body">
                        @csrf
                        @method('put')
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.contact_name') *</div>
                                <input class="form-control" name="contact_name" value="{{$supplier->contact_name}}" placeholder="@lang('app.supplier_name')"
                                       type="text">
                                @error('contact_name')
                                    <div class="text-danger"> {{$message}} </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.iban')</div>
                                <input class="form-control" value="{{$supplier->iban}}" name="iban"
                                       placeholder="@lang('app.iban')" type="text">

                                @error('iban')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.commercial_register')</div>
                                <input class="form-control" value="{{$supplier->commercial_register}}" name="commercial_register"
                                       placeholder="@lang('app.commercial_register')" type="text">
                                @error('commercial_register')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>  

                        </div>
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.company_name')</div>
                                <input class="form-control" value="{{$supplier->company_name}}" name="company_name"
                                       placeholder="@lang('app.company_name')" type="text">

                                @error('company_name')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.monthly_expenses')</div>
                                <input class="form-control" value="{{$supplier->monthly_expenses}}" name="monthly_expenses"
                                       placeholder="@lang('app.monthly_expenses')" type="text">
                                @error('monthly_expenses')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>  

                        </div>
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.monthly_income')</div>
                                <input class="form-control" value="{{$supplier->monthly_income}}" name="monthly_income"
                                       placeholder="@lang('app.monthly_income')" type="text">

                                @error('monthly_income')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.tax_number')</div>
                                <input class="form-control" value="{{$supplier->tax_number}}" name="tax_number"
                                       placeholder="@lang('app.tax_number')" type="text">
                                @error('tax_number')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>  

                        </div>
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.taxable')</div>
                                <input class="form-control" value="{{$supplier->taxable}}" name="taxable"
                                       placeholder="@lang('app.taxable')" type="text">

                                @error('taxable')
                                <div class="text-danger"> {{$message}}</div>
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
