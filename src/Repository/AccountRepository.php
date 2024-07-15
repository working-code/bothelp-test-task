<?php
declare(strict_types=1);

namespace App\Repository;

class AccountRepository
{
    private const NUMBER_ACCOUNTS_IN_GROUP = 1000;

    /** @return int[] */
    public function getAccountIdsByGroup(string $group): array
    {
        return range(0, self::NUMBER_ACCOUNTS_IN_GROUP);
    }
}
