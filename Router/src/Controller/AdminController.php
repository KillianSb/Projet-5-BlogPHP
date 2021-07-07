<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Manager\UsersManager;

class AdminController
{

    private $usersManager;

    public function __construct()
    {
        $this->usersManager = new UsersManager();

        if (!isset($_SESSION)) {
            session_start();
        }

    }

    public function adminView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        echo $twig->render('admin/adminView.twig');
    }

    public function usersListeView(){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        // // Ajout pour Dump
        // $twig = new \Twig\Environment($loader, [
        //     'debug' => true,
        //     // ...
        // ]);
        // $twig->addExtension(new \Twig\Extension\DebugExtension());

        $users = $this->usersManager->getUsers();

        echo $twig->render('admin/usersListeView.twig', ['users' => $users]);
    }

    /**
    * change admin right of a user
    */
    public function adminLawChange($idUser){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        $this->usersManager->lawChange($idUser);

        header("Location: ../usersListe");
    }


    /**
    * delete user by id
    */
    public function deleteUser($idUser){
        $loader = new FilesystemLoader('Public\Views');
        $twig = new Environment($loader);

        // // Ajout pour Dump
        // $twig = new \Twig\Environment($loader, [
        //     'debug' => true,
        //     // ...
        // ]);
        // $twig->addExtension(new \Twig\Extension\DebugExtension());

        $this->usersManager->deleteUser($idUser);

        header("Location: ../usersListeView");
    }
}
