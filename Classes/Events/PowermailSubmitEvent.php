<?php

namespace TRAW\PowermailJira\Events;

use In2code\Powermail\Domain\Model\Mail;
use Psr\Http\Message\UriInterface;

/**
 * Class PowermailSubmitEvent
 */
class PowermailSubmitEvent
{
    /**
     * The submitted Powermail Mail
     *
     * @var Mail
     */
    protected Mail $mail;
    /**
     * Powermail Settings
     *
     * @var array
     */
    protected array $settings;

    /**
     * The Uri object where the form was submitted
     *
     * @var UriInterface
     */
    protected UriInterface $uri;

    /**
     * @param Mail  $mail
     * @param array $settings
     */
    public function __construct(Mail $mail, array $settings, UriInterface $uri)
    {
        $this->mail = $mail;
        $this->settings = $settings;
        $this->uri = $uri;
    }

    /**
     * @return Mail
     */
    public function getMail(): Mail
    {
        return $this->mail;
    }

    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * @return UriInterface
     */
    public function getUri(): UriInterface
    {
        return $this->uri;
    }
}
