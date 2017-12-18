@extends('layouts.base',  ['body_class' => 'layout-budget', 'style' => 'css/app.css'])

@section('body')

    <div id="app">

        <app-layout></app-layout>

    </div>

    @if(config('app.env') == 'production')
        <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=default,Intl.~locale.{{ app()->getLocale() }}"></script>
    @endif

    <script src="{{ mix('js/app.js') }}"></script>

    <script>
        /*<![CDATA[*/window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(e){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var e=this.createElement("script");n&&(this.domain=n),e.id="js-iframe-async",e.src="https://assets.zendesk.com/embeddable_framework/main.js",this.t=+new Date,this.zendeskHost="budgista.zendesk.com",this.zEQueue=a,this.body.appendChild(e)},o.write('<body onload="document._l();">'),o.close()}();
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

@endsection