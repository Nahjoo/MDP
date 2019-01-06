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




echo $twig->render('home.html.twig', [
   
    
]);











