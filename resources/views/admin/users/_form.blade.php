{{ csrf_field() }}

<!-- text input -->
<div class="form-group">
    <label>Name</label>
    <input type="text" class="form-control" placeholder="Full Name" name="name" value="{{ old('name', $user->name) }}">
</div>

<div class="form-group">
    <label>Email</label>
    <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email', $user->email) }}">
</div>

<div class="form-group has-feedback">
    <label>Password</label>
    <input type="password" class="form-control" placeholder="Password" name="password"/>
</div>
<div class="form-group has-feedback">
    <label>Confirm Password</label>
    <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation"/>
</div>

<div class="form-group">
    <label>Roles</label>
    <select name="role[]" class="form-control select2" multiple="multiple" data-placeholder="Select Role(s)" style="width: 100%;">
        @foreach($roles as $role)
            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <button class="btn btn-primary pull-right" type="submit">
        {{ isset($user->id) ? 'Save' : 'Submit' }}

    </button>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <script>
        $(".select2").select2();

        @if(old('role') || isset($userRoles))
            $(".select2").select2().val([{{ implode(',', old('role', isset($userRoles) ? $userRoles : null)) }}]).trigger('change');
        @endif
    </script>
@endpush