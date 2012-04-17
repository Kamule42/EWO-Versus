<script type="text/javascript" src="<?php echo js_url('jquery/jquery.ui');?>"></script>
<script type="text/javascript">
    <!--
    $(document).ready(function() {
        
        $('#grp_show_add').click(function(){
            $('#grp_right').toggle('slide',{direction:'right'},500);
        });
        $('#grp_right_collapse').click(function(){
            $('#grp_right').toggle('slide',{direction:'right'},500);
        });
    });
    -->
</script>
<div id="grp_right" class="grp_ajouter cell">
    <div class="table">
        <div class="row">
            <div id="grp_right_collapse" class="cell"> <a href="#" onclick="return false;">>></a> </div>
            <div class="cell content_padding">
                <table class="grp_tbl">
                    <thead>
                        <th>Type</th>
                        <th><acronym title="Point de Vite">PV</acronym></th>
                        <th>mouv</th>
                        <th>force</th>
                        <th>des</th>
                        <th><acronym title="nombre d'attaques">atk</acronym></th>
                        <th>coût</th>
                    </thead>
                    <?php 
                    foreach($dispo as $u){
                        echo '
                    <tr>
                        <td>',$u->getUnite(),'</td>
                        <td class="grp_tbl_center">',$u->getPv(),'</td>
                        <td class="grp_tbl_center">',$u->getMouv(),'</td>
                        <td class="grp_tbl_center">',$u->getForce(),'</td>
                        <td class="grp_tbl_center">',$u->getDes(),'</td>
                        <td class="grp_tbl_center">',$u->getAtk(),'</td>
                        <td class="grp_tbl_center">',$u->getCout(),'</td>
                        <td class="grp_tbl_center">',form_radio('add_unite_to_groupe_radio',$u->getId()),'</td>
                    </tr>';
                    }
                    ?>
                    <tfoot>
                        <th colspan="8" class="grp_tbl_right">
                            <?php
                            echo form_open('jeu/groupe/ajouter',
                                    array(
                                        'class' => 'form_ajouter_unite'
                                    )),'

                                ',form_label('Nom','ajouter_nom'),'
                                ',form_input(array(
                                    'name'          => 'ajouter_nom',
                                    'id'            => 'ajouter_nom',
                                    'value'         => '',
                                    'onfocusout'    => 'checkNom(\''.site_url('jeu/groupe/checknom').'\',\'ajouter_nom\');'
                                    )),'
                                    <img src="" id="ajouter_nom_ajax_img" />

                                ',form_submit('','Ajouter'),' <br />
                                <span class="error">',form_error('nom'),'</span>

                            ',form_close();
                            ?>
                        </th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
   nouveau
</div>
<div class="right_content">
    <div class="table">
        <div class="row">
            <div id="grp_left" class="content_padding cell">
                <div id="grp_show_add" class="content_padding" style="float:right;">
                    <a href="#" onclick="return false;">Ajouter une unité</a>
                </div>
                <table class="grp_tbl">
                    <thead>
                    <th style="width:110px"></th>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>coût</th>
                    </thead>
                    <?php
                    $cout = 0;
                    foreach ($unites as $u) {
                        $cout += $u->getCout();
                        echo '
        <tr> 
            <td rowspan="2">', img('unite/' . $u->getId() . '.png'), '</td>
            <td rowspan="2">', $u->getNom(), '</td>
            <td>', $u->getUnite(), '</td>
            <td class="grp_tbl_center"  rowspan="2">', $u->getCout(), '</td>
            <td class="grp_tbl_center" rowspan="2">supprimer</td>
        </tr>
        <tr>
            <td>truc</td>
        </tr>';
                    }
                    echo '
        <tfoot>
            <th></th>
            <th></th>
            <th class="grp_tbl_center">Total :</th>
            <th class="grp_tbl_center">', $cout, '</th>
        </tfoot>';
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

