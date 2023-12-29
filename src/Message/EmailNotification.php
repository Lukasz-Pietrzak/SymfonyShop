<?php

namespace App\Message;

class EmailNotification
{
    public function __construct(
        private string $adressTo,
        private string $subject,
        private string $htmlTemplate,
        private string $username,
    ) {
    }

    public function getAdressTo(): string
    {
        return $this->adressTo;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getHtmlTemplate(): string
    {
        return $this->htmlTemplate;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
