<x-app-layout>
    @push('styles')
        <style>
            mark {
                background-color: yellow; 
                padding: 0;
            }
        </style>
    @endpush

    <div class="d-flex justify-content-between align-items-end">
        <div></div>
        <div class="text-center">
            <h2 class="h4">Search</h2>
            <p>
                @if($count > 0)
                    Found {{ $count }} data
                @else
                    No Data Found
                @endif
                for : {{ Request::input('search') }}
            </p>
        </div>
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" id="switch-mark" checked>
            <label class="form-check-label" for="switch-mark">Mark</label>
        </div>
    </div>

    @if($count > 0)
        <div class="row">
            @foreach ($menuData as $menu=>$data)
                @if(count($data) > 0)
                    <div class="col-12">
                        <div id="search-{{ $menu }}" class="card card-body border-0 shadow p-3 mb-3">
                            <h2 class="h5 mb-3">{{ ucwords(str_replace('_', ' ', $menu)) }}</h2>
                            @foreach ($data as $d)
                                @if($menu == 'ticket')
                                    <x-search.result-list :title="$d->code">
                                        <x-slot name="description">
                                            {{ $d->title }}, {{ $d->priority }}, {{ $d->status }}, {{ $d->description }}, {{ $d->category->name ?? '' }}
                                        </x-slot>
                                        <x-slot name="action">
                                            <a href="{{ route('tickets.show', $d->code) }}" class="text-info mb-1">Detail</a>
                                        </x-slot>
                                    </x-search.result-list>
                                @elseif($menu == 'user')
                                    <x-search.result-list :title="$d->name" :description="$d->email" />
                                @elseif (in_array($menu, ['department', 'category']))
                                    <x-search.result-list :title="$d->name" />
                                @endif
                            @endforeach
                            {{ $data->withQueryString()->links() }}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.min.js" integrity="sha512-mhbv5DqBMgrWL+32MmsDOt/OAvqr/cHimk6B8y/bx/xS88MVkYGPiVv2ixKVrkywF2qHplNRUvFsAHUdxZ3Krg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            $(document).ready(function() {
                $('#switch-mark').change(function() {
                    const switch_mark = this.checked;
                    $('.stitle, .sdescription').unmark({
                        done: function() {
                            if (switch_mark == true) {
                                $('.stitle, .sdescription').mark("{{ Request::input('search') ?? '' }}");
                            }
                        }
                    });
                });
                $('#switch-mark').trigger('change');
            });
        </script>
    @endpush

</x-app-layout>