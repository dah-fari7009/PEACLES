<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHandler
{
    private $targetDir;

    public function __construct($targetDirectory)
    {
        $this->targetDir = $targetDirectory;
    }

    public function delete()
    {

    }

    public function caption()
    {

    }

    public function getTargetDirectory()
    {
        return $this->targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

}

?>