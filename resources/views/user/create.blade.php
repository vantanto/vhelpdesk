<x-app-layout>
    <div class="card card-body border-0 shadow">
        <h2 class="h5 mb-4">New User</h2>
        <form id="mainForm" method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                    <x-invalid-feedback />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                    <x-invalid-feedback />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <x-invalid-feedback />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    <x-invalid-feedback />
                </div>
            </div>
            <div class="mb-3">
                <label for="department">Department <small class="text-muted">(Optional) (Multiple)</small></label>
                <select id="department" name="departments[]" class="form-select" multiple style="width: 100%">
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                <x-invalid-feedback />
            </div>
            <div class="mt-3">
                <button type="submit" id="mainFormBtn" class="btn btn-gray-800 mt-2 animate-up-2">Submit</button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>mainFormSubmit();</script>
    <script>
        $("#department").select2();
    </script>
    @endpush
</x-app-layout>