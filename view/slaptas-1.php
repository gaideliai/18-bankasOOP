<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bankas</title>
    <link rel="stylesheet" href="./../public/css/main.css">
    <link rel="stylesheet" href="./../public/css/font-awesome.min.css">
</head>
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
<div class="container">
    <h1>Sveiki atvykę!</h1>
    <div class="menu">
        <div class="card">
            <i class="fa fa-list-alt"></i>
            <a class="card-link" href="<?= App\App::URL ?>bank/list">Sąskaitų sąrašas</a>
            <p>Peržiūrėkite sąskaitų sąrašą, tvarkykite klientų sąskaitas, ištrinkite sąskaitą</p>
        </div>
        <div class="card">
            <i class="fa fa-address-card-o"></i>
            <a class="card-link"href="<?= App\App::URL ?>bank/create">Nauja sąskaita</a>
            <p>Sukurkite naują sąskaitą, pridėkite naują kliento sąskaitą prie sąskaitų sąrašo</p>
        </div>
        <div class="card">
            <i class="fa fa-unlock"></i>
            <a class="card-link" href="<?= App\App::URL ?>users/create">Administratoriai</a>
            <p>Pridėkite naują banko programėlės administratorių</p>
        </div>
    </div>
</div>



