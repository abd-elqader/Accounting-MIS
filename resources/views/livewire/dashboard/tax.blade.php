<div>
    {{-- Be like water. --}}
    <div class="form-group">
        <label class="main-content-label mg-b-5">@lang('app.taxes') *</label>
        <select name="{{ $field_name }}" wire:model="selected_tax" class="form-control form-select"
            data-bs-placeholder="Select tax" id='tax'>
            <option value="" selected disabled>...</option>
            @foreach ($taxes as $tax)
                <option value="{{ $tax->id }}" {{ $tax->id == old("$field_name", $selected_tax) ? 'selected' : '' }}>
                    {{ $tax->name }}</option>
            @endforeach
        </select>
    </div>
</div>
