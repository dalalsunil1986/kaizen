<?php namespace Acme\Notifications;

use Acme\Mail\Blasts\EmailBlastInterface;
use User;

class EmailNotifier implements NotifierInterface {

    /**
     * @var \Acme\Mail\Blasts\EmailBlastInterface
     */
    private $blast;

    /**
     * Constructor
     *
     * @param EmailBlastInterface $blast
     */
    public function __construct(EmailBlastInterface $blast)
    {
        $this->blast = $blast;
    }

    /**
     * Notify lesson subscribers
     *

     * @param $event
     * @internal param $lesson

     *
     * @return mixed|void
     */
    public function lessonSubscribers($event)
    {
        // You probably shouldn't place this here.
        // Add it to Mailchimp class, or a config file.
        $lessonNotificationsListId = 'de1f937717';

        $this->blast->send('regular', [
            'list_id'    => $lessonNotificationsListId,
            'subject'    => 'New Event Posted!' .\Str::limit($event->title,'20'),
            'from_name'  => 'Kaizen',
            'from_email' => 'z4ls@live.com',
            'to_name'    => 'Subscriber'
        ], [
            'html' => $event->description,
            'text' => strip_tags($event->description)
        ]);
    }


    /**
     * @param int $listId
     * @param array $emails => assosiative array
     * @return bool

     * @internal param \Acme\Notifications\assosiative $user array of emails
     * Subscribe a user to the list
     */
    public function subscribeUser($listId,$emails=array())
    {
//        $lessonNotificationsListId = 'de1f937717';
        $this->blast->subscribe($listId,$emails,null,'html',false,true);
        return true;
    }

    /**
     * @param int $listId
     * @param array $emails => assosiative array
     * @internal param \Acme\Notifications\assosiative $user array of emails
     * Subscribe a user to the list
     */
//    public function newsletterSubscriber($listId, $emails=array())
//    {
//        $this->blast->subscribe($listId,$emails);
//    }


}