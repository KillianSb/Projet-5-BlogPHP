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
$router->get('/legal', 'Legal#legalView'); 

// ------------------------------------------------------------------ //

// Auth
$router->get('/connexion', 'Auth#connexionView');
$router->post('/connexion', 'Auth#traitementConnexion');

$router->get('/deconnexion', 'Auth#deconnexion');

$router->get('/inscription', 'Auth#inscriptionView');
$router->post('/inscription', 'Auth#traitementInscription');

// ------------------------------------------------------------------ //

// Blog

$router->get('/createPost', 'Blog#createPostView');
$router->post('/createPost', 'Blog#traitementCreatePost');



// ------------------------------------------------------------------ //

// Admin

$router->get('/admin', 'Admin#adminView');
$router->get('/usersListe', 'Admin#usersListeView');
$router->get('/usersDelete/:id', 'Admin#deleteUser');
$router->get('/adminLawChange/:id', 'Admin#adminLawChange');

$router->get('/postsListe', 'Admin#postsListe');
$router->get('/deletePost/:id', 'Admin#deletePost');

// ------------------------------------------------------------------ //

$router->run();