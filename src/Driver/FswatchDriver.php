<?php


namespace Hyperf\ServerWatcher\Driver;


use Hyperf\ServerWatcher\Option;
use Swoole\Coroutine\System;

class FswatchDriver implements DriverInterface
{
    /**
     * @var Option
     */
    protected $option;

    public function __construct(Option $option)
    {
        $this->option = $option;
        $ret = System::exec('which fswatch');
        if (empty($ret['output'])) {
            throw new \InvalidArgumentException('fswatch not exists.');
        }
    }

    public function watch(): array
    {

    }
}
