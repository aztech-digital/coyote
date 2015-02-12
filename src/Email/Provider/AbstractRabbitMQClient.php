<?php

namespace Aztech\Coyote\Email\Provider;

use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Connection\AbstractConnection;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

abstract class AbstractRabbitMQClient implements LoggerAwareInterface
{
    /**
     *
     * @var AbstractConnection
     */
    private $connection;

    /**
     *
     * @var LoggerInterface
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

    /**
     * (non-PHPdoc)
     * @see \Psr\Log\LoggerAwareInterface::setLogger()
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     *
     * @return NullLogger
     */
    protected function getLogger()
    {
        return $this->logger ?: new NullLogger();
    }

    /**
     *
     * @return AbstractChannel
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
