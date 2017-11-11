<footer>
    <div class="container text-md-left text-center">
        <ul class="list-inline float-md-right">
            @if (Auth::guest())
                <li class="list-inline-item">
                    <a href="{{ route('register') }}">Sign up</a>
                </li>
                <li class="list-inline-item">
                    <a href="{{ route('login') }}">Login</a>
                </li>
            @else
                <li class="list-inline-item">
                    <a href="{{ route('app') }}">{{ __('Go back to App') }}</a>
                </li>
            @endif
            <li class="list-inline-item">
                <a href="{{ url('/legal') }}">Legal Disclosure</a>
            </li>
            <li class="list-inline-item">
                <a class="icon" href="{{ config('app.social.facebook') }}" target="_blank" rel="publisher">
                    <span class="fa fa-fw fa-facebook"></span>
                </a>
            </li>
            <li class="list-inline-item">
                <a class="icon" href="{{ config('app.social.twitter') }}" target="_blank" rel="publisher">
                    <span class="fa fa-fw fa-twitter"></span>
                </a>
            </li>
        </ul>

        <p class="copyright">
            Copyright &copy; {{ date('Y') }} Budgista.com - All Rights Reserved.
        </p>
    </div>
</footer>