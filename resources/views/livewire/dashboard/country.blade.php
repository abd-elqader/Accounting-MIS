<div>
    {{-- Be like water. --}}
    <div class="form-group">
        <label class="main-content-label mg-b-5">@lang('app.countries') {{ $field_name == 'parent_id'?"":"*"}}</label>
        <select name="{{ $field_name }}" wire:model="selected_country" class="form-control form-select"
            data-bs-placeholder="Select country" id='country'>
            <option value="" selected disabled>...</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}" {{ $country->id == old("$field_name", $selected_country) ? 'selected' : '' }}>
                    {{ $country->name }}</option>
            @endforeach
        </select>
    </div>
</div>
