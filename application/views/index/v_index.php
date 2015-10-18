<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
    <meta charset='utf-8'/>
    <title><?=$site_name?> | <?=$page_title?></title>
    <meta http-equiv='Content-Language' content='ru'/>
    <meta name='description' content='<?=$site_description?>'/>
    <meta name='keywords' content='кран-манипулятор, Харьков'/>
    <meta name='copyright' content='ITlux'/>
    <link rev='made' href='mailto:v@sinenko.in.ua'/>
    
<?php 
    foreach ($styles as $file_style){
        echo HTML::style($file_style);
    }

foreach ($scripts as $file_script){
        echo HTML::script($file_script);
    }
?>  
</head>

<body>
<div id='container'>   
   <!-- Верхний блок-->        
        <?php
        if (isset($block_header))
        {
            foreach ($block_header as $hblock)
            {
                echo$hblock;
            }
        }
        ?>        
    <!-- /Верхний блок-->
    <div id='doun'>
    </div>
    <div id='main'>
    
        <div id="pages_list">
        <!-- Центральный блок-->
        <?php
        if (isset($block_center))
        {
            foreach ($block_center as $cblock)
            {
                echo$cblock;
            }
        }
        ?>        
        <!-- /Центральный блок-->
        </div>
        
    </div>
    <div id='doun'> 
    </div>
    <div id='footer'>
        <!-- Нижний блок-->
        <?php
        if (isset($block_footer))
        {
            foreach ($block_footer as $fblock)
            {
                echo$fblock;
            }
        }
        ?>        
        <!-- /Нижний блок--> 
    </div>
</div>

<!-- Yandex.Metrika informer -->
<a href="https://metrika.yandex.ru/stat/?id=30842316&amp;from=informer"
target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/30842316/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:30842316,lang:'ru'});return false}catch(e){}"/></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter30842316 = new Ya.Metrika({id:30842316,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/30842316" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>