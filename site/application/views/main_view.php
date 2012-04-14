<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title; ?></title>

        <meta name="description" content="My website" />
        <meta name="author" content="Benjamin Herbomez" />
        <script src="<?php echo js_url('jquery/jquery'); ?>"></script>
        <script src="<?php echo js_url('jquery/jquery.inherit'); ?>"></script>
        <script src="<?php echo js_url('jquery/jquery.websocket'); ?>"></script>
        <script src="<?php echo js_url('navig'); ?>"></script>  
    <?php 
    if($log)
        
        echo '	
        <script src="',js_url('chat'),'"></script>
        <script type="text/javascript">
            <!--
                $(window).ready(function(){
                
                    chat = init(\'ws://78.249.2.88:8088/\', '.$utilisateur_id.');
                    $(\'#chat0  .champs\').keypress(function(event) {
                        if(event.which == 13){
                            chat.send(
                                {
                                    action : \'send\',
                                    message : $(\'#chat0 .champs\').val()
                                }
                            );
                            $(\'#chat0  .champs\').val("");
                        }
                    });
                });
            -->
        </script>
';
    ?>
        
   
        
        <link href="<?php echo css_url('style'); ?>.css" rel="stylesheet" />


    </head>
    <body>
        <div id="logo">
           <?php echo anchor_intern('index/index/',img('logo.png'));?>
        </div>
        <div id="toolBox"> 
            <?php echo $views->toolBox; ?>
        </div>
        <div id="body">
            <?php echo $views->body; ?>
        </div>
        <?php 
             if(isset($log) && $log)
                echo '
    <div id="chat0" class="chat">
        <div class="chat_head">Broadcast</div>
        <div class="chat_middle">
            <div class="chat_response"></div>
            <div class="chat_bottom">
                <input type="text" class="champs"/>
            </div>
        </div>
    </div>';
        ?>
    </body>