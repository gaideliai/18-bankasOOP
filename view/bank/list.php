<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bankas</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/font-awesome.min.css">
</head>
<body>
    <header>
        <nav>
            <a href=<?=$URL.'new-account.php'?>>Nauja sąskaita</a>
            <a href=<?=$URL.'login.php?logout'?>>Atsijungti
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

    <?php foreach ($data as $account) :?>
        <tr>
            <td><?= $account['name'] ?></td>
            <td><?= $account['surname'] ?></td>
            <td><?= $account['id'] ?></td>
            <td class="iban"><?= $account['account'] ?></td>
            <td>
                <form action="" method="post">
                    
                    <button type="submit" name="delete" value="<?= $account['account'] ?>">
                        <i class="fa fa-trash"></i>Ištrinti sąskaitą
                    </button>
                    <div class="btn">
                        <a href=<?=$URL.'add.php?account='.$account['account']?>>
                            <i class="fa fa-plus-square"></i>Pridėti lėšų
                        </a>
                    </div>
                    <div class="btn">
                        <a href=<?=$URL.'deduct.php?account='.$account['account']?>>
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