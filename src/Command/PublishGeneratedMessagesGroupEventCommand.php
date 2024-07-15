<?php
declare(strict_types=1);

namespace App\Command;

use App\DTO\GroupEventDTO;
use App\Service\AsyncService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'test:publishGeneratedMessagesGroupEvent',
    description: 'For check task. Publish generated messages group event'
)]
class PublishGeneratedMessagesGroupEventCommand extends Command
{
    public function __construct(
        private readonly AsyncService        $asyncService,
        private readonly SerializerInterface $serializer,
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $messageCount = (int)$input->getArgument('count');

        if ($messageCount < 1) {
            $output->writeln('укажите количество сообщение больше 0');

            return self::FAILURE;
        }

        for ($i = 0; $i < $messageCount; $i++) {
            $this->asyncService->publishToExchange(
                AsyncService::GROUP_EVENT,
                $this->serializer->serialize(new GroupEventDTO('event_' . $i, 'group_' . $i), 'json'),
            );
        }

        return self::SUCCESS;
    }

    protected function configure(): void
    {
        $this->addArgument('count', InputArgument::REQUIRED, 'count message');
    }
}
