<x-app-layout>
    <div class="card card-body border-0 shadow">
        <h2 class="h5 mb-4">Edit Department</h2>
        <form id="mainForm" method="POST" action="{{ route('departments.update', $department->id) }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div>
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" required value="{{ $department->name }}">
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