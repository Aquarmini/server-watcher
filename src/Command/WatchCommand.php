<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Hyperf\ServerWatcher\Command;

use Hyperf\Command\Command;
use Hyperf\Contract\ContainerInterface;
use Hyperf\ServerWatcher\Option;
use Hyperf\ServerWatcher\Watcher;
use Symfony\Component\Console\Input\InputOption;

class WatchCommand extends Command
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct('server:watch');

        $this->container = $container;
        $this->setDescription('watch command');
        $this->addOption('file', 'F', InputOption::VALUE_OPTIONAL|InputOption::VALUE_IS_ARRAY,'', []);
        $this->addOption('dir','D', InputOption::VALUE_OPTIONAL|InputOption::VALUE_IS_ARRAY,'', []);
    }

    public function handle()
    {
        $options = array_merge(['app', 'config'], $this->input->getOption('dir'));
        $files = array_merge(['.env'], $this->input->getOption('file'));

        $option = make(Option::class,[
            'dir' => $this->input->getOption('dir'),
            'file' => $this->input->getOption('file'),
        ]);

        $watcher = make(Watcher::class,['option' => $option]);

        $watcher->run();
    }
}
