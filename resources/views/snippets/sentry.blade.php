@if(config('app.env') == 'production')
    <script src="https://cdn.ravenjs.com/3.25.2/raven.min.js" crossorigin="anonymous"></script>
    <script>
        Raven.config('{{ config('services.sentry.browser') }}').install()
    </script>
@endif
