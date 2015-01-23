<?php

namespace Aztech\Coyote\Mailer;

use Aztech\Coyote\Mailer;
use Aztech\Coyote\Message;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQForwarder extends AbstractRabbitMQClient implements Mailer
{
    
    /**
     * 
     * @var string
     */
    private $exchange;
    
    /**
     * 
     * @var string
     */
    private $routingKey;
    
    
    public function __construct(AbstractConnection $connection, $exchange, $routingKey)
    {
        parent::__construct($connection);
        
        $this->exchange = $exchange;
        $this->routingKey = $routingKey;
    }
    
    public function send(Message $message)
    {
        $message = serialize($message);
        $amqpMessage = new AMQPMessage($message, array('delivery_mode' => 2));
        
        try {
            $this->getChannel()->basic_publish($amqpMessage, $this->exchange, $this->routingKey);
        }
        catch (\Exception $ex) {
            // @todo: fallback message storage
            $this->getLogger()->error($ex->getMessage());
            $this->getLogger()->debug($ex->getTraceAsString());
        }
    }
}
