<?php namespace Acme\EventModel\Events;

use Acme\Core\Mailers\AbstractMailer;
use User;
use Event;

class EventHandler extends AbstractMailer {

    /**
     * @param array|\User $array
     * @internal param array $data Handle the* Handle the
     */
    public function handle(array $array)
    {
        if ( Event::firing() == 'events.mail-subscribers' ) {
            return $this->mailSubscribers($array);
        }
    }

    public function mailSubscribers($array)
    {
        $this->view           = 'emails.subscription';
        $this->subject        = $array['subject'] ;
        $array['body']  = $array['body'];

        foreach ( $array['subscribers'] as $subscriber ) {
            $this->recepientEmail = $subscriber['email'];
            $this->recepientName  = $subscriber['name_ar'];
            $array['name_ar'] = $subscriber['name_ar'];
            $this->fire($array);
        }
    }


}