<div class="card mb-3">
    <div class="card-header"><strong>Update Password</strong></div>
    <div class="card-body">
        <p>Ensure your account is using a long, random password to stay secure.</p>
        <form method="post" action="{{ route('password.update') }}" class="form-horizontal">
            @csrf
            @method('put')

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label" for="current_password">Current Password</label>
                <div class="col-md-9">
                    <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Current Password"
                        required>
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label" for="password">New Password</label>
                <div class="col-md-9">
                    <input type="password" id="password" name="password" class="form-control" placeholder="New Password"
                        required>
                    <x-input-error :messages="$errors->updatePassword->get('password')" />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label" for="password_confirmation">Confirm Password</label>
                <div class="col-md-9">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password"
                        required>
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
                </div>
            </div>

            <div class="text-end">
                @if (session('status') === 'password-updated')
                    <span class="text-success fade-in">Saved.</span>
                @endif
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
