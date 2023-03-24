<div class="card mb-3">
    <div class="card-header"><strong>Profile Information</strong></div>
    <div class="card-body">
        <p>Update your account's profile information and email address.</p>
        <form method="post" action="{{ route('profile.update') }}" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label" for="avatar">Avatar</label>
                <div class="col-md-9">
                    <input type="file" id="avatar" name="avatar" class="form-control" accept=".png, .jpg, .jpeg">
                    <x-input-error :messages="$errors->get('avatar')" />
                </div>
            </div>
            
            <div class="mb-3 row">
                <label class="col-md-3 col-form-label" for="name">Name</label>
                <div class="col-md-9">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Name"
                        value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    <x-input-error :messages="$errors->get('name')" />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">Email</label>
                <div class="col-md-9">
                    <label class="form-control-plaintext">{{ $user->email }}</label>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">Role</label>
                <div class="col-md-9">
                    <label class="form-control-plaintext">{{ $user->role_name }}</label>
                </div>
            </div>
            
            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">Department</label>
                <div class="col-md-9">
                    <label class="form-control-plaintext">{{ implode(', ', $user->departments->pluck('name')->toArray()) }}</label>
                </div>
            </div>

            <div class="text-end">
                @if (session('status') === 'profile-updated')
                    <span class="text-success fade-in">Saved.</span>
                @endif
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
