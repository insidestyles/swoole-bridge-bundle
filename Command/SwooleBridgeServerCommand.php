<?php

namespace Insidestyles\SwooleBridgeBundle\Command;

use Insidestyles\SwooleBridge\Handler;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SwooleBridgeServerCommand extends Command
{
    public function __construct(
        private Handler $handler,
        private string $host,
        private int $port,
        private array $configs,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('swoole:bridge:server')
            ->setDescription('Start swoole server');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $http = new Server($this->host, $this->port);
        $http->set($this->configs);
        $http->on(
            'request',
            function (Request $request, Response $response) {
                $this->handler->handle($request, $response);
            }
        );

        $http->start();
        $output->writeln("Server started on {$this->host}:{$this->port}");
    }
}
