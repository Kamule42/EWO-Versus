function checkNom(cible, val, callBack){
    valid_field(cible, val, '#creer_nom_ajax_img', callBack);
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
            
            if(callBack)
                callBack(true);
            return;
        }
        
        $(img).attr('src',error_ajax);
        $('#groupeForm .error').html(data);
        
        if(callBack)
            callBack(false);    
    });
}

function checkForm(f,cibleNom, valNom){ 
    form = $('#'+f);
    checkNom(cibleNom, valNom, function(r1){
        if(r1){     
            $.post(form.attr('action'),
            {
                nom : $('#'+valNom).val()
            },
            function(data){
                anchor_intern(window.location.href);  
            });
        }
    });
    return false;
}

