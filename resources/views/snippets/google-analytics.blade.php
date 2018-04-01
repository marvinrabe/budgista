<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.analytics') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', '{{ config('services.analytics') }}');
</script>