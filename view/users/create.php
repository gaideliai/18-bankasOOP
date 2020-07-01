<?php

if(isset($_SESSION['note'])) {
    echo $_SESSION['note'];
    unset($_SESSION['note']);
}

?>

<header>
    <nav>
        <!-- <a href=<?=$URL.'accounts-list.php'?>>Sąskaitų sąrašas</a> -->
        <a href="<?= App\App::URL ?>logout">Atsijungti
            <i class="fa fa-sign-out"></i>
        </a>
    </nav>       
</header>
<form action="<?= App\App::URL ?>users/addUser" method="post">
    <input type="text" name="user"> New User Name<br>
    <input type="text" name="password"> New User Password<br>
    <button type="submit">Add</button>
</form>