<?php

namespace Aztech\Coyote\Mailer;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\NullLogger;
use Psr\Log\LoggerInterface;
use PhpAmqpLib\Connection\AbstractConnection;

abstract class AbstractRabbitMQClient implements LoggerAwareInterface
{
    /**
     *
     * @var \PhpAmqpLib\Connection\AbstractConnection
     */
    private $connection;

    /**
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     *
     * @param AbstractConnection $connection
     * @param string $exchange
     * @param string $queue
     */
    public function __construct(AbstractConnection $connection)
    {
        $this->connection = $connection;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    protected function getLogger()
    {
        return $this->logger ?: new NullLogger();
    }

    /**
     *
     * @return \PhpAmqpLib\Channel\AbstractChannel
     */
    protected function getChannel()
    {
        if ($this->channel == null) {
            $this->getLogger()->debug('Opening channel');
            $this->channel = $this->connection->channel();
            $this->getLogger()->debug('Channel opened');
        }

        return $this->channel;
    }
}
