<div>
    {{-- Be like water. --}}
    <div class="form-group">
        <label class="main-content-label mg-b-5">@lang('app.invoices') {{ $field_name == 'parent_id'?"":"*"}}</label>
        <select name="{{ $field_name }}" wire:model="selected_invoice" class="form-control form-select"
            data-bs-placeholder="Select invoice" id='invoice'>
            <option value="" selected disabled>...</option>
            @foreach ($invoices as $invoice)
                <option value="{{ $invoice->id }}" {{ $invoice->id == old("$field_name", $selected_invoice) ? 'selected' : '' }}>
                    {{ $invoice->id }}</option>
            @endforeach
        </select>
    </div>
</div>
