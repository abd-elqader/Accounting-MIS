@extends('layouts.app')

@section('content')

    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb', [
        'title' => trans('app.users_page_title'),
        'first_list_item' => trans('app.users'),
        'last_list_item' => trans('app.edit_user'),
    ])
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
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row row-sm mb-4">

                            {{-- name --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.name') *</div>
                                    <input class="form-control" name="name" value="{{ old('name') ?? $user->name }}"
                                        placeholder="@lang('app.name')" type="text">
                                    @error('name')
                                        <div id="validationServer03Feedback" class="invalid-feedback"> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- email --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.email') *</div>
                                    <input class="form-control" value="{{ old('email') ?? $user->email }}" name="email"
                                        placeholder="@lang('app.email')" type="email">
                                    @error('email')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- phone --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.phone') *</div>
                                    <input class="form-control" value="{{ old('phone') ?? $user->phone }}" name="phone"
                                        type="text">

                                    @error('phone')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row row-sm mb-4">
                            {{-- profile_image --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.profile_image')</div>
                                    <input class="form-control" value="{{ old('profile_image') ?? $user->profile_image }}"
                                        name="profile_image" type="file">

                                    @error('profile_image')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- password --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.password')</div>
                                    <input class="form-control" value="{{ old('password') }}" name="password"
                                        placeholder="@lang('app.password')" type="password">
                                    @error('password')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- password_confirmation --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.password_confirmation')</div>
                                    <input class="form-control" value="{{ old('password_confirmation') }}"
                                        name="password_confirmation" placeholder="@lang('app.password_confirmation')" type="password">
                                    @error('password_confirmation')
                                        <div class="text-danger"> {{ $message }}</div>
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
                                        @foreach (App\Enums\UsersType::options() as $name => $value)
                                            <option value="{{ $value }}"
                                                {{ $value == (old('type') ?? $user->type) ? 'selected' : '' }}>
                                                {{ $name }}</option>
                                        @endforeach
                                    </select>

                                    @error('type')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- role --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.role') *</div>
                                    <select class="form-control" name="role" id="role">
                                        @if (!(old('role') || $user->roles))
                                            <option value="">Select Role</option>
                                        @endif
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $role->id == (old('role') ?? $user->roles?->first()?->id) ? 'selected' : '' }}>
                                                {{ $role->name }}</option>
                                            {{-- <option value="{{ $role->id }}" {{ $role->id == (old('role') ?? (!empty($user->roles) ? $user->roles->first->id : null)) ? 'selected' : '' }}>{{ $role->name }}</option> --}}
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- city --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    @livewire('location.cities', ['selected_city' => old('city_id') ?? $user->city_id, 'status' => $status])
                                    @error('city_id')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- area --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    @livewire('location.areas', ['areas_for_city_id' => $user->city_id, 'selected_area' => old('area_id') ?? $user->area_id, 'status' => $status])
                                    @error('area_id')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            {{-- subarea --}}
                            {{-- <div class="col-lg">
                                <div class="form-group">
                                    @livewire('location.subareas', ['subareas_for_city_id' => $user->city_id, 'selected_subarea' => old('subarea_id') ?? $user->subarea_id, 'status' => $status])
                                    @error('subarea_id')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                        </div>
                        
                        <div class="row row-sm mb-4">

                            {{-- service locations --}}
                            @php
                            $userLocations = $user->locations->toArray();
                            if(old('service_location_ids', [])){
                                $idArray = old('service_location_ids', []);
                            }else {
                                $idArray = array_column($userLocations, 'id');
                            }
                            @endphp
                            <div class="col-lg fields" id="service-locations">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">Select Service location</div>
                                    <select class="js-example-basic-multiple form-control form-select"
                                        name="service_location_ids[]" multiple="multiple" size="3">
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}"
                                                    {{ in_array($location->id, $idArray) ? 'selected' : '' }}>
                                                    {{ $location->title }}
                                                </option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- office --}}
                            <div class="col-lg showSelect fields" id="office">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">Select Office</div>
                                    <select class="form-control" name="office_id">
                                        @foreach ($offices as $office)
                                            <option value="{{ $office->id }}"
                                                {{ $office->id == (old('office_id') ?? $user->head_offices_id) ? 'selected' : '' }}>
                                                {{ $office->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row row-sm mb-4">

                            {{-- company --}}
                            <div class="col-lg hiddenSelect conditional-fields">
                                <div class="form-group">
                                    @livewire('company', ['selected_company' => old('company_id') ?? $user->company_id, 'status' => $status])
                                    @error('company_id')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- branch --}}
                            <div class="col-lg hiddenSelect conditional-fields">
                                <div class="form-group">
                                    @livewire('branch', ['branches_for_company_id' => $user->company_id, 'selected_branch' => old('branch_id') ?? $user->branch_id, 'status' => $status])
                                    @error('branch_id')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- department --}}
                            <div class="col-lg hiddenSelect conditional-fields">
                                <div class="form-group">
                                    @livewire('department', ['departments_for_company_id' => $user->company_id, 'selected_department' => old('department_id') ?? $user->department_id, 'status' => $status])
                                    @error('department_id')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- geid --}}
                            <div class="col-lg conditional-fields">
                                <div class="form-group showSelect">
                                    <div class="main-content-label mg-b-5">@lang('app.geid') *</div>
                                    <input class="form-control" value="{{ old('geid') ?? $user->geid }}" name="geid"
                                        placeholder="@lang('app.geid')" type="text">

                                    @error('geid')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row row-sm mb-4">
                            {{-- address --}}
                            <div class="col-lg">
                                <div class="form-group">
                                    <div class="main-content-label mg-b-5">@lang('app.address')</div>
                                    <textarea class="form-control" name="address">{{ old('address') ?? $user->address }}</textarea>

                                    @error('address')
                                        <div class="text-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            {{-- notes --}}
                            <div class="col-lg">
                                <div class="main-content-label mg-b-5">@lang('app.notes')</div>
                                <textarea class="form-control" name="notes">{{ old('notes') ?? $user->notes }}</textarea>

                                @error('notes')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            {{-- status --}}
                            <div class="col-lg mt-2 mb-4">
                                <label class="custom-control custom-checkbox custom-control-lg"> <input type="checkbox"
                                        class="custom-control-input" name="status" value="1"
                                        {{ $user->status ? 'checked' : '' }}> <span
                                        class="custom-control-label custom-control-label-md  tx-17">@lang('app.status')</span>
                                </label>
                                @error('status')
                                    <div class="text-danger"> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row row-sm mb-4">
                            {{-- permissions --}}
                            {{-- @if (count($permissions))
                                @foreach ($permissions as $key => $permission)
                                    <div class="col-sm-4 col-xl-4 border-5">
                                        <div class="card card-absolute">
                                            <div class="card-header bg-primary">
                                                <h5 class="text-white">{{ trans('app.' . $key) }}</h5>
                                            </div>

                                            <div class="card-body">
                                                @foreach ($permission as $item)
                                                    <div class="mb-3 m-t-15">
                                                        <div class="form-check checkbox checkbox-primary mb-0">
                                                            <label
                                                                class="custom-control custom-checkbox custom-control-lg">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="permissions[]" value="{{ $item }}"
                                                                    {{ $user->can($item) ? 'checked' : '' }}>
                                                                <span
                                                                    class="custom-control-label custom-control-label-md  tx-17">@lang('app.' . $item)</span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            @endif --}}

                        </div>

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
        $(document).ready(function() {

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

            $('.js-example-basic-multiple').select2({
                maximumSelectionLength: 5,
            });


            var showConditionTypes = ['1', '2', '3'];
            // Initially hide and disable the conditional fields
            console.log(typeof($("#type").val()));
            if (['4', '5', '6', '7'].includes($("#type").val())) {
                $(".conditional-fields").hide().find(':input').prop('disabled', true);
            } else {
                $(".fields").hide().find(':input').prop('disabled', true);
            }
            // Listen for changes in the 'type' dropdown
            $("#type").change(function() {
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


            
        });
    </script>
@endsection

