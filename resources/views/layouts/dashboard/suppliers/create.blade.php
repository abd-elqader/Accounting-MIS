@extends('layouts.app')

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => trans('app.users_page_title'),'first_list_item' => trans('app.users'),'last_list_item' => trans('app.add_user')])
    {{--    end breadcrumb --}}

    <!-- Row -->
    <div class="row">

        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"> <!--div-->
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-2">
                            <ul style="margin-bottom: 0rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('users.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row row-sm mb-4">

                            {{-- name --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.name') *</div>
                                    <input class="form-control" name="name" value="{{old('name')}}" placeholder="@lang('app.name')"
                                           type="text">
                                    @error('name')
                                        <div class="text-danger"> {{$message}} </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- email --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.email') *</div>
                                    <input class="form-control" value="{{old('email')}}" name="email" placeholder="@lang('app.email')"
                                           type="email">
                                    @error('email')
                                        <div class="text-danger"> {{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- phone --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.phone') *</div>
                                    <input class="form-control" value="{{old('phone')}}" name="phone"
                                           placeholder="@lang('app.phone')" type="text">

                                    @error('phone')
                                    <div class="text-danger"> {{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row row-sm mb-4">

                            {{-- profile image --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.profile_image')</div>
                                    <input class="form-control" value="{{old('profile_image')}}" name="profile_image"
                                           placeholder="@lang('app.profile_image')" type="file">
                                    @error('profile_image')
                                    <div class="text-danger"> {{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- password --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.password') *</div>
                                    <input class="form-control" value="{{old('password')}}" name="password" placeholder="@lang('app.password')"
                                           type="password">
                                    @error('password')
                                    <div class="text-danger"> {{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- confirmation password --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.password_confirmation') *</div>
                                    <input class="form-control" value="{{old('password_confirmation')}}" name="password_confirmation" placeholder="@lang('app.password_confirmation')"
                                           type="password">
                                    @error('password')
                                    <div class="text-danger"> {{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row row-sm mb-4">

                            {{-- type --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.type') *</div>
                                    <select class="form-control" name="type" id="type">
                                        @foreach (App\Enums\UsersType::options() as $name=>$value)
                                        <option value="{{ $value }}" {{ old("type") == $value ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>

                                    @error('type')
                                    <div class="text-danger"> {{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- role --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.role') *</div>
                                    <select class="form-control" name="role">
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ old("role") == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('type')
                                    <div class="text-danger"> {{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            {{-- city --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    @livewire('location.cities', ['selected_city'=>old('city_id'), 'status' => $status])
                                    @error('city_id')
                                        <div class="text-danger"> {{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- area --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    @livewire('location.areas', ["areas_for_city_id" => old('city_id'),'selected_area'=>old('area_id'), 'status' => $status])
                                    @error('area_id')
                                        <div class="text-danger"> {{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- subarea
                            <div class="col-lg">
                                <div class="form-group">
                                    @livewire('location.subareas', ["areas_for_city_id" => old('city_id'),'selected_area'=>old('subarea_id'), 'status' => $status])
                                    @error('area_id')
                                        <div class="text-danger"> {{$message}}</div>
                                    @enderror
                                </div>
                            </div> --}}
                        
                        </div>

                        <div class="row row-sm mb-4">

                            {{-- service locations --}}
                            <div class="col-lg fields" id="service-locations">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">Select Service Locations</div>
                                    <select class="js-example-basic-multiple form-control form-select" name="service_location_ids[]" multiple="multiple" size="3">
                                        @foreach ($locations as $location)
                                        <option value="{{ $location->id }}" {{ in_array($location->id, old('service_location_ids', [])) ? 'selected' : '' }}>{{ $location->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Office --}}
                            <div class="col-lg fields" id="office">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">Select Office</div>
                                    <select id="Offices" class="options form-control" name="office_id">
                                        @foreach ($offices as $office)
                                        <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row row-sm mb-4">

                            {{-- company --}}
                            <div class="col-lg conditional-fields" id="company">
                                @livewire('company', ['selected_company'=>old('company_id'), 'status' => $status])
                                @error('company_id')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            {{-- branch --}}
                            <div class="col-lg conditional-fields" id="branch">
                                @livewire('branch', ['selected_branch'=>old('branch_id'), 'branches_for_company_id' => old('company_id'),'status' => $status])
                                @error('branch_id')
                                    <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            {{-- department --}}
                            <div class="col-lg conditional-fields" id="department">
                                @livewire('department', ['selected_department'=>old('department_id') ,'status' => $status])
                                @error('department_id')
                                    <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>

                            {{-- geid --}}
                            <div class="col-lg conditional-fields">
                                <div class="form-group showSelect">
                                    <div class="main-content-label mg-b-5">@lang('app.geid') *</div>
                                    <input class="form-control options" value="{{old('geid')}}" name="geid"
                                           placeholder="@lang('app.geid')" type="text">

                                    @error('geid')
                                    <div class="text-danger"> {{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            {{-- address --}}
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.address')</div>
                                <textarea class="form-control" name="address"
                                       placeholder="@lang('app.address')">{{old('address')}}</textarea>
                                @error('address')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            {{-- notes --}}
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.notes')</div>
                                <textarea class="form-control" name="notes"
                                    placeholder="@lang('app.notes')">{{old('notes')}}</textarea>
                                @error('notes')
                                <div class="text-danger"> {{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg mt-2 mb-4">
                            {{-- status --}}
                            <label class="custom-control custom-checkbox custom-control-lg"> <input
                                    type="checkbox" class="custom-control-input" name="status"
                                    value="1" {{ old('status') || !old() ? 'checked' : '' }}> <span
                                    class="custom-control-label custom-control-label-md  tx-17">@lang('app.status')</span>
                            </label>
                            @error('status')
                            <div class="text-danger"> {{$message}}</div>
                            @enderror
                        </div>

                        {{-- permissions --}}
                        {{-- <div class="row row-sm mb-4">
                            @if(count($permissions))        
                                @foreach($permissions as $key =>$permission)

                                    <div class="col-sm-4 col-xl-4 border-5">
                                        <div class="card card-absolute">
                                            <div class="card-header bg-primary">
                                                <h5 class="text-white">{{trans('app.'.$key)}}</h5>
                                            </div>

                                            <div class="card-body">
                                                @foreach($permission as $item)
                                                    <div class="mb-3 m-t-15">
                                                        <div class="form-check checkbox mb-0">
                                                            <label class="custom-control custom-checkbox custom-control-lg"> <input
                                                                    type="checkbox" class="custom-control-input" name="permissions[]"
                                                                    value="{{$item}}" {{ in_array($item , old('permissions', [])) ? 'checked' : '' }}> <span
                                                                    class="custom-control-label custom-control-label-md  tx-17">@lang('app.'.$item)</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div> --}}

                        <div class="card-footer mt-4">
                            <div class="form-group mb-0 mt-3 justify-content-end">
                                <div>
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-save pe-2"></i>@lang('app.save')</button>

                                    <a role="button" href="{{ URL::previous() }}" class="btn btn-primary"><i
                                            class="fa fa-backward pe-2"></i>@lang('app.back')</a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- End Row -->

@endsection


@section('script_footer')
    <script>
                
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2({
                maximumSelectionLength: 5,
            });

            var showConditionTypes = ['1', '2', '3'];
            // Initially hide and disable the conditional fields  
            if (['4','5','6','7'].includes($("#type").val())) {
                $(".conditional-fields").hide().find(':input').prop('disabled', true);
            } else {
                $(".fields").hide().find(':input').prop('disabled', true);
            }
            // Listen for changes in the 'type' dropdown
            $("#type").change(function () {
                // Get the selected value
                var selectedType = $(this).val();
                console.log(selectedType);
                // Determine whether to show or hide the conditional fields based on the selected 'type'
                if (showConditionTypes.includes(selectedType)) {
                    $(".conditional-fields").show().find(':input').prop('disabled', false);
                    $(".fields").hide().find(':input').prop('disabled', true);
                } else {
                    $(".conditional-fields").hide().find(':input').prop('disabled', true);
                    $(".fields").show().find(':input').prop('disabled', false);
                }
                // Repeat the above logic for other 'type' values as needed
            
            
            
                if($("#type").val() == {{\App\Enums\UsersType::OFFICER->value}}){
                    $("#office").hide().prop('disabled', true);
                    console.log('it is OFFICER');
                }else if ($("#type").val() == {{\App\Enums\UsersType::COURIER->value}} || $("#type").val() == {{\App\Enums\UsersType::PICKUPCOURIER->value}}){
                    console.log('it is COURIER OR PICKUPCOURIER');
                }else if ($("#type").val() == {{\App\Enums\UsersType::LINEHAUL->value}}){
                    $("#service-locations").hide().prop('disabled', true);
                    $("#office").hide().prop('disabled', true);
                    console.log('it is LINEHAUL');
                }
                
            });

            if($("#type").val() == {{\App\Enums\UsersType::OFFICER->value}}){
                $("#office").hide().prop('disabled', true);

                console.log('it is OFFICER');
            }else if ($("#type").val() == {{\App\Enums\UsersType::COURIER->value}} || $("#type").val() == {{\App\Enums\UsersType::PICKUPCOURIER->value}}  ){
                console.log('it is COURIER OR PICKUPCOURIER');
            }else if ($("#type").val() == {{\App\Enums\UsersType::LINEHAUL->value}}){
                $("#service-locations").hide().prop('disabled', true);
                $("#office").hide().prop('disabled', true);
                console.log('it is LINEHAUL');
            }
            
        });

        

    
    </script>
@endsection