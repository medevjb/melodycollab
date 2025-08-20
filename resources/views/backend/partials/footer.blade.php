<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="terms d-flex justify-content-center justify-content-md-end">
                @forelse ($dynamicPages as $page)
                    <li class="list-inline-item me-4">
                        <a href="{{ route('dynamic.page', ['slug' => $page['page_slug']]) }}">
                            {{-- <i class="bi bi-chevron-right me-2"></i>  --}}
                            {{ $page['page_title'] }}
                        </a>
                    </li>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</footer>
