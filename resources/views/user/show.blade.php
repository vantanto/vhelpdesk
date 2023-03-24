<x-app-layout>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card card-body border-0 shadow">
                <h2 class="h5 mb-4">Detail User</h2>
                <table class="table table-sm table-borderless">
                    <colgroup>
                        <col class="col-md-4">
                        <col class="col-md-8">
                    </colgroup>
                    <tr>
                        <td>Avatar</td>
                        <td><x-user.avatar :user="$user" /></td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>Role</td>
                        <td>{{ $user->role_name }}</td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td>{!! implode('<br>', $user->departments->pluck('name')->toArray()) !!}</td>
                    </tr>
                    <tr>
                        <td>Registered</td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card-header">
                <h3 class="h5">Permissions</h3>
            </div>
            <div class="card card-body border-0 shadow">
                <div class="d-flex">
                    <label class="me-3">
                        {{ $user->role_id ? count($user->roles[0]->permissions) : 0 }} 
                        Role Permission
                    </label>
                    <label class="me-3 text-info">
                        {{ count($user->permissions) }}
                        Special User Permission
                    </label>
                </div>

                <hr>

                <form id="mainForm" method="POST" action="{{ route('users.permissions.update', $user->id) }}">
                    @csrf
                    @php 
                        $lastPermGroup = ''; 
                        $rolePermissions = $user->role_id ? $user->roles[0]->permissions->pluck('id')->toArray() : [];
                        $userPermissions = $user->permissions->pluck('id')->toArray();
                    @endphp
                    @foreach ($permissions as $permission)
                        @php 
                            $permGroup = explode('-', $permission->name)[0];
                            $is_rolePermission = in_array($permission->id, $rolePermissions);
                        @endphp

                        @if($lastPermGroup != $permGroup)
                            @if(!$loop->first)
                                {!! '</div><hr></div>' !!}
                            @endif
                            
                            <div class="mb-3">
                                <div class="mb-1">
                                    <span class="h6 fw-bold">{{ ucwords(str_replace('_', ' ', $permGroup)) }}</span>
                                </div>
                                <div class="row">
                        @endif

                                    <div class="col-sm-4 mb-1">
                                        <div class="form-check">
                                            <input type="checkbox" id="{{ $permission->name }}" class="form-check-input" 
                                                @if($is_rolePermission) 
                                                    checked disabled
                                                @else
                                                    name="permissions[]"
                                                    value="{{ $permission->id }}"
                                                    @if(in_array($permission->id, $userPermissions)) 
                                                        checked
                                                    @endif
                                                @endif
                                                @cannot('user-edit') disabled @endcan>
                                            <label for="{{ $permission->name }}" class="@if(!$is_rolePermission) text-info @endif">
                                                {{ ucwords(str_replace(['-', '_'], ' ', $permission->name)) }}
                                            </label>
                                        </div>
                                    </div>
                                    
                        @if($loop->last)
                                </div>
                                <hr>
                            </div>
                        @endif

                        @php $lastPermGroup = $permGroup; @endphp
                    @endforeach

                    <div class="mt-3">
                        @can('user-edit')
                            <button type="submit" id="mainFormBtn" class="btn btn-gray-800 mt-2 animate-up-2">Submit</button>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>mainFormSubmit();</script>
    @endpush
</x-app-layout>