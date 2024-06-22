<div>
    {{-- Be like water. --}}
    <div class="form-group">
        <label class="main-content-label mg-b-5">@lang('app.customers') {{ $field_name == 'parent_id'?"":"*"}}</label>
        <select name="{{ $field_name }}" wire:model="selected_customer" class="form-control form-select"
            data-bs-placeholder="Select customer" id='customer'>
            <option value="" selected disabled>...</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}" {{ $customer->id == old("$field_name", $selected_customer) ? 'selected' : '' }}>
                    {{ $customer->contact_name }}</option>
            @endforeach
        </select>
    </div>
</div>
