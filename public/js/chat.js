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
        var id = $('#content-frame').find('.trpChatItemContainer:last').attr('data-msgId');
        if (id > 0){
            $.ajax({
                url: "/message/getMessages",
                type: "post",
                data: {
                    lastId: id
                },
                dataType: "json",
                success: function(data) {
                    if (data.status == 'success' && data.html.length > 0){
                        $('.trpChatContainer').append(data.html);
                        $("#content-frame").scrollTop($("#content-frame")[0].scrollHeight);
                    } else {
                        // need add handler errors
                    }
                }
            });
        }
    },
    gatActualUsersList: function(){
        $.ajax({
            url: "/users/getActualUsers",
            type: "post",
            dataType: "json",
            success: function(data) {
                if (data.status == 'success'){
                    $('#people-roster div').html(data.html);
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
        // Get actual users every 20 seconds
        setInterval(Chat.gatActualUsersList, 20000);
        // fixme: dirty hack
        setTimeout('$("#content-frame").scrollTop($("#content-frame")[0].scrollHeight)', 100);
    }
};

$(document).ready(function(){
    Chat.init();
});