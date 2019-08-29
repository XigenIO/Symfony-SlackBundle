<?php

namespace Xigen\Bundle\SlackBundle\Service;

use Xigen\Bundle\GuzzleBundle\Service\GuzzleClient;

class SlackDynamic extends Slack
{
    private $defaultUrl;
    private $defaultChannel;

    public function __construct(GuzzleClient $guzzle, $url, $channel)
    {
        $this->defaultUrl = $url;
        $this->defaultChannel = $channel;

        parent::__construct($guzzle, null, null);
    }

    /**
     * Sets the url to the default app url
     *
     * @return $this
     */
    public function setDefaultUrl()
    {
        $this->url = $this->defaultUrl;

        return $this;
    }

    /**
     * Sets the channel to the default app channel
     *
     * @return $this
     */
    public function setDefaultChannel()
    {
        $this->channel = $this->defaultChannel;

        return $this;
    }

    /**
     * @param string $url
     * @param string $channel
     * @return $this
     */
    public function initialize(string $url, string $channel)
    {
        $this->url = $url;
        $this->channel = $channel;

        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param string $channel
     * @return $this
     *
     */
    public function setChannel(string $channel)
    {
        $this->channel = $channel;

        return $this;
    }

    public function send($message): bool
    {
        if ($this->url === null || $this->channel === null) {
            throw new \Exception('Url and channel must be defined when using dynamic before calling send. Did you forget to call initialize or setUrl and setChannel?');
        }

        return parent::send($message);
    }
}
