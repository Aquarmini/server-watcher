<?php


namespace Hyperf\ServerWatcher\Driver;


use Swoole\Coroutine\Channel;

interface DriverInterface
{
    public function watch(Channel $channel): void;
}
