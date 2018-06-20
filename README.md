# swoole-bridge-bundle
Symfony Swoole Bridge Bundle

## Requirements

* PHP >= 7.2
* symfony/framework-bundle: "^3.0|^4.0"
* insidestyles/swoole-bridge: "^0.1"
* symfony/console: "^3.0|^4.0",
* zendframework/zend-diactoros: "^1.7"


## Installation

This package is installable and autoloadable via Composer 

```sh
composer require insidestyles/swoole-bridge-bundle
```
Update config.yml
```yaml
swoole_bridge:
    server:
        port: "%web_socket_port%"      #The port the socket server will listen on
        host: "%web_socket_host%"
```
Update AppKernel
```php
    new Insidestyles\SwooleBridgeBundle\SwooleBridgeBundle(),
```

## Usage

```sh
    php bin/console swoole:bridge:server
```
