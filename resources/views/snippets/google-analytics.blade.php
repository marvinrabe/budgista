<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.analytics') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', '{{ config('services.analytics') }}');

    function gtag_report_conversion() {
        gtag('event', 'conversion', {
            'send_to': 'AW-1036513577/9wnvCMyGu3oQqeKf7gM'
        });
    }
</script>