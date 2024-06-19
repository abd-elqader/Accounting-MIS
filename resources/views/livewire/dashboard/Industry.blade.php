<div>
    {{-- Be like water. --}}
    <div class="form-group">
        <label class="main-content-label mg-b-5">@lang('app.industries') {{ $field_name == 'parent_id'?"":"*"}}</label>
        <select name="{{ $field_name }}" wire:model="selected_industry" class="form-control form-select"
            data-bs-placeholder="Select industry" id='industry'>
            <option value="" selected disabled>...</option>
            @foreach ($industries as $industry)
                <option value="{{ $industry->id }}" {{ $industry->id == old("$field_name", $selected_industry) ? 'selected' : '' }}>
                    {{ $industry->name }}</option>
            @endforeach
        </select>
    </div>
</div>
