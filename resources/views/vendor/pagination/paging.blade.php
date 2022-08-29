@if(isset($searchData['page']) && isset($searchData['totalCnt']) && isset($searchData['limit']))
    @php
        $block_page = 10; // 블록제한수
        $current_page = (isset($searchData['page']) ? $searchData['page'] : 1); // 현제 페이지
        $total_page = ceil((isset($searchData['totalCnt']) ? $searchData['totalCnt'] : 0) / (isset($searchData['limit']) ? $searchData['limit'] : 0));	// 전체 페이지
        $now_block = ceil($current_page / $block_page);	// 현재 리스트의 블럭
        $total_block = ceil($total_page / $block_page);	// 전체 블럭수
        $start_page = (($now_block - 1) * $block_page) + 1;	// 현재 블럭 시작 페이지
        $end_page = $block_page * $now_block; // 현재 블럭 마지막 페이지
        $prev_block = ($now_block - 1) * $block_page; // 이전 블록 마지막 페이지
        $next_block = $now_block * $block_page + 1; // 다음 블록 첫 페이지
        if ($end_page > $total_page) $end_page = $total_page;
        $pagingFunc = $pagingFunc ?? $searchData['functionName'];

    @endphp
    <ul class="pagination justify-center">
        {{--@if ($now_block > 1 && $current_page <= $total_page )--}}
            <li class="page-item">
                <a class="page-link" onclick="{{ $pagingFunc }}(1);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevrons-left" class="lucide lucide-chevrons-left w-4 h-4" data-lucide="chevrons-left">
                        <polyline points="11 17 6 12 11 7"></polyline>
                        <polyline points="18 17 13 12 18 7"></polyline>
                    </svg>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" onclick="{{ $pagingFunc }}({{ $prev_block }});">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-left" class="lucide lucide-chevron-left w-4 h-4" data-lucide="chevron-left">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </a>
            </li>
        {{--@endif--}}
        @for($i = $start_page; $i <= $end_page; $i++)
            @if($i == $current_page)
                <li class="page-item active"><a class="page-link" href="javascript:void(0);">{{ $i }}</a></li>
            @else
                <li class="page-item"><a class="page-link" onclick="{{ $pagingFunc }}({{ $i }});">{{ $i }}</a></li>
            @endif
        @endfor
        {{--@if ($now_block < $total_block)--}}
            <li class="page-item">
                <a class="page-link" onclick="{{ $pagingFunc }}({{ $next_block }});">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-right" class="lucide lucide-chevron-right w-4 h-4" data-lucide="chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" onclick="{{ $pagingFunc }}({{ $total_page }})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevrons-right" class="lucide lucide-chevrons-right w-4 h-4" data-lucide="chevrons-right">
                        <polyline points="13 17 18 12 13 7"></polyline>
                        <polyline points="6 17 11 12 6 7"></polyline>
                    </svg>
                </a>
            </li>
            {{--@endif--}}
    </ul>
@endif
