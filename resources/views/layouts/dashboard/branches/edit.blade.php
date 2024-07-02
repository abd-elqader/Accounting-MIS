@extends('layouts.app')

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.dashboard.components.breadcrumb',['title' => trans('app.branches_page_title'),'first_list_item' => trans('app.branches'),'last_list_item' => trans('app.edit_branch')])
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
        <form action="{{route('branches.update', $branch->id)}}" method="post">

            <div class="card">
                <div class="card-body">
                        @csrf
                        @method('put')
                        <div class="row row-sm mb-4">
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.name') *</div>
                                <input class="form-control" name="name" value="{{$branch->name}}" placeholder="@lang('app.name')"
                                       type="text">
                                @error('name')
                                    <div class="text-danger"> {{$message}} </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row row-sm mb-4">

                            <div class="col-lg">
                                @livewire('dashboard.branch-parent' , ['selected_branch' => $branch->id])
                                @error('parent_id')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg">
                                @livewire('dashboard.company', ['selected_company' => $branch->company_id])
                                @error('company_id')
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
