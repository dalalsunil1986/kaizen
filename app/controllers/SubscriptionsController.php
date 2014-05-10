<?php

use Acme\Mail\SubscriptionMailer;

class SubscriptionsController extends BaseController {
    protected $model;
    protected $user;
    protected $mailer;
    protected $category;
    protected $status;

    function __construct(Subscription $model, User $user, EventModel $event, User $user, Status $status, SubscriptionMailer  $mailer )
    {
        $this->model = $model;
        $this->user = $user;
        $this->event = $event;
        $this->status = $status;
        $this->mailer = $mailer;
        parent::__construct();
    }

    /**
     * @param $id eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe($id)
    {
        //check whether user logged in
        $user = Auth::user();
        if (!empty($user->id)) {
            $event = $this->event->findOrFail($id);
            // if already subscribed
            if ($this->model->isSubscribed($id,$user->id)) {
                return Redirect::action('EventsController@show',$id)->with('error', Lang::get('site.subscription.already_subscribed', array('attribute'=>'subscribed')));
            }

            // get status of this user
            $status = $this->status->getStatus($event->id,$user->id);
            if($status) {
                switch($status->status) {
                    case 'CONFIRMED':
                        return Redirect::action('EventsController@show',$id)->with('error', Lang::get('site.subscription.already_subscribed', array('attribute'=>'subscribed')));
                        break;

                    case 'PENDING':

                        return Redirect::action('EventsController@show',$id)->with('success', 'You request is awaiting for admin approval');

                        break;
                    case 'REJECTED' :
                        return Redirect::action('EventsController@show',$id)->with('error', Lang::get('site.subscription.rejected'));
                        break;
                    case 'APPROVED' :
                        // subscribe the user
                        $type = $event->type;
                        switch($type->type) {
                            case 'FREE':
                                // set status to confirmed
                                // create subscription record
                                return $this->confirm($event, $user, $status);
                                break;
                            case 'PAID':
                                break;
                            default:
                                break;
                        }
                    default :
                        break;
                }
            } else {
                //create a new record and set status to pending
                return $this->pending($event,$user,$status);
            }

        }
        // notify user not authenticated
        return Response::json(array(
            'success' => false,
            'message'=> Lang::get('site.subscription.not_authenticated')
        ), 401);

    }

    /**
     * @param $event
     * @param $user
     * @param $status
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function confirm($event, $user, $status)
    {
        if($event->available_seats >= 1) {
            $status->status = 'CONFIRMED';
            if($status->save()) {
                $event->subscriptions()->attach($user);
                $event->updateSeats();
                $args['subject'] = 'Kaizen Event Subscription';
                $args['body'] = 'You have been confirmed to the event ' . $event->title;
                $this->mailer->sendMail($user, $args);
                return Redirect::action('EventsController@show',$event->id)->with('success', Lang::get('site.subscription.subscribed', array('attribute'=>'subscribed')));
            } else {
                $this->approved($event, $user, $status);
                return Redirect::action('EventsController@show',$event->id)->with('error', Lang::get('site.subscription.error', array('attribute'=>'subscribed')));
                //@todo reset status
            }
        } else {
            return Redirect::action('EventsController@show',$event->id)->with('error',  Lang::get('site.subscription.no_seats_available'));
        }
    }

    /**
     * @param $event
     * @param $user
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pending($event, $user, $status)
    {
        $status = new $this->status;
        $status->user_id = $user->id;
        $status->event_id = $event->id;
        $status->status = 'PENDING';
        if($status->save()) {
            $event->subscriptions()->detach($user);
            $event->updateSeats();
            $args['subject'] = 'Kaizen Event Subscription';
            $args['body'] = 'Your Request for the event ' . $event->title.' is awaiting for admin approval. You will be notified shortly ';
            $this->mailer->sendMail($user, $args);
            return Redirect::action('EventsController@show',$event->id)->with('success', 'Your Request for the event ' . $event->title.' is awaiting for admin approval. You will be notified shortly' );
        }
    }

}

