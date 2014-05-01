<?php

use Acme\Mail\SubscriptionMailer;

class AdminSubscriptionsController extends AdminBaseController {
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
        $this->beforeFilter('Admin');

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
                // return you are already subscribed to this event
                return Response::json(array(
                    'success' => false,
                    'message'=> Lang::get('site.subscription.already_subscribed', array('attribute'=>'subscribed'))
                ), 400 );
            }
            // if seats available
            if ($event->available_seats < 1) {
                // notify no seats available
                return Response::json(array(
                    'success' => false,
                    'message'=> Lang::get('site.subscription.no_seats_available')
                ), 400);
            }

            // get status of this user
            $status = $this->status->getStatus($event->id,$user->id);
            if($status) {
                switch($status->status) {
                    case 'CONFIRMED':
                        return Response::json(array(
                            'success' => false,
                            'message'=> 'You are subscribed to this event already'
                        ), 400 );
                        break;
                    case 'PENDING':
                        return Response::json(array(
                            'success' => false,
                            'message'=> 'You request is awaiting for admin approval'
                        ), 400 );
                        break;
                    case 'REJECTED' :
                        return Response::json(array(
                            'success' => false,
                            'message'=> 'Sorry, You cannot Register to this Event'
                        ), 400 );
                        break;
                    case 'APPROVED' :
                        // subscribe the user
                        $type = $event->type;
                        switch($type->type) {
                            case 'FREE':
                                // set status to confirmed
                                // create subscription record
                                // send email
                                $event->subscriptions()->attach($user);
                                $status->status = 'CONFIRMED';
                                $status->save();
                                $event->available_seats = $event->available_seats - 1;
                                $event->save();
                                $args['subject'] = 'Kaizen Event Subscription';
                                $args['body'] = 'You have been confirmed to the event '.$event->title ;
                                $this->mailer->sendMail($user,$args);
                                //send mail
                                return Response::json(array(
                                    'success' => true,
                                    'message'=>  Lang::get('site.subscription.subscribed', array('attribute'=>'subscribed'))
                                ), 200);
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
                $status = new $this->status;
                $status->user_id = $user->id;
                $status->event_id = $event->id;
                $status->status = 'PENDING';
                $status->save();
                // mail user about await moderation
            }

            // if request pending

            // if request
            // if request approved


            // if approved and direct


        }
        // notify user not authenticated
        return Response::json(array(
            'success' => false,
            'message'=> Lang::get('site.subscription.not_authenticated')
        ), 401);

    }

    protected function availableSeats($event)
    {
        return $event->available_seats;
    }

    public function setStatus($userId,$eventId,$status) {
        dd($status);
    }

}

