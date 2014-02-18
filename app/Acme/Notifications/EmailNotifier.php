<?php namespace Acme\Notifications;

use Acme\Mail\Blasts\EmailBlastInterface;

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
     * @param $lesson
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
            'subject'    => 'New Event Posted!' .$event->title,
            'from_name'  => 'Kaizen',
            'from_email' => 'z4ls@live.com',
            'to_name'    => 'Subscriber'
        ], [
            'html' => $event->description,
            'text' => strip_tags($event->description)
        ]);
    }
}