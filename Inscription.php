<?php

require 'bdd.php';

if (!empty($_POST)) {
    $score = 20;
    $_SESSION['score'] = $score;
    $password = $_POST['password'];
    $length=  strlen($password);
    $password= "+@=+" . $length . $password;
    $password = hash('md5', $password);
    $requete = $dbh->prepare('INSERT INTO user VALUES(NULL,
      :pseudo,:mail,:password,:score
    )');
    $requete->execute([
        ':pseudo' => $_POST['pseudo'],
        ':mail' => $_POST['mail'],
        ':password' => $password,
        ':score' => $score]);
    header('Location:login.php');
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
    <input type="email" name="mail" id="mail" placeholder="email">
    <input type="password" name="password" id="password" placeholder="password">
    <input type="submit" value="Envoyer">
</form>

<script>
    const input = document.querySelector'input';
    document.querySelector('form')
        .addEventListener('submit', function (e) {
            if (input.value == '' || )
            {
                e.preventDefault();
                input.style.border = '3px solid red';

            }
        });
</script>
</body>
</html>