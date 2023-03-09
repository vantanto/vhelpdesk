<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">List User</h2>
        <x-slot name="header_btn">
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                New User
            </a>
        </x-slot>
    </x-slot>

    <x-form-filter search_placeholder="Search name, email">
        <x-slot name="slot_top">
            <div class="col-md-4">
                <label>Department</label>
                <select class="form-select" name="department">
                    <option value="" selected>All Department</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </x-slot>
    </x-form-filter>

    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0 rounded-start">#</th>
                            <th class="border-0">Name</th>
                            <th class="border-0">Email</th>
                            <th class="border-0">Department</th>
                            <th class="border-0">Registered</th>
                            <th class="border-0 rounded-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->departments as $department)
                                        {{ $department->name }} <br>
                                    @endforeach
                                </td>
                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm mb-1">Edit</a>
                                    <form method="post" action="{{ route('users.destroy', $user->id) }}" class="d-inline">
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-sm mb-1" onclick="confirmSwalAlert(this)">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
    
</x-app-layout>