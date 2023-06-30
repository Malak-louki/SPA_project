<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\AnnouncerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnouncerRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
    ]
)]
class Announcer extends User
{
    #[ORM\OneToMany(mappedBy: 'announcer', targetEntity: Announcement::class)]
    protected Collection $announcements;

    public function __construct()
    {
        $this->announcements = new ArrayCollection();
    }

    /**
     * @return Collection<int, Announcement>
     */
    public function getAnnouncements(): Collection
    {
        return $this->announcements;
    }

    public function addAnnouncement(Announcement $announcement): self
    {
        if (!$this->announcements->contains($announcement)) {
            $this->announcements->add($announcement);
            $announcement->setAnnouncer($this);
        }

        return $this;
    }

    public function removeAnnouncement(Announcement $announcement): self
    {
        if ($this->announcements->removeElement($announcement)) {
            if ($announcement->getAnnouncer() === $this) {
                $announcement->setAnnouncer(null);
            }
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = parent::getRoles();
        $roles[] = 'ROLE_ANNOUNCER';

        return array_unique($roles);
    }

    public function countClosedAnnounces(): int
    {
        return $this->getAnnouncements()->filter(function (Announcement $announcement) {
            return $announcement->isAnnouncementClosed();
        })->count();
    }
}
