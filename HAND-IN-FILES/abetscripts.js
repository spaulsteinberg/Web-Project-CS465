$(document).ready(function(){
    $("#profile").click(function(){
        if($("#userMenu").css("display")=="none"){
            $("#userMenu").css("display", "block");
        } else {
            $("#userMenu").css("display", "none");
        }
    });

    $("#logout").click(function(){
        $(location).attr('href',"login.html");
    });

    $("#changePassword").click(function(){
        if($(".main-content").css("display")!="none"){
            $(".main-content").css("display", "none");
            $(".password-content").css("display", "block");
        }
    });
});