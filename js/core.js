function showModalBoxLogin()
{
    $("#myModalBoxLogin").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#myModalBoxLogin").modal('show');
}

function Login()
{
    $.ajax({
        type: "POST",
        async: false,
        url: MyHOSTNAME + '/login',
        data: "login=" + encodeURIComponent($("#login").val()) + "&pass=" + encodeURIComponent($("#pass").val()),
        success: function (response) {
        if(response.is_auth == false){
            $('#login').addClass('error');
            $('#pass').addClass('error');
            $('[data-toggle="popover"]').popover('show')
        }else if(response.is_auth == true){
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

    if(temp[6] == 0) {
        $('#mst').text("Waiting");
        $('#editTask').prop("disabled", false);
        $('#doneTask').prop("disabled", false);
    } else if(temp[6] == 1) {
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
    if(checkNewTask() == 0) {
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
    var regexp = /^[a-z0-9_-]+@[a-z0-9-]+\.([a-z]{1,6}\.)?[a-z]{2,6}$/i;
    var mail = $('#email');

    if ($('#email').val().length !== 0) {
        if($('#email').val().search(regexp) == 0){
           $('#email').removeClass('error').addClass('success');
        }else{
            $('#email').addClass('error');
            error_code = 1;
        }
    } else if($('#email').val().length == 0){
        $('#email').addClass('error');
        error_code = 1;
    };
    if ($('#username').val().length == 0) {
        error_code = 1;
        $('#username').addClass('error');
    };

    return error_code;
}