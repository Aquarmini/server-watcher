<?php


namespace Hyperf\ServerWatcher\Driver;


interface DriverInterface
{
    public function watch(): array;
}
