<?php ?>

<div class="content_padding right_content">
    <table class="grp_tbl">
        <thead>
            <th style="width:110px"></th>
            <th>Nom</th>
            <th>Type</th>
            <th>coût</th>
        </thead>
     <?php
        $cout = 0;
            foreach($unites as $u){
                $cout += $u->getCout();
                echo '
        <tr> 
            <td>', img('unite/'.$u->getId().'.png'),'</td>
            <td>',$u->getNom(),'</td>
            <td>',$u->getUnite(),'</td>
            <td class="grp_tbl_center">',$u->getCout(),'</td>
        </tr>';
            }
            echo '
        <tfoot>
            <th></th>
            <th></th>
            <th class="grp_tbl_center">Total :</th>
            <th class="grp_tbl_center">',$cout,'</th>
        </tfoot>';
        ?>
    </table>
    <div class="grp_ajouter">
        Ajouter une unité
    </div>
    <div class="grp_nouveau">coucou</div>
</div>

