<div>
    {{-- Be like water. --}}
    <div class="form-group">
        <label class="main-content-label mg-b-5">@lang('app.services') {{ $field_name == 'parent_id'?"":"*"}}</label>
        <select name="{{ $field_name }}" wire:model="selected_service" class="form-control form-select"
            data-bs-placeholder="Select service" id='service'>
            <option value="" selected disabled>...</option>
            @foreach ($services as $service)
                <option value="{{ $service->id }}" {{ $service->id == old("$field_name", $selected_service) ? 'selected' : '' }}>
                    {{ $service->name }}</option>
            @endforeach
        </select>
    </div>
</div>
