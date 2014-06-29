/**
 * Utils for project
 *
 * @author Sintsov Roman <roman_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

$(function(){
    var hash = window.location.hash;
    hash && $('ul.nav a[href="' + hash + '"]').tab('show');

    if (!hash){
        var $login = $('ul.nav a[href="#login"]');
        if ($login.length > 0){
            $login.tab('show');
        }
    }

    $('#auth-panel a').click(function (e) {
        //e.preventDefault();
        $('.alert').remove();
        $(this).tab('show');
        window.location.hash = this.hash;
    });

    $('body').tooltip({
        selector: '.trpDisplayPicture',
        placement: 'left'
    });

    $("#content-frame").scrollTop($("#content-frame")[0].scrollHeight);

    $('#left-menu-profile').click(function(){
        $('#avatarLoad').toggle();
    });

    $('#fileupload').fileupload({
        url: 'users/changeAvatar',
        dataType: 'json',
        done: function (e, data) {
           var response = data.result;
            if (response.status == 'success'){
                $('.trpLeftMenuProfileHeader .avatar').css('background-image', 'url("' + response.img + '")');
            }
        }
    });

});