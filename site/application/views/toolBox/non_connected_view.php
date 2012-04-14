<?php
    if(isset($wrap) && $wrap == true)
        echo '
        <div style="text-align:center;height:100%;">
            <div class="center_content">
            ';
    if(isset($error))
        echo '<p style="text-align:center"><strong>',$error,'</strong></p>';
    echo form_open('connexion/connect'),' 
            <div id="log">
                <div id="log_info">
                    ',form_label($nom['value'],$nom['nom']),'
                    ',form_input(array('name'=>$nom['nom'],'value'=>set_value($nom['nom']))),'
                    ',form_error($nom['nom']),'<br />
                    ',form_label($mdp['value'],$mdp['nom']),' 
                    ',form_password(array('name'=>$mdp['nom'],'value'=>'')),'
                    ',form_error($mdp['nom']),'
                </div>';
                echo
                form_submit('','Connexion'),' <br />
                <span class="mini"> Pas de compte ? </span>',
                        anchor_intern('inscription/index','S\'inscire'),
                        '<br />
                ',anchor_intern('connexion/retrouver_mdp','Mot de passe oubli&eacute;'),'
            </div>
        ',form_close(),'
            ';
    if(isset($wrap) && $wrap == true)
        echo '
            </div>
        </div>
            ';
?>
