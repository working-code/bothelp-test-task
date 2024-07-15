<?php
declare(strict_types=1);

namespace App\Consumer\GroupEvent\Output;

use Symfony\Component\Validator\Constraints as Assert;

readonly class AccountEvent
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 3)]
        private string $event,

        #[Assert\NotBlank]
        #[Assert\Length(min: 3)]
        private string $accountId,
    ) {
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getAccountId(): string
    {
        return $this->accountId;
    }
}
