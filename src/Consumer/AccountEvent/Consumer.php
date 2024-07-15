<?php
declare(strict_types=1);

namespace App\Consumer\AccountEvent;

use App\Consumer\AccountEvent\Input\Message;
use App\Service\AccountService;
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
        private LoggerInterface     $logger,
        private AccountService      $accountService,
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

            $this->accountService->applyEventForAccountId($message->getEvent(), $message->getAccountId());
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
