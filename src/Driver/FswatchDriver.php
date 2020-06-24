<?php


namespace Hyperf\ServerWatcher\Driver;


use Hyperf\ServerWatcher\Option;
use Hyperf\Utils\Str;
use Swoole\Coroutine\Channel;
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

    protected function getCmd(): string
    {
        $dir = $this->option->getWatchDir();
        $file = $this->option->getWatchFile();

        return 'fswatch -1 ' . implode(' ', $dir) . ' ' . implode(' ', $file);
    }

    public function watch(Channel $channel): void
    {
        $cmd = $this->getCmd();
        while (true) {
            $ret = System::exec($cmd);
            go(function () use ($ret, $channel) {
                $files = array_filter(explode("\n", $ret['output']));
                foreach ($files as $file) {
                    if (Str::endsWith($file, $this->option->getExt())) {
                        $channel->push($file);
                    }
                }
            });
        }
    }
}
