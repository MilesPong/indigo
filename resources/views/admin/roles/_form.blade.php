{{ csrf_field() }}

<!-- text input -->
<div class="form-group">
    <label>Role Name</label>
    <input type="text" class="form-control" placeholder="" name="name" value="{{ old('name', $role->name) }}"}>
</div>

<div class="form-group">
    <label>Display Name</label>
    <input type="text" class="form-control" placeholder="" name="display_name" value="{{ old('display_name', $role->display_name) }}">
</div>

<div class="form-group">
    <label>Description</label>
    <textarea class="form-control" rows="3" name="description">{{ old('description', $role->description) }}</textarea>
</div>

<div class="form-group">
    <label>Permissions</label>
    <select name="permission[]" class="form-control select2" multiple="multiple" data-placeholder="Select Permission(s)" style="width: 100%;">
        @foreach($permissions as $perm)
            <option value="{{ $perm->id }}">{{ $perm->display_name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <button class="btn btn-primary pull-right" type="submit">
        {{ isset($role->id) ? 'Save' : 'Submit' }}
    </button>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <script>
        $(".select2").select2();

        @if(old('permission') || isset($selected_perms))
            $(".select2").select2().val([{{ implode(',', old('permission', isset($selected_perms) ? $selected_perms : null)) }}]).trigger('change');
        @endif
    </script>
@endpush