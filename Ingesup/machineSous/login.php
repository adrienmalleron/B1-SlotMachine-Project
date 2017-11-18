<?php session_start();
require 'bdd.php';
if (!empty($_POST)) {
    $password = $_POST['password'];
    $lenght=  strlen($password);
    $password= "+@=+" . $lenght . $password;
    $password = hash('md5', $password);
    $req = $dbh->prepare('SELECT * FROM user 
                   WHERE pseudo = :pseudo 
                   AND password = :password');
    $req->execute([
        ':pseudo' => $_POST['pseudo'],
        ':password' => $password
    ]);
    $users = $req->fetchAll();
    if(count($users) > 0){
        $_SESSION['connected'] = true;
        $_SESSION['id'] = $users[0]['id'];
        header('Location:index.html');
    } else {
        echo 'Unknown';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form action="" method="post">
    <input type="text" name="pseudo" id="pseudo" placeholder="pseudo">
    <input type="password" name="password" id="password" placeholder="password">
    <button type="submit">Valider</button>
</form>
<script>
    const input = document.querySelector('input');
    document.querySelector('form')
        .addEventListener('submit', function (e) {
            if (input.value == '')
            {
                e.preventDefault();
                input.style.border = '3px solid red';

            }
        });
</script>

</body>
</html>