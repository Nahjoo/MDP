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


// on déclare nos variables
$error = '';
$bdd = '';
$login = '';
$pass = '';
$gestionnaire = '';

try {
    // connexion à la base de donnée
    $bdd = new PDO('mysql:dbname=mdp;host=localhost', 'root', '');
    $reponse = $bdd->query('SELECT * FROM utilisateur');

    

} catch (Exception $e)

{
        die('Erreur : ' . $e->getMessage());

}

// évenement du form dans connexion.html.twig
if($_POST){
     // on récupère la valeur des inputs
    $login = $_POST['ndc'];
    $pass = $_POST['mdp'];
    
// fetch() récupère la réponse de la query et la met dans un tableau
    while($requete = $reponse->fetch()){
        // événement du bouton connexion , s'il est pas null
        if(isset($_POST['connexion'])){
            // on vérifi dans la base de donnée si le login et mdp éxiste
            if($requete['login'] == $login and $requete['password'] == $pass){
                $error = 'Connexion réussit !';
                // nous envoie sur la page gestionnaire-mdp.php
                header('Location: ../public/gestionnaire-mdp.php');
                break;
                
            }

            else{
                
                $error = 'login ou password incorrect !';
             
            }

        }
    }
}

echo $twig->render('connexion.html.twig', [
    'bdd' => $bdd,
    'login' => $login,
    'pass' => $pass,
    'error' => $error,
    'gestionnaire' => $gestionnaire,
    
]);