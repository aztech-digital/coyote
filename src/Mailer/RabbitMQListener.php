<?php

namespace Aztech\Coyote\Mailer;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Aztech\Coyote\Mailer;
use PhpAmqpLib\Connection\AbstractConnection;

class RabbitMQListener extends AbstractRabbitMQClient
{
    /**
     * 
     * @var \Aztech\Coyote\Mailer;
     */
    private $mailer;
    
    /**
     * 
     * @var string
     */
    private $queue;
    
    /**
     * 
     * @param Mailer $mailer
     * @param AbstractConnection $connection
     * @param string $queue
     */
    public function __construct(AbstractConnection $connection, Mailer $mailer, $queue)
    {
        parent::__construct($connection);
        
        $this->mailer = $mailer;
        $this->queue = $queue;
    }
        
    public function listen()
    {
        $mailer = $this->mailer;
        $channel = $this->getChannel();
        $logger = $this->getLogger();
        
        $callback = function ($msg) use($mailer, $logger)
        {
            try {
                $mailer->send(unserialize($msg->body));
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
            }
            catch (\Exception $ex) {
                $logger->error($ex->getMessage());
                $logger->debug('Stack trace : {trace}', array('trace' => $ex->getTraceAsString()));
            }
        };
        
        $channel->basic_qos(null, 1, null);
        $channel->basic_consume($this->queue, '', false, false, false, false, $callback);
        
        while (! empty($channel->callbacks)) {
            $channel->wait();
        }
    }   
}
