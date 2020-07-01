<link rel="stylesheet" href="./../public/css/main.css">
<link rel="stylesheet" href="./../public/css/font-awesome.min.css">
<div class="form">
    <h2>Prisijungimas</h2>

<?php
if(isset($_SESSION['note'])) {
    echo '<br>', $_SESSION['note'];
    unset($_SESSION['note']);
}

?>
    <br><br>
    <div class="login">
        <i class="fa fa-unlock-alt"></i>
    </div>    
    <form action="<?= App\App::URL ?>doLogin" method="post">
        <label for="">Prisijungimo vardas</label><br>
        <input type="text" name="user"><br><br>
        <label for="">Slaptažodis</label><br>
        <input type="password" name="password"><br><br>
        <button type="submit">Prisijungti</button>
    </form>
</div>