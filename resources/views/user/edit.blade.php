<x-app-layout>
    <div class="card card-body border-0 shadow">
        <h2 class="h5 mb-4">Edit User</h2>
        <form id="mainForm" method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div>
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" required value="{{ $user->name }}">
                        <x-invalid-feedback />
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div>
                        <label for="email">Email</label>
                        <input type="text" id="email" class="form-control-plaintext" readonly value="{{ $user->email }}">
                        <x-invalid-feedback />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div>
                        <label for="password">New Password (Optional)</label>
                        <input type="password" id="password" name="password" class="form-control">
                        <x-invalid-feedback />
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div>
                        <label for="password_confirmation">Confirm New Password (Optional)</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                        <x-invalid-feedback />
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button tpye="submit" id="mainFormBtn" class="btn btn-gray-800 mt-2 animate-up-2">Submit</button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>mainFormSubmit();</script>
    @endpush
</x-app-layout>