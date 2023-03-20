@props(['label', 'value', 'value_compare' => null])

<div class="card border-0 shadow">
    <div class="card-body p-2">
        <div class="row d-block d-xl-flex align-items-center">
            <div class="col-12 col-xl-4 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"></path>
                    </svg>
                </div>
                <div class="d-sm-none">
                    <h2 class="h5">{{ $label }}</h2>
                    <h3 class="fw-extrabold mb-1">{{ number_format($value) }}</h3>
                </div>
            </div>
            <div class="col-12 col-xl-7 px-xl-0">
                <div class="d-none d-sm-block">
                    <h2 class="h6 text-gray-400 mb-0">{{ $label }}</h2>
                    <h3 class="fw-extrabold mb-2">{{ number_format($value) }}</h3>
                </div>
                @if (!is_null($value_compare))
                    <div class="small d-flex mt-1">
                        <div class="me-1">Since Last mos</div>
                        <span class="d-flex align-items-center">
                            @if($value > $value_compare)
                                <svg class="icon icon-xs text-success" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                            @elseif($value < $value_compare)
                                <svg class="icon icon-xs text-danger" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                            <span class="fw-bolder @if($value > $value_compare) text-success @elseif($value < $value_compare) text-danger @endif">
                                {{ number_format($value_compare > 0 
                                    ? abs(($value-$value_compare)/$value_compare * 100) 
                                    : ($value > 0 ? 100 : 0)
                                , 0) }}%
                            </span>
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>