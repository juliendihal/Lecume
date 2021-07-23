<?php

namespace App\Image;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;
    private $slugger;

    //permet d'instancier le target directory et le sluggerinterface
    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file)
    {
        //creation d'un nom unique à partir du nom de base de l img
        // pour ne pas avoir de conflit en bdd
        // usage de pathinfo pour trouver le chemin dans le systeme
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        //utilisation de slug
        // pour enlever les possibles caracteres speciaux lors du renommage unique de l img
        $safeFilename = $this->slugger->slug($originalFilename);

        // Ajout d un id unique avec uniqid au nom de l img
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            //Deplacement de l image dans un dossier dans Public
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}