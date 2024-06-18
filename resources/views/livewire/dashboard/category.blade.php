<div>
    {{-- Be like water. --}}
    <div class="form-group">
        <label class="main-content-label mg-b-5">@lang('app.categories') {{ $field_name == 'parent_id'?"":"*"}}</label>
        <select name="{{ $field_name }}" wire:model="selected_category" class="form-control form-select"
            data-bs-placeholder="Select category" id='category'>
            <option value="" selected disabled>...</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == old("$field_name", $selected_category) ? 'selected' : '' }}>
                    {{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>
