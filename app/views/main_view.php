<html>
    <head class="header">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="/vendor/datatables/datatables.min.css">
        <link rel="stylesheet" href="/vendor/fontawesome/css/all.css">
        <title>Task App</title>
    </head>
<body>
	<script src="/vendor/jquery/jquery.min.js"></script>
	<script src="/vendor/fontawesome/js/all.js"></script>
	<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="/vendor/datatables/datatables.min.js"></script>
  <script> var  MyHOSTNAME  = "<? global $JS_conf_arr; echo $JS_conf_arr['MyHOSTNAME'] ?>";</script>

    <nav class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
        <a class="navbar-brand" href="/about">Test App</a>
        <?php if (!Auth::isAuth()){ ?>
            <div class="dropdown show">
                <button class="btn btn-secondary btn-sm btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <a class="dropdown-item" href="#" onclick="showModalBoxLogin(); return false;">Log in</a>
                    <a class="dropdown-item" href="#" onclick="showModalBoxRegister(); return false;">Register</a>
                </div>
            </div>
        <?php } elseif(Auth::isAuth()){ ?>
            <div class="dropdown show">
                <button class="btn btn-secondary btn-sm btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    USER | <? echo $_SESSION['username'];  ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" id="logout">Log out</a>
                </div>
            </div>
        <?php } ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link " href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="/tasks">Tasks</a>
                </li>
            </ul>
        </div>
    </nav>
    <main class="content-wrapper">
<div class="container-fluid">
<?php
include $contentView;
?>
    <script src="/js/core.js"></script>
</div>
        <div id="myModalBoxLogin"  class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                       <h4 class="modal-title" >Login</h4>
                    </div>
                    <div class="modal-body">
                        <form >
                            <div class="form-group row">
                                <label for="login" class="col-sm-2 col-form-label">Username:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="login" name="login" placeholder="Your login" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label">Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="pass" id="pass" placeholder="Your pass" required data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="Wrong Login or Password! Try Again">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                            <button type="submit" id="login" class="btn btn-primary">Login</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="myModalBoxRegister"  class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Register</h4>
                    </div>
                    <div class="modal-body">
                        <form >
                            <div class="form-group row">
                                <label for="login" class="col-sm-2 col-form-label">Username:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="rusername" name="rusername" placeholder="Your login" required data-toggle="popover" data-placement="right" data-trigger="focus" data-content="This username already in use!">
                                    <span id="uapp"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email:</label>
                                <div class="col-sm-10" >
                                    <input type="email" class="form-control" name="remail" id="remail" placeholder="Your email" required data-toggle="popover" data-placement="right" data-trigger="focus" data-content="This email already registered!">
                                    <span id="eapp"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label">Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Your password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password2" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirm your password" required data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="Passwords didn't match">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 bg-success rounded-pill" hidden id="successfull">
                                    Success!
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="register" class="btn btn-primary">Register</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(isset($_GET['tuid'])){ ?>
            <script>
                $("#<? echo $_GET['tuid']; ?>").click();
            </script>
        <?php } ?>
    </main>
</body>
<footer class="footer fixed-bottom">
  <div class="container">
      <div class="text-center">
          <span>Coded by AF 2020</span>
      </div>
  </div>
</footer>	
</html>
