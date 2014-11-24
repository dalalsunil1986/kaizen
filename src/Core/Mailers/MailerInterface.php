<?php namespace Acme\Core\Mailers;

interface MailerInterface {
    public function fire(array $data);
}