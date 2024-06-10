<div>
    {{-- Be like water. --}}
    <div class="form-group">
        <label class="main-content-label mg-b-5">@lang('app.currencies') *</label>
        <select name="{{ $field_name }}" wire:model="selected_currency" class="form-control form-select"
            data-bs-placeholder="Select currency" id='currency'>
            @foreach ($currencies as $currency)
                <option value="{{ $currency->id }}" {{ $currency->id == old("$field_name", $selected_currency) ? 'selected' : '' }}>
                    {{ $currency->name }}</option>
            @endforeach
        </select>
    </div>
</div>
