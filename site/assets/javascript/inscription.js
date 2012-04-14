
function checkNom(cible, val, callBack){
    valid_field(cible, val, '#inscr_nom_ajax_img', callBack);
}

function checkMdp(cible, val, callBack){
    return valid_field(cible, val, '#inscr_mdp_ajax_img', callBack);
}

function checkMail(cible, val, callBack){
    return valid_field(cible, val, '#inscr_mail_ajax_img', callBack);
}

function valid_field(cible, val,img, callBack){
    $(img).attr('src',load_ajax);
    $.post(cible,
    {
        val : $('#'+val).val()
    },
    function(data) {
        if(data == 'true'){
            $(img).attr('src',valid_ajax);
            $('#inscr_tooltip').css('display','none');
            
            if(callBack)
                callBack(true);
            return;
        }
        
        $(img).attr('src',error_ajax);

        var pos = $(img).position();
        $('#inscr_tooltip_right').html(data);
        $('#inscr_tooltip').css('display','table-row');
        $('#inscr_tooltip').css('top',pos.top - 20);
        $('#inscr_tooltip').css('left',pos.left + 20);
        if(callBack)
            callBack(false);    
    });
}

function checkMdpConf(conf, orig, callBack){
    var img = '#inscr_mdp_conf_ajax_img'
    if($('#'+conf).val() != $('#'+orig).val()){
        $(img).attr('src',error_ajax);

        var pos = $(img).position();
        $('#inscr_tooltip_right').html("Les deux mots de passe sont différents");
        $('#inscr_tooltip').css('display','table-row');
        $('#inscr_tooltip').css('top',pos.top - 20);
        $('#inscr_tooltip').css('left',pos.left + 20);
        
        if(callBack)
            callBack(false);
        return;
    }
    
    $(img).attr('src',valid_ajax);
    $('#inscr_tooltip').css('display','none');

    if(callBack)
        callBack(true); 
}

function checkForm(form,cibleNom, valNom, cibleMdp, valMdp, conf, orig, cibleMail, valMail){
    
    checkNom(cibleNom, valNom, function(r1){
        if(r1)
            checkMdp(cibleMdp, valMdp, function(r2){
                if(r2)
                    checkMdpConf(conf, orig, function(r3){
                        checkMail(cibleMail, valMail, function(r4){
                            form.submit();
                        });
                    });
            });
    });
    return false;
}

/****
 * Gestion des ordres
 */

var armee_list  = null;
var race_id    = null;
var ordre_id    = null;
var armee_id    = null;

function armee_init(tbl, r_id, o_id, a_id){
    armee_list  = tbl;
    race_id     = '#'+r_id;
    ordre_id    = '#'+o_id;
    armee_id    = '#'+a_id;
    armee_set_race($(race_id).val());
}

function armee_set_race(race){
    $(ordre_id).find('option').remove();
    for(var v in armee_list[race]){
       $(ordre_id).append('<option value="'+v+'">'+armee_list[race][v]['nom']+'</option>')
    }
    armee_set_ordre($(ordre_id).val());
}

function armee_set_ordre(ordre){
    $(armee_id).find('option').remove();
    
    var race = $(race_id).val();
    
    for(var v in armee_list[race][ordre]['armee']){
       $(armee_id).append('<option value="'+v+'">'+armee_list[race][ordre]['armee'][v]['nom']+'</option>')
    }
    armee_set_armee($(armee_id).val());
}

function armee_set_armee(armee){
    var race    = $(race_id).val();
    var ordre   = $(ordre_id).val();
    $('#inscr_descr').html(armee_list[race][ordre]['armee'][armee]['descr']);
}