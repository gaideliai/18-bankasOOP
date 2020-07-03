<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bankas</title>
    <link rel="stylesheet" href="./../../public/css/main.css">
    <link rel="stylesheet" href="./../../public/css/font-awesome.min.css">

</head>
<body>
    <header>
        <nav>
            <a href="<?= App\App::URL ?>slaptas-1">Pagrindinis</a>
            <a href="<?= App\App::URL ?>bank/list">Sąskaitų sąrašas</a>
            <a href="<?= App\App::URL ?>bank/create">Nauja sąskaita</a>
            <a href="<?= App\App::URL ?>users/create">Admins</a>
            <a href="<?= App\App::URL ?>logout">Atsijungti
                <i class="fa fa-sign-out"></i>
            </a>
        </nav>       
    </header>
    <div class="form">
        <h2 class="new">Sukurti naują programėlės administratorių</h2>

<?php
if(isset($_SESSION['note'])) {
    echo '<br>', $_SESSION['note'];
    unset($_SESSION['note']);    
}

?>
        <br><br>
        <div class="login">
            <i class="fa fa-user-circle-o"></i>
        </div>
        <form action="<?= App\App::URL ?>users/addUser" method="post">
            <label for="">Naujo vartotojo vardas</label><br>
            <input type="text" name="user"><br><br>
            <label for="">Slaptažodis</label><br>
            <input type="text" name="password"><br><br>
            <button type="submit">Pridėti</button>
        </form>
    </div>
</body>
</html>