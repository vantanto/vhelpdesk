<x-app-layout>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card card-body border-0 shadow">
                <h2 class="h5 mb-4">Detail Role</h2>
                <h3 class="h5 mb-3 text-center">{{ $role->name }}</h3>
                <hr>
                <div class="row text-center">
                    <div class="col mb-2">
                        <h2 class="h6 text-gray-400 mb-0">Permissions</h2>
                        <div class="d-flex align-items-center justify-content-center">
                            <h3 class="fw-extrabold me-1">{{ count($role->permissions) }}</h3>
                            <small class="text-gray-500">of {{ count($permissions) }}</small>
                        </div>
                    </div>
                    <div class="col mb-2">
                        <h2 class="h6 text-gray-400 mb-0">Users</h2>
                        <div class="d-flex align-items-center justify-content-center">
                            <h3 class="fw-extrabold"><a href="{{ route('users.index', ['role' => $role->id]) }}">{{ count($role->users) }}</a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card-header">
                <h3 class="h5">Permissions</h3>
            </div>
            <div class="card card-body border-0 shadow">
                @php 
                    $lastPermGroup = ''; 
                    $rolePermissions = $role->permissions->pluck('id')->toArray();
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
                                            disabled
                                            @if($is_rolePermission) 
                                                checked  
                                            @endif>
                                            
                                        <label for="{{ $permission->name }}">
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
            </div>
        </div>
    </div>
</x-app-layout>