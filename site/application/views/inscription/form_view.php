<script type="text/javascript" src="<?php echo js_url('inscription');?>"></script>
<script type="text/javascript">
    <!--
        var load_ajax = '<?php echo img_url('ajax-loader.gif');?>';
        var valid_ajax = '<?php echo img_url('ajax-valid.png');?>';
        var error_ajax = '<?php echo img_url('ajax-error.png');?>';
    -->
</script>
<link href="<?php echo css_url('inscr.style'); ?>.css" rel="stylesheet" />

<div id="inscr_tooltip">
    <div id="inscr_tooltip_left">&nbsp;</div>
    <div id="inscr_tooltip_right"></div>
</div>

<div style="text-align:center;height:100%;">
    <?php
        echo '
            <div class="center_content">',
                form_open('inscription/finalize',array(
                    'onsubmit' => 'return checkForm(this,\''.site_url('inscription/checknom').'\',\''.$nom['nom'].'\',
                        \''.site_url('inscription/checkmdp').'\',\''.$mdp['nom'].'\',
                        \''.$mdp_conf['nom'].'\',\''.$mdp['nom'].'\',
                        \''.site_url('inscription/checkmail').'\',\''.$mail['nom'].'\');return false;'
                )),'
                    <fieldset>
                        <legend>Informations personnelles</legend>
                        ',form_label($nom['value'],$nom['nom']),'
                        ',form_input(array(
                            'name'          =>$nom['nom'],
                            'id'            =>$nom['nom'],
                            'value'         =>'',
                            'onfocusout'    => 'checkNom(\''.site_url('inscription/checknom').'\',\''.$nom['nom'].'\');'
                            )),'
                            <img src="" id="inscr_nom_ajax_img" />
                        ',form_error($nom['nom']),'<br />
                        ',form_label($mdp['value'],$mdp['nom']),' 
                        ',form_password(array(
                            'name'          => $mdp['nom'],
                            'id'            => $mdp['nom'],
                            'value'         => '',
                            'onfocusout'    => 'checkMdp(\''.site_url('inscription/checkmdp').'\',\''.$mdp['nom'].'\');'
                            )),'
                             <img src="" id="inscr_mdp_ajax_img" />
                        ',form_error($mdp['nom']),'<br />
                        ',form_label($mdp_conf['value'],$mdp_conf['nom']),' 
                        ',form_password(array(
                            'name'          => $mdp_conf['nom'],
                            'id'            => $mdp_conf['nom'],
                            'value'         => '',
                            'onfocusout'    => 'checkMdpConf(\''.$mdp_conf['nom'].'\',\''.$mdp['nom'].'\');'
                            )),'
                            <img src="" id="inscr_mdp_conf_ajax_img" />
                        ',form_error($mdp_conf['nom']),'<br />
                        ',form_label($mail['value'],$mail['nom']),' 
                        ',form_input(array(
                            'name'          => $mail['nom'],
                            'id'            => $mail['nom'],
                            'value'         => '',
                            'onfocusout'    => 'checkMail(\''.site_url('inscription/checkmail').'\',\''.$mail['nom'].'\');'
                            )),'
                             <img src="" id="inscr_mail_ajax_img" />
                        ',form_error($mail['nom']),'
                    </fieldset>
                    <fieldset>
                        <legend>Informations de jeu</legend>
                        ',form_label($camps['value'],$camps['nom']),'
                        ',form_dropdown($camps['nom'], $camps_list,'',
                            'id="'.$camps['nom'].'"
                            onchange="armee_set_race(this.options[this.selectedIndex].value);"'
                        ),'<br />
                        ',form_label($ordre['value'],$ordre['nom']),'
                        ',form_dropdown($ordre['nom'], array(),'',
                            'id="'.$ordre['nom'].'"
                            onchange="armee_set_ordre(this.options[this.selectedIndex].value);"'
                        ),'<br />
                        ',form_label($armee['value'],$armee['nom']),'
                        ',form_dropdown($armee['nom'], array(),'','
                            id="'.$armee['nom'].'"
                            onchange="armee_set_armee(this.options[this.selectedIndex].value);"'
                        ),'<br />
                            <br />
                            Description :
                        <p id="inscr_descr"></p>
                    </fieldset>
                        <br /><br />
                    ',  form_submit('','Valider'),'
                ',form_close(),'
            </div>';
    ?>
</div>

<script type="text/javascript">
    <!--
        var data = <?php echo json_encode($ordres);?>;
        armee_init(data, '<?php echo $camps['nom'];?>','<?php echo $ordre['nom'];?>','<?php echo $armee['nom'];?>');
    -->
</script>