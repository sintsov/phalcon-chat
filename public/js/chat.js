/**
 * Chat frontend functional
 *
 * @author Sintsov Roman <romiras_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

var Chat = {
    send: function(element){
        var $textarea = $(element);
        var msg = $textarea.val();

        if (msg == ''){
            return false;
        } else {
            $.ajax({
                url: "/message/send",
                type: "post",
                data: {
                    message: msg
                },
                dataType: "json",
                success: function(data) {
                    if (data.status == 'success'){
                        $textarea.val('');
                        $('.trpChatContainer').append(data.html);
                        $("#content-frame").scrollTop($("#content-frame")[0].scrollHeight);
                    } else {
                        // need add handler errors
                    }
                }
            });
        }
        return true;
    },
    getMessagesList: function(){
        $.ajax({
            url: "/message/getMessages",
            type: "post",
            dataType: "json",
            success: function(data) {
                if (data.status == 'success'){
                    $('.trpChatContainer').append(data.html);
                    $("#content-frame").scrollTop($("#content-frame")[0].scrollHeight);
                } else {
                    // need add handler errors
                }
            }
        });
    },
    init: function(){
        $('#chat-input-textarea').keydown(function (e) {
            if (e.ctrlKey && e.keyCode == 13) {
                Chat.send(this);
            }
        });

        // Get users messages every 10 seconds
        setInterval(Chat.getMessagesList, 10000);

    }
};

$(document).ready(function(){
    Chat.init();
});