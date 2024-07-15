<?php
declare(strict_types=1);

namespace App\Consumer\AccountEvent\Input;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    private string $event;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    private string $accountId;

    public function getEvent(): string
    {
        return $this->event;
    }

    public function setEvent(string $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getAccountId(): string
    {
        return $this->accountId;
    }

    public function setAccountId(string $accountId): self
    {
        $this->accountId = $accountId;

        return $this;
    }
}
