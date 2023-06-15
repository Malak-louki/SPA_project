<?php

namespace App\EventSubscriber;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HashPasswordSubscriber implements EventSubscriberInterface
{
    public function __construct(protected UserPasswordHasherInterface $hasher)
    {
    }

    // On définit quelle méthode appeler lors du déclenchement d'un des événements
    public static function getSubscribedEvents(): array
    {
        // Notez également que l'on utilise le FQCN des événement, et non une constante. Les deux fonctionnent ;)
        return [
            BeforeEntityPersistedEvent::class => ['updateUserPassword'],
            BeforeEntityUpdatedEvent::class => ['updateUserPassword'],
        ];
    }

    /**
     * @param BeforeEntityPersistedEvent|BeforeEntityUpdatedEvent $event
     */
    public function updateUserPassword($event): void
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User) || is_null($entity->getPlainPassword())) {
            return;
        }

        // On définit le nouveau mot de passe, en hashant la propriété plainPassword (temporaire)
        $entity->setPassword(
            $this->hasher->hashPassword($entity, $entity->getPlainPassword())
        );
    }
}