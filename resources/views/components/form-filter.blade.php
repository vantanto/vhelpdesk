@props([
    'search' => true, 
    'search_placeholder' => 'Search', 
    'slot_top' => null,
    'slot_btn' => null,
    'pshow' => true
])
<div class="mb-3">
    <form method="get" action="{{ Request::url() }}">
        <div class="row">
            @if ($search)
                <div class="col-md-4 mb-3">
                    <label>Search</label>
                    <input type="text" name="search" class="form-control" value="{{ Request::input('search') }}" placeholder="{{ $search_placeholder }}">
                </div>
            @endif
            {{ $slot_top }}
        </div>
        {{ $slot }}
        <div class="d-flex justify-content-between">
            <div>
                <button type="submit" class="btn btn-outline-primary">Apply Filter</button>
                <a href="{{ Request::url() }}" class="btn btn-secondary">Reset Filter</a>
                {{ $slot_btn }}
            </div>
            @if($pshow == true)
            <div class="dropdown">
                <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end pb-0">
                    <span class="small ps-3 fw-bold text-dark">Show</span>
                    @php $selectedPShow = Request::input('pshow') ?? Helper::$PageItemShows[0]; @endphp
                    @foreach (Helper::$PageItemShows as $pShow)
                        <a href="{{ Request::fullUrlWithQuery(['pshow' => $pShow]) }}"
                            class="dropdown-item fw-bold 
                                @if($selectedPShow == $pShow) d-flex align-items-center @endif 
                                @if($loop->last) rounded-bottom @endif">
                            {{ $pShow }}
                            @if($selectedPShow == $pShow) <svg class="icon icon-xxs ms-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> @endif
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </form>
</div>