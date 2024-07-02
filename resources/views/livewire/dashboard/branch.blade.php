<div>
    {{-- Be like water. --}}
    <div class="form-group">
        <label class="main-content-label mg-b-5">@lang('app.branches') {{ $field_name == 'parent_id'?"":"*"}}</label>
        <select name="{{ $field_name }}" wire:model="selected_branch" class="form-control form-select"
            data-bs-placeholder="Select branch" id='branch'>
            <option value="" selected disabled>...</option>
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}" {{ $branch->id == old("$field_name", $selected_branch) ? 'selected' : '' }}>
                    {{ $branch->name }}</option>
            @endforeach
        </select>
    </div>
</div>
