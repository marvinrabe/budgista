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
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <title>{{ config('app.name') }}</title>
</head>
<body>
@inertia
<noscript>
    <div class="w-full h-full flex items-center justify-center">
        <div class="border-t-4 border-red-8 rounded-b inline-block m-6 p-6 bg-white shadow" role="alert">
            <span class="font-bold mb-6 text-lg">{{ __('JavaScript is disabled.') }}</span>
            <p>{{ __('Please enable JavaScript to use Budgista.') }}</p>
        </div>
    </div>
</noscript>
</body>
</html>
