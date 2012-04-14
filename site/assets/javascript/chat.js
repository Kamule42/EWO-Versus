var socket;
function init(h,i){
    var chat = $.websocketsClient(
        {
            host        : h, 
            appli       : 'chat', 
            onOpen      : function(msg){
                $.post( '/versus/client/chat/gen_token',
                function(data){
                        chat.send(
                            {
                                action : 'log',
                                token : data,
                                id : i
                            }
                        );
                    }
                );
            },
            onMessage      : function(msg){
                var r = $.parseJSON(msg);
                $('#chat0  .chat_response').append(
                "<span class='chat_name'>"+r.name+"</span> : "+
                    r.message+"<br />");
                
                $('#chat0  .chat_response').animate({scrollTop: $('#chat0  .chat_response')[0].scrollHeight});
            },
            onClose      : function(msg){}
        }
    );
    
    
    $('#chat0 > .chat_head').click(function(){
       $(this).parent().children('.chat_middle').toggle(); 
    });
    return chat;
}