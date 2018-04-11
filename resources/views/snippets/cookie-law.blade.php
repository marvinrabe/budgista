<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
<script>
    window.addEventListener("load", function(){
        window.cookieconsent.initialise({
            "palette": {
                "popup": {
                    "background": "#f4f5f6",
                    "text": "#919fab"
                },
                "button": {
                    "background": "#39434b"
                }
            },
            "theme": "edgeless",
            "content": {
                "message": "{{ trans('static.cookie.message') }}",
                "dismiss": "{{ trans('static.cookie.dismiss') }}",
                "link": "{{ trans('static.cookie.link') }}",
                "href": "/privacy"
            }
        })});
</script>