<?php namespace Acme\Core\Contracts;

interface MailerContracts {
    public function fire(array $data);
}