<?php
require __DIR__ . '/vendor/autoload.php';


$router = new App\Router\Router($_GET['url']);

// ------------------------------------------------------------------ //

// Views
$router->get('/home', 'Home#homeView'); 
$router->get('/cv', 'Cv#cvView');
$router->get('/blog', 'Blog#blogView');
$router->get('/contact', 'Contact#contactView');
$router->post('/traitementForm', 'Traitement#traitementForm');

// ------------------------------------------------------------------ //

// Auth
$router->get('/connexion', 'Auth#connexionView');
$router->post('/connexion', 'Auth#traitementConnexion');
$router->get('/inscription', 'Auth#inscriptionView');
$router->post('/inscription', 'Auth#traitementInscription');

// ------------------------------------------------------------------ //

// ------------------------------------------------------------------ //

// Admin



// ------------------------------------------------------------------ //

$router->run();