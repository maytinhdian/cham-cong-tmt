<div class="dataTable-bottom">
    <div class="dataTable-info">
        Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }} entries
    </div>
    @if ($paginator->hasPages())
        <nav class="dataTable-pagination" aria-label="Table pagination">
            <ul class="dataTable-pagination-list">
                @if ($paginator->onFirstPage())
                    <li class="pager disabled" aria-disabled="true">
                        <a href="#" onclick="return false;" aria-label="Previous">&lsaquo;</a>
                    </li>
                @else
                    <li class="pager">
                        <a href="#" wire:click.prevent="previousPage('{{ $paginator->getPageName() }}')" aria-label="Previous">&lsaquo;</a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="ellipsis disabled" aria-disabled="true">
                            <a href="#" onclick="return false;">{{ $element }}</a>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="active" aria-current="page">
                                    <a href="#" onclick="return false;">{{ $page }}</a>
                                </li>
                            @else
                                <li>
                                    <a href="#" wire:click.prevent="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="pager">
                        <a href="#" wire:click.prevent="nextPage('{{ $paginator->getPageName() }}')" aria-label="Next">&rsaquo;</a>
                    </li>
                @else
                    <li class="pager disabled" aria-disabled="true">
                        <a href="#" onclick="return false;" aria-label="Next">&rsaquo;</a>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>
