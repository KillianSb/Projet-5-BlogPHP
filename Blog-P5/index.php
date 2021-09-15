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
$router->post('/connexionRequest', 'Auth#traitementConnexion');

$router->get('/deconnexion', 'Auth#deconnexion');

$router->get('/inscription', 'Auth#inscriptionView');
$router->post('/inscriptionRequest', 'Auth#traitementInscription');

// ------------------------------------------------------------------ //

// Blog

$router->get('/createPost', 'Blog#createPostView');
$router->post('/createPost', 'Blog#traitementCreatePost');

$router->get('/modifPost/:id', 'Blog#modifPostView');
$router->post('/ModifPostRequest/:id', 'Blog#traitementModifPost');

$router->get('/commentPost/:id', 'Blog#createCommentView');
$router->post('/commentPost/:id', 'Blog#traitementCreateComment');

$router->get('/viewPost/:id', 'Blog#ViewPost');


// ------------------------------------------------------------------ //

// Admin

$router->get('/admin', 'Admin#adminView');
$router->get('/usersListe', 'Admin#usersListeView');
$router->get('/usersDelete/:id', 'Admin#deleteUser');
$router->get('/adminLawChange/:id', 'Admin#adminLawChange');

$router->get('/postsListe', 'Admin#postsListe');
$router->get('/deletePost/:id', 'Admin#deletePost');

$router->get('/deleteComment/:id', 'Admin#deleteComment');

// ------------------------------------------------------------------ //

$router->run();