<div>
    {{-- Be like water. --}}
    <div class="form-group">
        <label class="main-content-label mg-b-5">@lang('app.suppliers') {{ $field_name == 'parent_id'?"":"*"}}</label>
        <select name="{{ $field_name }}" wire:model="selected_supplier" class="form-control form-select"
            data-bs-placeholder="Select supplier" id='supplier'>
            <option value="" selected disabled>...</option>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}" {{ $supplier->id == old("$field_name", $selected_supplier) ? 'selected' : '' }}>
                    {{ $supplier->contact_name }}</option>
            @endforeach
        </select>
    </div>
</div>
