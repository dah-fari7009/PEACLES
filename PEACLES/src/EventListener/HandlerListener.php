<?php

namespace App\EventListener;

use App\Entity\User;
use App\Entity\Picture;
use App\Service\FileHandler;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class HandlerListener
{
    private $handler;

    public function __construct(FileHandler $handler)
    {
        $this->handler=$handler;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        if (!$entity instanceof Picture) {
            return;
        }
        $file = $entity->getImgUrl();

        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->handler->upload($file);
            $entity->setImgUrl($fileName);
        } elseif ($file instanceof File) {
            // prevents the full file path being saved on updates
            // as the path is set on the postLoad listener
            $entity->setImgUrl($file->getFilename());
        }
    }
}
?>
