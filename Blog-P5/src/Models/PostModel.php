<?php

namespace App\Models;

/**
 * create a object of post
 */

class PostModel
{
    public $id;
    public $titre;
    public $chapo;
    public $contenu;
    public $auteur;
	public $lastModif;
    public $dateCreate;

    public function __construct($id, $titre, $chapo, $contenu, $auteur, $lastModif, $dateCreate)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->chapo = $chapo;
        $this->contenu = $contenu;
        $this->auteur = $auteur;
        $this->lastModif = $lastModif;
        $this->dateCreate = $dateCreate;
    }    
}