<div>
    {{-- Be like water. --}}
    <div class="form-group">
        <label class="main-content-label mg-b-5">@lang('app.products') {{ $field_name == 'parent_id'?"":"*"}}</label>
        <select name="{{ $field_name }}" wire:model="selected_product" class="form-control form-select"
            data-bs-placeholder="Select product" id='product'>
            <option value="" selected disabled>...</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" {{ $product->id == old("$field_name", $selected_product) ? 'selected' : '' }}>
                    {{ $product->name }}</option>
            @endforeach
        </select>
    </div>
</div>
