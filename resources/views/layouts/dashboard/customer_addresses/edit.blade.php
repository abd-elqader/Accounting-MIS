@extends('layouts.app')

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.dashboard.components.breadcrumb',['title' => trans('app.customer_addresses_page_title'),'first_list_item' => trans('app.customer_address_addresses'),'last_list_item' => trans('app.edit_country')])
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
        <form action="{{route('customer_addresses.update', $customer_address->id)}}" method="post">

            <div class="card">
                <div class="card-body">
                        @csrf
                        @method('put')
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.type') *</div>
                                <input class="form-control" name="type" value="{{$customer_address->type}}" placeholder="@lang('app.type')"
                                       type="text">
                                @error('type')
                                    <div class="text-danger"> {{$message}} </div>
                                @enderror
                            </div>
                            <div class="col-lg">
                                @livewire('dashboard.customer', ['selected_customer' => $customer_address->customer_id])
                                @error('customer_id')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.postal_code')</div>
                                <input class="form-control" value="{{$customer_address->postal_code}}" name="postal_code"
                                       placeholder="@lang('app.postal_code')" type="text">

                                @error('postal_code')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.description')</div>
                                <input class="form-control" value="{{$customer_address->description}}" name="description"
                                       placeholder="@lang('app.description')" type="text">
                                @error('description')
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
