<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kebagram</title>
</head>
<body>

<?php if(!Cartalyst\Sentinel\Sentinel::check()) {?>

    <form action="#" method="post">
        <input type="text" autocomplete="off" placeholder="Username or email address" autofocus/>
        <input type="password" autocomplete="off" placeholder="Password"/>
        <button>Log In</button>
    </form>

<?php } else {?>

    Vous êtes connecté.

<?php } ?>

</body>
</html>