<?php


namespace Hyperf\ServerWatcher;


use Hyperf\Contract\ConfigInterface;

class Option
{
    /**
     * @var string
     */
    protected $start = 'php bin/hyperf.php start';

    /**
     * @var string
     */
    protected $driver = 'fswatch';

    /**
     * @var array
     */
    protected $watchDir = ['app', 'config'];

    /**
     * @var array
     */
    protected $watchFile = ['.env'];

    public function __construct(ConfigInterface $config, array $dir, array $file)
    {
        $options = $config->get('watcher', []);

        isset($options['start']) && $this->start = $options['start'];
        isset($options['driver']) && $this->driver = $options['driver'];
        isset($options['watch']['dir']) && $this->watchDir = (array)$options['watch']['dir'];
        isset($options['watch']['file']) && $this->watchFile = (array)$options['watch']['file'];

        $this->watchDir = array_unique(array_merge($this->watchDir, $dir));
        $this->watchFile = array_unique(array_merge($this->watchFile, $file));
    }

    public function getStart(): string
    {
        return $this->start;
    }

    public function getDriver(): string
    {
        return $this->driver;
    }

    public function getWatchDir(): array
    {
        return $this->watchDir;
    }

    public function getWatchFile(): array
    {
        return $this->watchFile;
    }
}