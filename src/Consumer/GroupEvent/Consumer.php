<?php
declare(strict_types=1);

namespace App\Consumer\GroupEvent;

use App\Consumer\GroupEvent\Input\Message;
use App\Consumer\GroupEvent\Output\AccountEvent;
use App\Service\AccountService;
use App\Service\AsyncService;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

readonly class Consumer implements ConsumerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface  $validator,
        private AccountService      $accountService,
        private AsyncService        $asyncService,
        private LoggerInterface     $logger,
    ) {
    }

    public function execute(AMQPMessage $msg): int
    {
        try {
            $message = $this->serializer->deserialize($msg->getBody(), Message::class, 'json');
            $errors = $this->validator->validate($message);

            if ($errors->count() > 0) {
                return $this->reject((string)$errors);
            }

            $accountIds = $this->accountService->getAccountIdsByGroup($message->getAccountGroup());

            foreach ($accountIds as $accountId) {
                $this->asyncService->publishToExchange(
                    AsyncService::ACCOUNT_EVENT,
                    $this->serializer->serialize(new AccountEvent($message->getEvent(), (string)$accountId), 'json'),
                    (string)$accountId,
                );
            }
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());

            return $this->reject($exception->getMessage());
        }

        return self::MSG_ACK;
    }

    private function reject(string $error): int
    {
        echo "Incorrect message: $error";

        return self::MSG_REJECT;
    }
}
