<?php

namespace App\Entity;

use App\Repository\AnnouncerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnouncerRepository::class)]
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
            // set the owning side to null (unless already changed)
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
}