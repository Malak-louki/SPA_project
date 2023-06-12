<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin extends User
{
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = parent::getRoles();
        $roles[] = 'ROLE_ADMIN';

        return array_unique($roles);
    }
}