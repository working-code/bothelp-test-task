<?php
declare(strict_types=1);

namespace App\DTO;

readonly class GroupEventDTO
{
    public function __construct(
        private string $event,
        private string $accountGroup,
    ) {

    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getAccountGroup(): string
    {
        return $this->accountGroup;
    }
}
