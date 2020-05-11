<div id="content">
    <p>Тестовый проект в котором реализована MVC на чистом PHP с версткой Bootstrap 4 </p>
    <?php if(Auth::isAuth()){?>
        <p>Вы зарегистрованный пользователь, добрый день <? echo $_SESSION['username'];?>!</p>
    <?php } else {?>
        <p>Можно зарегистрироваться! Для этого нажмите кнопку Login и выберете пункт Register. </p>
    <?php } ?>
</div>