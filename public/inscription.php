<?php

require __DIR__.'/../vendor/autoload.php';
//public/form.php
$loader = new Twig_Loader_Filesystem(__DIR__.'/../templates');
// activer le mode debug et le mode de variables strictes
$twig = new Twig_Environment($loader, [
    'debug' => true,
    'strict_variables' => true,
]);

// charger l'extension Twig_Extension_Debug
$twig->addExtension(new Twig_Extension_Debug());



$error = '';
$bdd = '';
$login = '';
$password ='';
$bouton = '';

try {
    // connexion à la base de donnée
    $bdd = new PDO('mysql:dbname=mdp;host=localhost', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $reponse = $bdd->query('SELECT * FROM utilisateur');
    
   

} catch (Exception $e)

{
        die('Erreur : ' . $e->getMessage());

}

// évenement du form dans inscription.html.twig
if($_POST){
    // on récupère la valeur des inputs
    $login = $_POST['ndc'];
    $password = $_POST['mdp'];
    
// fetch() récupère la réponse de la query et la met dans un tableau
    while($requete = $reponse->fetch()){
        // événement du bouton connexion , s'il est pas null
        if(isset($_POST['inscrit'])){
            // on vérifi si la valeur de l'input login , existe dans la base de donnée 
            // s'il existe alors il doit changer de login
            if($requete['login'] == $login){
                $error = 'Nom de compte existe déjà !';
                break;
            } 

            else {
                $error = 'Création résussit ! ';
                // s'il la valeur du login n'éxiste pas alors on l'ajoute dans la base de donnée
                $req = $bdd->prepare('INSERT INTO utilisateur(login , password ) VALUES (:login , :password)');
                $req->execute(array(
                    'login' => $login,
                    'password' => $password,
                ));
                break;
            }
        }
    };
}


echo $twig->render('inscription.html.twig', [
    'login' => $login,
    'password' => $password,
    'bdd' => $bdd,
    'error' => $error,
    
]);