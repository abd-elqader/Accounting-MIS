<div>
    {{-- Be like water. --}}
    <div class="form-group">
        <label class="main-content-label mg-b-5">@lang('app.departments') *</label>
        <select name="{{ $field_name }}" wire:model="selected_department" class="form-control form-select"
            data-bs-placeholder="Select department" id='department'>
            <option value="" selected disabled>...</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}" {{ $department->id == old("$field_name", $selected_department) ? 'selected' : '' }}>
                    {{ $department->name }}</option>
            @endforeach
        </select>
    </div>
</div>
