<x-app-layout>
    <div class="card card-body border-0 shadow">
        <h2 class="h5 mb-4">Edit Ticket</h2>
        <h3 class="h5 mb-3 text-center">{{ $ticket->code }}</h3>
        <form id="mainForm" method="POST" action="{{ route('tickets.update', $ticket->code) }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" class="form-control" required value="{{ $ticket->title }}">
                    <x-invalid-feedback />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="priority">Priority</label>
                    <select id="priority" name="priority" class="form-select" required>
                        @foreach ($priorities as $priority)
                            <option value="{{ $priority }}"
                                @selected($priority == $ticket->priority)>
                                {{ ucwords($priority) }}
                            </option>
                        @endforeach
                    </select>
                    <x-invalid-feedback />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="category">Category <small class="text-muted">(Optional)</small></label>
                    <select id="category" name="category" class="form-select">
                        <option value="">No Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected($category->id == $ticket->category_id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-invalid-feedback />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="due_date">Due Date <small class="text-muted">(Optional)</small></label>
                    <input type="datetime-local" id="due_date" name="due_date" class="form-control" value="{{ $ticket->due_date }}">
                    <x-invalid-feedback />
                </div>
            </div>
            <div class="mb-3">
                <label for="department">Department <small class="text-muted">(Optional) (Multiple)</small></label>
                <select id="department" name="departments[]" class="form-select" multiple style="width: 100%">
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}"
                            @selected(in_array($department->id, $ticket->departments->pluck('id')->toArray()))>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                <x-invalid-feedback />
            </div>
            <div class="mb-3">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="10" required>{{ $ticket->description }}</textarea>
                <x-invalid-feedback />
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="files">File <small class="text-muted">(Optional) (Multiple)</small></label>
                    <input type="file" id="files" name="files[]" class="form-control" multiple>
                    <x-invalid-feedback />
                </div>
            </div>
            <div class="row">
                @foreach ((array) $ticket->files as $idx => $file)
                    <div class="col-md-6">
                        <x-file href="{{ Storage::disk('public')->url($file) }}" delete_name="files_delete[]" delete_value="{{ $idx }}" />
                    </div>
                @endforeach
            </div>
            <div class="mt-3">
                <button tpye="submit" id="mainFormBtn" class="btn btn-gray-800 mt-2 animate-up-2">Submit</button>
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