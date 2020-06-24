<?php


namespace Hyperf\ServerWatcher;


use Hyperf\Contract\ContainerInterface;
use Hyperf\ServerWatcher\Driver\DriverInterface;
use Hyperf\ServerWatcher\Driver\FswatchDriver;
use Swoole\Coroutine\Channel;
use Swoole\Coroutine\System;

class Watcher
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Option
     */
    protected $option;

    /**
     * @var DriverInterface
     */
    protected $driver;

    public function __construct(ContainerInterface $container, Option $option)
    {
        $this->container = $container;
        $this->option = $option;
        $this->driver = $this->getDriver();
    }

    public function run()
    {
        $channel = new Channel(999);
        go(function () use($channel) {
            $this->driver->watch($channel);
        });

        while ($file = $channel->pop()){
            var_dump($file);
        }
    }

    protected function getDriver()
    {
        $driver = $this->option->getDriver();
        switch (strtolower($driver)) {
            case 'fswatch':
                return new FswatchDriver($this->option);
            default:
                throw new \InvalidArgumentException('Driver not support.');
        }
    }

    public function restart()
    {

    }


}
