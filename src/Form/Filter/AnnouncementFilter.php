<?php

namespace App\Form\Filter;

use App\Entity\Race;

class AnnouncementFilter
{
    protected ?Race $race = null;
    protected bool $isLof = false;
    protected bool $isAdopted = false;

    /**
     * @return 
     */
    public function getRace(): ?Race
    {
        return $this->race;
    }

    /**
     * @param  $race 
     * @return self
     */
    public function setRace(?Race $race): self
    {
        $this->race = $race;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsLof(): bool
    {
        return $this->isLof;
    }

    /**
     * @param bool $isLof 
     * @return self
     */
    public function setIsLof(bool $isLof): self
    {
        $this->isLof = $isLof;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsAdopted(): bool
    {
        return $this->isAdopted;
    }

    /**
     * @param bool $isAdopted 
     * @return self
     */
    public function setIsAdopted(bool $isAdopted): self
    {
        $this->isAdopted = $isAdopted;
        return $this;
    }
}