<div>
    {{-- Be like water. --}}
    <div class="form-group">
        <label class="main-content-label mg-b-5">@lang('app.companies') {{ $field_name == 'parent_id'?"":"*"}}</label>
        <select name="{{ $field_name }}" wire:model="selected_company" class="form-control form-select"
            data-bs-placeholder="Select company" id='company'>
            <option value="" selected disabled>...</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}" {{ $company->id == old("$field_name", $selected_company) ? 'selected' : '' }}>
                    {{ $company->name }}</option>
            @endforeach
        </select>
    </div>
</div>
