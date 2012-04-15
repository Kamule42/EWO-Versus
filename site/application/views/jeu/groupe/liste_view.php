<script type="text/javascript" src="<?php echo js_url('jquery/jquery.infieldlabel');?>"></script>
<script type="text/javascript" src="<?php echo js_url('groupe');?>"></script>

<script type="text/javascript">
    <!--
        var load_ajax = '<?php echo img_url('ajax-loader.gif');?>';
        var valid_ajax = '<?php echo img_url('ajax-valid.png');?>';
        var error_ajax = '<?php echo img_url('ajax-error.png');?>';
    -->
</script>


<div class="left_panel">
    <div class="content_padding">
    <h3>Mes groupes</h3>
        <?php
            foreach($groupes as $g){
                echo '
            ',
            anchor_intern('jeu/groupe/view_groupe/'.$g->getId(),$g->getNom()) ,'<br />';
            }
        ?> 
            <br />
            <hr />
            nouveau groupe : <br /><br />
            
            <?php 
                echo form_open('jeu/groupe/creer',
                array(
                    'onsubmit' => '
                        checkForm(\'groupeForm\',\''.site_url('jeu/groupe/checknom').'\',\'nom\');
                        return false;',
                    'id' => 'groupeForm'
                )),'
                    
                    <p>
                    ',form_input(array(
                        'name'          => 'nom',
                        'id'            => 'nom',
                        'value'         => '',
                        'onfocusout'    => 'checkNom(\''.site_url('jeu/groupe/checknom').'\',\'nom\');'
                        )),'
                    ',form_label('Nom','nom'),'
                        <img src="" id="creer_nom_ajax_img" />
                        
                    ',form_submit('','Créer'),' <br />
                    <span class="error">',form_error('nom'),'</span>
                        
                    </p>
                ',form_close();
            ?>
        </ul>
    </div>
</div>

<script type="text/javascript">
<!--
$(document).ready(function(){
    $("label").inFieldLabels();
});
-->
</script>
