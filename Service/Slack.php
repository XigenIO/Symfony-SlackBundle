<?php
declare(strict_types=1);

namespace Xigen\Bundle\SlackBundle\Service;

use Xigen\Bundle\GuzzleBundle\Service\GuzzleClient;

class Slack
{
    /**
     * Slack webhook URL
     * @var string
     */
    protected $url;

    /**
     * Channel for messages to be sent to
     * @var string
     */
    protected $channel;

    /**
     * Username for the message to be posted by
     * @var string
     */
    protected $username = 'Notify';

    public function __construct(GuzzleClient $guzzle, $url, $channel)
    {
        $this->guzzle = $guzzle;
        $this->url = $url;
        $this->channel = $channel;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Send a message to all enabled services
     * @param  string $message
     * @return bool If the slack message was sent successfully
     */
    public function send($message): bool
    {
        // Don't send a message if the Slack channel or username isn't valid
        if ($this->channel === null || $this->username === null || $this->channel === '' || $this->username === '') {
            return false;
        }

        $response = $this->guzzle->request('POST', $this->url, [
            'headers' => [
                'Accept'     => 'application/json'
            ],
            'json' => [
                'channel' => $this->channel,
                'text' => $message,
                'username' => $this->username
            ]
        ]);

        return ($response->getStatusCode() === 200);
    }
}
