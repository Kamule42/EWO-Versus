<link href="<?php echo css_url('jeu.groupe.liste.style'); ?>.css" rel="stylesheet" />

<div class="left_panel">
    <div class="content_padding">
    <h3>Mes groupes</h3>
        <ul class="liste_groupe">
        <?php
            foreach($groupes as $g){
                echo '
            <li>',$g->getNom(),'</li>';
            }
        ?> 
            <li><br /></li>
            <li>nouveau groupe</li>
        </ul>
    </div>
</div>