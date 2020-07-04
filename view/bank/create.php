<?php
$DB = new App\DB\JsonDb;
$data = $DB->showAll();
?>

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
        <h2 class="new">Pridėti naują sąskaitą</h2>

<?php
if (isset($_SESSION['note'])) {
    echo '<br>', $_SESSION['note'];
    unset($_SESSION['note']);    
}

?>
        <br><br>
        <div class="login">
            <i class="fa fa-user-plus"></i>
        </div>
        <form action="<?= App\App::URL ?>bank/addAccount" method="post">
            <label for="">Vardas</label><br>
            <input type="text" name="name" value=<?= $_SESSION['name'] ?? '' ?>><br><br>
<?php
if (isset($_SESSION['name'])) {
    unset($_SESSION['name']);
}
?>
            <label for="">Pavardė</label><br>
            <input type="text" name="surname" value=<?= $_SESSION['surname'] ?? '' ?>><br><br>
<?php
if (isset($_SESSION['surname'])) {
    unset($_SESSION['surname']);
}
?>
            <label for="">Sąskaitos numeris</label><br>
            <input type="text" name="account" value="<?= App\Account::generateAccountNumber($data)?>" readonly><br><br>
            <label for="">Asmens kodas</label><br>
            <input type="text" maxlength="11" name="id" value=<?= $_SESSION['id'] ?? ''?>><br><br>
<?php
if (isset($_SESSION['id'])) {
    unset($_SESSION['id']);
}
?>        
            <input type="hidden" name="balance" value="0">
            
            <button type="submit" name="submit">Pridėti</button>
            <!-- <button type="submit" name="clear">Išvalyti</button><br> -->
        </form>
    </div>
    
</body>
</html>