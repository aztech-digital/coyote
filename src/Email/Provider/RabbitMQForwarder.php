<?php

namespace Aztech\Coyote\Email\Provider;

use Aztech\Coyote\Email\Message;
use Aztech\Coyote\Email\Provider;
use Aztech\Coyote\Email\RecipientStatusCollection;
use Aztech\Coyote\Email\RemoteTemplateMessage;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQForwarder extends AbstractRabbitMQClient implements Provider
{

    use ProviderTrait;

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

    public function sendMessage(Message $message)
    {
        $message = serialize($message);

        $amqpMessage = new AMQPMessage($message, array('delivery_mode' => 2));
        $status = new RecipientStatusCollection();

        try {
            $this->getChannel()->basic_publish($amqpMessage, $this->exchange, $this->routingKey);

            $status->addMessageStatus($message, true);
        } catch (\Exception $ex) {
            $status->addMessageStatus($message, false, null, $ex);

            $this->getLogger()->error($ex->getMessage());
            $this->getLogger()->debug($ex->getTraceAsString());
        }

        return $status;
    }

    public function sendRemoteTemplateMessage(RemoteTemplateMessage $message)
    {
        return $this->sendMessage($message);
    }
}
