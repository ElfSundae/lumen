@if (config('services.google_analytics.id'))
<script>
  setTimeout(function() {
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', "{{ config('services.google_analytics.id') }}", "{{ config('services.google_analytics.cookie_domain') ?: 'auto' }}", {'allowLinker': true});
    ga('require', 'linker');
    ga('send', 'pageview');
  }, 0)
</script>
@endif
