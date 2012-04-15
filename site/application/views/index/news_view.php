
<div style="padding:40px;">
    <h2>News</h2>
    <?php 
    foreach($news as $k => $v){
        echo '
        <div class="news">
            <div class="news_titre">',$v->titre,'</div>
            <div><p>',nl2br($v->corps),'</p></div>
        </div>';
    }
    ?>
</div>
