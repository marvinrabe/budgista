<footer>

    <div class="container text-center">

        @if(!isset($no_translations))
            <ul class="list-inline">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <li class="list-inline-item">
                        <a rel="alternate" hreflang="{{ $localeCode }}"
                           href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        <ul class="list-inline">
            <li class="list-inline-item">
                <a href="{{ route('terms') }}">{{ trans('title.terms') }}</a>
            </li>
            <li class="list-inline-item">
                <a href="{{ route('privacy') }}">{{ trans('title.privacy') }}</a>
            </li>
            <li class="list-inline-item">
                <a href="{{ route('legal') }}">{{ trans('title.legal') }}</a>
            </li>
        </ul>

        <p class="copyright">
            &copy; {{ date('Y') }} Budgista.com
        </p>
    </div>
</footer>