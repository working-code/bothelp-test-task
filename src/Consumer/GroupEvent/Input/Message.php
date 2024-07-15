<?php
declare(strict_types=1);

namespace App\Consumer\GroupEvent\Input;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    private string $event;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    private string $accountGroup;

    public function getEvent(): string
    {
        return $this->event;
    }

    public function setEvent(string $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getAccountGroup(): string
    {
        return $this->accountGroup;
    }

    public function setAccountGroup(string $accountGroup): self
    {
        $this->accountGroup = $accountGroup;

        return $this;
    }
}
