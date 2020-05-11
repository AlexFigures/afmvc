function showModalBoxLogin()
{
    $("#myModalBoxLogin").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#myModalBoxLogin").modal('show');
}

function showModalBoxRegister()
{
    $("#myModalBoxRegister").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#myModalBoxRegister").modal('show');

    checkUsername();
    checkEmail();
    checkPass();

}
function Login()
{
    $.ajax({
        type: "POST",
        async: false,
        url: MyHOSTNAME + '/login',
        data: "login=" + encodeURIComponent($("#login").val()) + "&pass=" + encodeURIComponent($("#pass").val()),
        success: function (response) {
        if(response.is_auth === false){
            $('#login').addClass('error');
            $('#pass').addClass('error');
            $('[data-toggle="popover"]').popover('show')
        }else if(response.is_auth === true){
            $('#login').addClass('success');
            $('#pass').addClass('success');
            $('[data-toggle="popover"]').popover('hide')
            setTimeout(function () {
                $("#myModalBoxLogin").modal('hide');
                window.location.reload();
            }, 1000)
        }

    }
    });
}

function Register(){
    $.ajax({
        type: "POST",
        async: false,
        url: MyHOSTNAME + '/login/reg',
        data: "rusername=" + encodeURIComponent($("#rusername").val()) + "&password=" + encodeURIComponent($("#password").val()) + "&remail=" + encodeURIComponent($("#remail").val()),
        success: function (response) {
            if(response.is_auth === true){
                $('#successfull').html('<h3 class="text-center ">Success!</h3>');
                $('#successfull').prop('hidden', false)
                setTimeout(function () {
                    $("#myModalBoxRegister").modal('hide');
                    window.location.reload();
                }, 1500)
            }

        }
    });

}

$('body').on('click', 'button#register', function(event) {
    event.preventDefault();
    if(checkReg() === 0) {
        Register();
    }
});

$('body').on('click', 'a#logout', function(event) {
    $.ajax({
        type: "POST",
        async: false,
        url: MyHOSTNAME + '/login/logout',
        success:function (html) {
            window.location.reload();
        }
    });
});

$(document).ready(function() {
    var url = window.location.href.substr( window.location.href.lastIndexOf( '/' ) + 0 );
    $('.nav-link').each( function () {
        if($(this).attr('href') === url){
            $(this).addClass('active');
        }
    });
});

function showModalBoxNewTask()
{
    $('#myModalBoxNewTask').modal({ //закрытие только по кнопке close
        backdrop: 'static',
        keyboard: false
    });
    $("#myModalBoxNewTask").modal('show');

    checkTaskEmail();
}

function showModalWinTask(str) {

    var temp = new Array();
    temp = str.split('~');

    $("#myModalBoxTask").modal('show');
    $("#mtid").text(temp[0]);
    $("#musr").text(temp[1]);
    $("#meml").text(temp[2]);
    $("#mdesc").text(temp[3]);
    $("#mdc").text(temp[4]);
    $("#mdu").text(temp[5]);
    $("#mtuid").val(temp[7]);

    if(temp[6] === 0) {
        $('#mst').text("Waiting");
        $('#editTask').prop("disabled", false);
        $('#doneTask').prop("disabled", false);
    } else if(temp[6] === 1) {
        $('#mst').text("Done");
        $('#editTask').prop("disabled", false);
        $('#doneTask').prop("disabled", true);
    }
}

function editDesc() {
    $('#mdesc').prop("disabled", false);
}

$('body').on('click', 'button#taskClose', function(event) {
    $('#mdesc').prop("disabled", true);
});

$('body').on('click', 'button#close', function(event) {
   $('#username').val('');
   $('#email').val('');
   $('#description').val('');
});

$('body').on('click', 'button#login', function(event) {
        Login();
});

$('body').on('click', 'button#newTask', function(event) {
    event.preventDefault();
    if(checkNewTask() === 0) {
     newTask();
     }
});

$('body').on('click', 'button#editTask', function(event) {
     editTask();
});

$('body').on('click', 'button#doneTask', function(event) {
     doneTask();
});

function newTask(){
    $.ajax({
        type: "POST",
        async: false,
        url: MyHOSTNAME + '/tasks/addTask',
        data: "mode=add_task" + "&username=" + encodeURIComponent($("#username").val()) + "&email=" + encodeURIComponent($("#email").val()) + "&desc=" + encodeURIComponent($("#description").val()),
       success: function(html) {
            window.location.reload();
        }
    });
}

function editTask() {
    $.ajax({
        type: "POST",
        async: false,
        url: MyHOSTNAME + '/tasks/editTask',
        data: "mode=edit_task" + "&tuid=" + encodeURIComponent($("#mtuid").val()) + "&desc=" + encodeURIComponent($("#mdesc").val()),
        success: function(html) {
            window.location.reload();
        }
    });
}

function doneTask() {
    $.ajax({
        type: "POST",
        async: false,
        url: MyHOSTNAME + '/tasks/doneTask',
        data: "mode=done_task" + "&tuid=" + encodeURIComponent($("#mtuid").val()),
        success: function(html) {
            window.location.reload();
        }
    });
}

function checkNewTask(){
    var error_code = 0;

     if($('#email').val().length === 0){
        $('#email').addClass('error');
        $('[data-toggle="popover"]').popover('show');
        setTimeout(function () {
            $('#email').removeClass('error');
        }, 1000)
        error_code = 1;
     };
    if ($('#username').val().length === 0) {
        error_code = 1;
        $('#username').addClass('error');
        setTimeout(function () {
            $('#username').removeClass('error');
            }, 1000)

    };
    if(checkTaskEmail() === true){
        error_code = 0;
    }
    if(checkTaskEmail() === false){
        error_code = 1;
    }

    return error_code;
}
$('body').on('click', 'button#register', function(event) {
    event.preventDefault();
    if(checkReg() === 0) {
        Register();
    }
});

function checkTaskEmail() {
    var regexp = /^[a-z0-9_-]+@[a-z0-9-]+\.([a-z]{1,6}\.)?[a-z]{2,6}$/i;
    var mail = $('#email');
    mail.keyup(function() {
        if (mail.val().length !== 0) {
            if (mail.val().search(regexp) === 0) {
                mail.removeClass('error').addClass('success');
                mail.popover('hide')
                return true;
            } else {
                mail.addClass('error');
                mail.popover('show');
                setTimeout(function () {
                    mail.removeClass('error');
                }, 1000)
                return false;
            }
        }
    });
}



function checkPass() {
    $("#password2").keyup(function() {
        var pass1 = $('#password');
        var pass2 = $('#password2');

        if(pass1.val() === pass2.val()){
            pass1.addClass('success');
            pass2.addClass('success');
            pass2.popover('hide');
            return true;
        } else {
            pass2.addClass('error');
            pass2.popover('show');
            return false;
        }
    });

}

function checkUsername() {
    $("#rusername").keyup(function() {
        var count = $(this).val().length;
        $('#uapp').prop('hidden', true);
        if(count >= 6){
            $.ajax({
                type: "POST",
                async: false,
                url: MyHOSTNAME + '/login/reg',
                data: "mode=checkLogin" + "&rusername=" + encodeURIComponent($("#rusername").val()),
                dataType: "json",
                success: function (response) {
                    if(response.checkLogin === false){
                        $("#rusername").removeClass('success').addClass('error');
                        $("#rusername").popover('show')
                    }else if(response.checkLogin === true){
                        $("#rusername").removeClass('error').addClass('success');
                        $("#rusername").popover('hide');
                    }
                }
            });
        }
    });

}

function checkEmail() {
    var regexp = /^[a-z0-9_-]+@[a-z0-9-]+\.([a-z]{1,6}\.)?[a-z]{2,6}$/i;
    var mail = $('#remail');

    mail.keyup(function() {
        if (mail.val().length !== 0) {
            if (mail.val().search(regexp) === 0) {
                $('#eapp').prop('hidden', true);
                var count = mail.val().length;
                if(count >= 6){
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: MyHOSTNAME + '/login/reg',
                        data: "mode=checkEmail" + "&remail=" + encodeURIComponent($("#remail").val()),
                        dataType: "json",
                        success: function (response) {
                            if(response.checkEmail === false){
                                $("#remail").removeClass('success').addClass('error');
                                $("#remail").popover('show');
                                return false;
                            }else if(response.checkEmail === true){
                                $("#remail").removeClass('error').addClass('success');
                                $("#remail").popover('hide');
                                return true;
                            }
                        }
                    });
                }
            } else {
                mail.addClass('error');
                $('#eapp').html('<small class="small text-danger">Please enter correct email!</small>');
                return false;
            }
        }
    })
}

function checkReg(){
    var error_code = 0;
    var mail = $('#remail');

    if(mail.val().length === 0){
        mail.addClass('error');
        $('#eapp').html('<small class="small text-danger">Please fill this field</small>');
        setTimeout(function () {
            mail.removeClass('error');
        }, 2000)
        error_code = 1;
    };
    if ($('#rusername').val().length === 0) {
        error_code = 1;
        $('#rusername').addClass('error');
        $('#uapp').html('<small class="small text-danger">Please fill this field</small>');
        setTimeout(function () {
            $('#rusername').removeClass('error');
        }, 1000)

    };

    if(checkPass() === true){
        error_code = 0;
    }
    if(checkPass() === false){
        error_code = 1;
    }
    if(checkEmail() === true){
        error_code = 0;
    }
    if(checkEmail() === false){
        error_code = 1;
    }


    return error_code;
}