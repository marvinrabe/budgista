<!DOCTYPE html>
<html lang="{{ auth()->user()->language }}">
<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.analytics') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '{{ config('services.analytics') }}');
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="alternate" hreflang="x-default" href="{{ route('app') }}" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('images/apple-touch-icon-57x57.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/apple-touch-icon-114x114.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/apple-touch-icon-72x72.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/apple-touch-icon-144x144.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ asset('images/apple-touch-icon-120x120.png') }}"/>
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ asset('images/apple-touch-icon-152x152.png') }}"/>

    <link rel='mask-icon' href='{{ asset('images/icon.svg') }}' color='#007BFF'>
    {{--
    Enables web app support. Only useful when Navigation between pages not via links
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    + android manifest
    --}}
    <meta name="application-name" content="{{ config('app.name') }}"/>

    <meta name="msapplication-TileColor" content="#007BFF"/>
    <meta name="msapplication-TileImage" content="{{ asset('images/mstile-144x144.png') }}"/>

    <title>{{ config('app.name') }}</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>
<body>

<div id="app">

    <app-layout></app-layout>

</div>

@if(config('app.env') == 'production')
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=default,Intl.~locale.{{ auth()->user()->language }}"></script>
@endif

<script>
    /*<![CDATA[*/
    window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(e){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var e=this.createElement("script");n&&(this.domain=n),e.id="js-iframe-async",e.src="https://assets.zendesk.com/embeddable_framework/main.js",this.t=+new Date,this.zendeskHost="budgista.zendesk.com",this.zEQueue=a,this.body.appendChild(e)},o.write('<body onload="document._l();">'),o.close()}();
    /*]]>*/
</script>
<script>
    zE(function() {
        zE.hide();
        zE.setLocale('{{ auth()->user()->language }}');
        zE.identify(
            @json(['name' => auth()->user()->name, 'email' => auth()->user()->email])
        );
    });
</script>
<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
