
<?php
$DB = new App\DB\SQLdb;
$data = $DB->showAll();

// _d($data);
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
    <h2>Sąskaitų sąrašas</h2>

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
            <th>Asmens kodas</th>
            <th>Sąskaitos numeris</th>
            <th>Tvarkyti sąskaitą</th>
        </tr>

    <?php foreach ($data as $key => $account) :?>
        <tr>
            <td><?= $account['firstname'] ?></td>
            <td><?= $account['lastname'] ?></td>
            <td><?= $account['id'] ?></td>
            <td class="iban"><?= App\Account::formatIban($account['account']) ?></td>
            <td>
                <form action="<?= App\App::URL ?>bank/delete" method="post">
                    
                    <button class="list" type="submit" name="delete" value="<?= $account['clientID'] ?>">
                        <i class="fa fa-trash"></i>Ištrinti sąskaitą
                    </button>
                    <div class="btn">
                        <a href="<?= App\App::URL.'bank/add/'.$account['clientID'] ?>">
                            <i class="fa fa-plus-square"></i>Pridėti lėšų
                        </a>
                    </div>
                    <div class="btn">
                        <a href="<?= App\App::URL.'bank/deduct/'.$account['clientID'] ?>">
                            <i class="fa fa-minus-square"></i>Nuskaičiuoti lėšas
                        </a>
                    </div>                    
                </form>
            </td>
        </tr>
    <?php endforeach ?>

    </table>
</body>
</html>