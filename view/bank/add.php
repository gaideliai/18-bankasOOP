<?php
$DB = new App\DB\JsonDb;
$user = $DB->show('87be17a5-4b24-45f7-a6d4-7936315e3e6b');

_d($user);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bankas</title>
    <link rel="stylesheet" href="./../../../public/css/main.css">
    <link rel="stylesheet" href="./../../../public/css/font-awesome.min.css">
</head>
<body>
    <header>
        <nav>
            <a href="<?= App\App::URL ?>slaptas-1">Pagrindinis</a>
            <a href="<?= App\App::URL ?>bank/list">Sąskaitų sąrašas</a>
            <a href="<?= App\App::URL ?>bank/create">Nauja sąskaita</a>
            <a href="<?= App\App::URL ?>logout">Atsijungti
                <i class="fa fa-sign-out"></i>
            </a>
        </nav>       
    </header>
    <h2>Lėšų įskaitymas</h2>

<?php
if(isset($_SESSION['note'])) {
    echo $_SESSION['note'];
    unset($_SESSION['note']);
}

?>
    <br>
    <table>
        <tr>
            <th>Vardas</th>
            <th>Pavardė</th>
            <th>Sąskaitos numeris</th>
            <th>Balansas</th>
            <th>Valiuta</th>
            <th>Tvarkyti sąskaitą</th>
        </tr>
  
        <tr>
            <td><?= $user['name'] ?></td>
            <td><?= $user['surname'] ?></td>
            <td><?= App\Account::formatIban($user['account']) ?></td>
            <td><?= $user['balance'] ?></td>
            <td>EUR</td>
            <td>
                <form action="<?= App\App::URL ?>bank/addFunds" method="post">
                    <input type="number" step="0.01" name="balance">
                    <button type="submit" name="add" value="">Pridėti lėšų</button>
                </form>
            </td>
        </tr> 

    </table>
</body>
</html>