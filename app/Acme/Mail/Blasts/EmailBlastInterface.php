<?php namespace Acme\Mail\Blasts;

interface EmailBlastInterface {

    /**
     * Send email blast
     *
     * @param $type
     * @param $options
     * @param $content
     *
     * @return mixed
     */
    public function send($type, $options, $content);

    /**
     * @param int $id => $listId
     * @param array $email
     * @return mixed
     */
    public function subscribe($id,$email);


}