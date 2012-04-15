<link href="<?php echo css_url('index.style'); ?>.less" rel="stylesheet/less" type="text/css" />

<script type="text/javascript">
$(window).load(function(){
    var current = $('.index_right_link_selected');
    $('#index_right').mouseleave(function(){
        current.addClass('index_right_link_selected');
    });
    $('.index_right_link_img').mouseover(function(){
        current.removeClass('index_right_link_selected');
    });
});
</script>

<div id="index_right">
    <div class="index_right_link <?php if(isset($pres_select))echo 'index_right_link_selected';?>">
        <div class="index_right_link_img">&nbsp;</div>
        <?php echo anchor_intern('index/index/','Présentation','class="index_right_link_txt"');?>
    </div>
    <div class="index_right_link <?php if(isset($news_select))echo 'index_right_link_selected';?>">
        <div class="index_right_link_img">&nbsp;</div>
        <?php echo anchor_intern('index/news/','News','class="index_right_link_txt"');?>
    </div>
</div>
<div id="index_main">
    <?php echo $content;?>
</div>
