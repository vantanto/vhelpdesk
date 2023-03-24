<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">List Category</h2>
        <x-slot name="header_btn">
            @can('category-create')
                <a href="{{ route('categories.create') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                    <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    New Category
                </a>
            @endcan
        </x-slot>
    </x-slot>

    <x-form-filter search_placeholder="Search Name"/>

    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0 rounded-start">#</th>
                            <th class="border-0">Name</th>
                            <th class="border-0 rounded-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration + $categories->firstItem() - 1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    @can('category-edit')
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm mb-1">Edit</a>
                                    @endcan
                                    @can('category-delete')
                                        <form method="post" action="{{ route('categories.destroy', $category->id) }}" class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-danger btn-sm mb-1" onclick="confirmSwalAlert(this)">Delete</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $categories->withQueryString()->links() }}
            </div>
        </div>
    </div>
    
</x-app-layout>