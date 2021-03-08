<?php
declare(strict_types=1);

namespace App\Traits;


trait ActiveEntityTrait
{
    public function activate(): self
    {
        $this->active = true;
        return $this;
    }

    public function deactivate(): self
    {
        $this->active = false;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active === true;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function toogleActive(): self
    {
        if ($this->isActive()) {
            $this->deactivate();
        } else {
            $this->activate();
        }

        return $this;
    }

    public function canActivate(): bool
    {
        return !$this->isActive();
    }

    public function canDeactivate(): bool
    {
        return $this->isActive();
    }
}
