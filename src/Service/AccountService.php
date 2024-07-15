<?php
declare(strict_types=1);

namespace App\Service;

use App\Repository\AccountRepository;
use Psr\Log\LoggerInterface;

readonly class AccountService
{
    public function __construct(
        private AccountRepository $accountRepository,
        private LoggerInterface   $logger,
    ) {
    }

    /**
     * @return int[]
     */
    public function getAccountIdsByGroup(string $group): array
    {
        return $this->accountRepository->getAccountIdsByGroup($group);
    }

    public function applyEventForAccountId(string $event, string $accountId): void
    {
        $this->logger->info(sprintf('account_id = %s, event = %s', $accountId, $event));
        sleep(1);
    }
}
