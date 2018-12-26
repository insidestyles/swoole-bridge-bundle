<?php

namespace Insidestyles\SwooleBridgeBundle\Command;

use Insidestyles\SwooleBridge\Handler;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SwooleBridgeServerCommand
 * @package Insidestyles\SwooleBridgeBundle\Command
 */
final class SwooleBridgeServerCommand
{
    /**
     * @var Handler
     */
    private $handler;

    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    public function __construct(Handler $handler, string $host, int $port)
    {
        $this->handler = $handler;
        $this->host    = $host;
        $this->port    = $port;
    }

    protected function configure()
    {
        $this
            ->setName('swoole:bridge:server')
            ->setDescription('Start swoole server');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $http = new \swoole_http_server($this->host, $this->port);
        $http->on(
            'request',
            function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
                $this->handler->handle($request, $response);
            }
        );

        $http->start();
        $output->writeln("Server started on {$this->host}:{$this->port}");
    }
}
