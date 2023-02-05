# swoole-bridge-bundle
Symfony Swoole Bridge Bundle

## Requirements

* PHP >= 7.1
* symfony/framework-bundle: "^5.0|^6.0"
* insidestyles/swoole-bridge: "^1.0"
* symfony/console: "^5.0|^6.0",
* "laminas/laminas-diactoros": "^2.0"


## Installation

This package is installable and autoloadable via Composer 

```sh
composer require insidestyles/swoole-bridge-bundle
```
Update config.yml
```yaml
swoole_bridge:
    server:
        port: "%web_server_port%"      #The port the socket server will listen on
        host: "%web_server_host%"
        configs:
          document_root: '/app/public'
          enable_static_handler: true
          http_compression: true
          http_compression_level: 1
```
Update bundles
```php
     Insidestyles\SwooleBridgeBundle\SwooleBridgeBundle::class => ['all' => true],
```

## Usage

```sh
    php bin/console swoole:bridge:server
```

## Create custom handler
One of common problems while running long lived program in php is "MySQL server has gone away" (Long lived php 
daemon running using reactphp, websocket, swoole, ..etc..). 
In this case we can create a custom handler to handle this error. For example:

```php
class CustomHandler implements SwooleBridgeInterface
{    
    /**
     * @var SwooleBridgeInterface
     */
    private $swooleBridge;

    /**
     * @var RegistryInterface
     */
    private $doctrineRegistry;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Handler constructor.
     * @param SwooleBridgeInterface $swooleBridge
     * @param null|LoggerInterface $logger
     */
    public function __construct(
        SwooleBridgeInterface $swooleBridge,
        RegistryInterface $doctrineRegistry,
        ?LoggerInterface $logger = null
    ) {
        $this->swooleBridge = $swooleBridge;
        $this->doctrineRegistry = $doctrineRegistry;
        $this->logger = $logger ?? new NullLogger();
    }

    /**
     * @inheritdoc
     */
    public function handle(
        SwooleRequest $swooleRequest,
        SwooleResponse $swooleResponse
    ): void {
        try {
            $this->swooleBridge->handle($swooleRequest, $swooleResponse);
        } catch (PDOException $e) {
            $this->logger->error($e->getMessage());
            /** @var Connection $connection */
            $connection = $this->doctrineRegistry->getConnection();
            if (!$connection->ping()) {
                $connection->close();
                $connection->connect();
            }
            $em = $this->doctrineRegistry->getEntityManager();
            if (!$em->isOpen()){
                $this->doctrineRegistry->resetManager();
            }
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
    
```

Override default handler using symfony service decorator:
 
```yml 
#config/services.yaml
services:
    swoole_bridge.custom_handler:
        class: App\CustomHandler
        decorates: swoole_bridge.handler
        arguments: 
            - '@swoole_bridge.custom_handler.inner'
            - '@doctrine'
            - '@logger'
