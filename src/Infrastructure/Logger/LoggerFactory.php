<?php

namespace FreePik\Infrastructure\Logger;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;


class LoggerFactory
{

    private $path;

    private $level;

    private $handler = [];

    public function __construct(array $settings)
    {
        $this->path = (string)$settings['path'];
        $this->level = (int)$settings['level'];
    }

    public function createLogger(string $name = null): LoggerInterface
    {
        $logger = new Logger($name ?: 'freepik');

        foreach ($this->handler as $handler) {
            $logger->pushHandler($handler);
        }

        $this->handler = [];

        return $logger;
    }

    public function addFileHandler(string $filename, int $level = null): self
    {
        $filename = sprintf('%s/%s', $this->path, $filename);
        $rotatingFileHandler = new RotatingFileHandler($filename, 0, $level ?? $this->level, true, 0777);

        $rotatingFileHandler->setFormatter(new LineFormatter(null, null, false, true));

        $this->handler[] = $rotatingFileHandler;

        return $this;
    }

    public function addConsoleHandler(int $level = null): self
    {
        $streamHandler = new StreamHandler('php://stdout', $level ?? $this->level);
        $streamHandler->setFormatter(new LineFormatter(null, null, false, true));

        $this->handler[] = $streamHandler;

        return $this;
    }
}
