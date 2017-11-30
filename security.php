<?php

//XSS
$var = htmlspecialchars($_POST['input']);

//include security
if (empty($page)) {
    $page = "welcome";
    //limit inclusion of file.php by adding dynamically extension
    //delete potential space
    $page = trim($page.".php");
}
//avoid character which allow to browse in repository
$page = str_replace("../", "protect", $page);
$page = str_replace(";", "protect", $page);
$page = str_replace("%", "protect", $page);
//forbidden inclusion of protected files by htaccess
if (preg_match("admin", $page)) {
    echo "Vous n'avez pas accès à ce répertoire";
} else {
    //check if the page already exist on the server
    if (file_exists($page) && $page != 'index.php') {
        include("./".$page);
    } else {
        echo "Page inexistante";
    }
}

//injection SQL
$login = $_POST['login'];
$password = $_POST['password'];
try {
	$bdd = new PDO('mysql:host=localhost;dbname=bdd', 'root', '');
}
catch (Execption $e) {
	die('Erreur : '.$e->getMessage()) or die(print_r($bdd->errorInfo()));
}
$req = $bdd->prepare("SELECT * FROM user WHERE login= ? AND password= ?");
$req->execute(array($login, $password));

//CSRF
session_start();
$token = bin2hex(mycrypt_creative_iv(32, MYCRYPT_DEV_URANDOM));
$_SESSION['token'] = $token;
/*in html
<form>
        <input type="text" name="pseudo" id="pseudo" />
        <input type="submit" value="valider" />
        <!-- Token audit -->
        <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
</form>
*/
//check if all token are here
if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
    //check if the two tokens are the same
    if ($_SESSION['token'] == $_POST['token']) {
        //check completed
    } else {
        //tokens are different
        echo "Erreur de vérification";
    }
}
