{extends file='parent:frontend/index/header.tpl'}

{block name="frontend_index_header_javascript_modernizr_lib" append}
    {literal}
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){
                n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js'); 
        fbq('init', '482403265427912'); 
        {/literal}
        {$fbBaseCode}
            {$fbEventCode}
        {literal}
      </script>
    <noscript> <img height="1" width="1" src="https://www.facebook.com/tr?id=482403265427912&ev=PageView&noscript=1"/></noscript><!-- End Facebook Pixel Code -->
    {/literal}
{/block}