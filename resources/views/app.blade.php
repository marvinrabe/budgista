<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.analytics') }}"></script>
    <script src="https://browser.sentry-cdn.com/5.12.1/bundle.min.js"
            integrity="sha384-y+an4eARFKvjzOivf/Z7JtMJhaN6b+lLQ5oFbBbUwZNNVir39cYtkjW1r6Xjbxg3"
            crossorigin="anonymous"></script>
    <script>
      window.dataLayer = window.dataLayer || []

      function gtag () {dataLayer.push(arguments)}

      gtag('js', new Date())
      Sentry.init(@json(['dsn' => config('services.sentry')]))
    </script>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet"></link>
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" sizes="57x57" href="/images/icons/apple-touch-icon-57x57.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="/images/icons/apple-touch-icon-114x114.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="/images/icons/apple-touch-icon-72x72.png"/>
    <link rel="apple-touch-icon" sizes="144x144" href="/images/icons/apple-touch-icon-144x144.png"/>
    <link rel="apple-touch-icon" sizes="60x60" href="/images/icons/apple-touch-icon-60x60.png"/>
    <link rel="apple-touch-icon" sizes="120x120" href="/images/icons/apple-touch-icon-120x120.png"/>
    <link rel="apple-touch-icon" sizes="76x76" href="/images/icons/apple-touch-icon-76x76.png"/>
    <link rel="apple-touch-icon" sizes="152x152" href="/images/icons/apple-touch-icon-152x152.png"/>
    <meta name="application-name" content="Budgista"/>
    <meta name="theme-color" content="#ffffff"/>
    <meta name="msapplication-TileColor" content="#ffffff"/>
    <meta name="msapplication-TileImage" content="mstile-144x144.png"/>
    <link rel="mask-icon" href="/images/icons/safari-pinned-tab.svg" color="#339af0"/>
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <title>{{ config('app.name') }}</title>
</head>
<body>
@inertia
@paddle
<noscript>
    <div class="w-full h-full flex items-center justify-center">
        <div class="border-t-4 border-red-8 rounded-b inline-block m-6 p-6 bg-white shadow" role="alert">
            <span class="font-bold mb-6 text-lg">{{ __('JavaScript is disabled.') }}</span>
            <p>{{ __('Please enable JavaScript to use Budgista.') }}</p>
        </div>
    </div>
</noscript>
@auth
    <script>!function (w, d, i, s) {
        function l () {
          if (!d.getElementById(i)) {
            var f = d.getElementsByTagName(s)[0], e = d.createElement(s)
            e.type = 'text/javascript', e.async = !0, e.src = 'https://canny.io/sdk.js', f.parentNode.insertBefore(e, f)
          }
        }

        if ('function' != typeof w.Canny) {
          var c = function () {c.q.push(arguments)}
          c.q = [], w.Canny = c, 'complete' === d.readyState ? l() : w.attachEvent ? w.attachEvent('onload', l) : w.addEventListener('load', l, !1)
        }
      }(window, document, 'canny-jssdk', 'script')</script>
    <script>
      Canny('identify', {
        appID: '5e5e763047312543ec5d137b',
        user: {
          email: "{{ auth()->user()->email }}",
          name: "{{ auth()->user()->name }}",
          id: "{{ auth()->user()->id }}"
        },
      })
    </script>
@endauth
</body>
</html>
