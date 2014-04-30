<?php

use Acme\Mail\SubscriptionMailer;

class AdminStatusesController extends AdminBaseController {
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
        $this->beforeFilter('admin');
    }

    public function edit($id)
    {
        $request = $this->status->with(array('user','event'))->find($id);

        if (is_null($request))
        {
            return parent::redirectToAdmin();
        }

        return View::make('admin.requests.edit', compact('request'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $setStatus = Input::get('status');

        $status = $this->status->findOrFail($id);
        $event  = $this->event->findOrFail($status->event_id);
        $user   = $this->user->findOrFail($status->user_id);

        switch($setStatus) {
            case 'CONFIRMED':
                return $this->confirm($event, $user, $status);
                break;
            case 'PENDING':
                return $this->pending($event, $user, $status);
                break;
            case 'REJECTED' :
                return $this->reject($event, $user, $status);
                break;
            case 'APPROVED' :
                // Check the Event Type ( Free, Or Paid )
                $type = $event->type;
                switch($type->type) {
                    case 'FREE':
                        // Check the Event Approval Type ( Direct or Mod )
                        switch($type->approval_type) {
                            // If Direct, Whenever Admin Changes The Status To Approved Subscribe Him
                            case 'DIRECT':
                                return $this->confirm($event, $user, $status);
                                break;
                            // If Mod, Whever Admin Changes The Status To Approves, Send User an Email to Subscribe
                            case 'MOD':
                                return $this->approve($event, $user, $status);
                                break;
                        }
                        break;
                    // if event is a paid event
                    case 'PAID':
                        break;
                    default:
                        break;
                }
            default :
                break;
        }

    }

    /**
     * @param $event
     * @param $user
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */

    public function confirm($event, $user, $status)
    {
        if($event->availableSeats >= 1) {
            $status->status = 'CONFIRMED';
            if($status->save()) {
                $event->subscriptions()->attach($user);
                $event->updateAvailableSeats($event);
                $args['subject'] = 'Kaizen Event Subscription';
                $args['body'] = 'You have been confirmed to the event ' . $event->title;
                $this->mailer->sendMail($user, $args);
                return Response::json(array(
                    'success' => true,
                    'message'=>  Lang::get('site.subscription.subscribed', array('attribute'=>'subscribed'))
                ), 200);
            } else {
                return Response::json(array(
                    'success' => false,
                    'message' => 'could not subscribe'
                ), 200);
                return $this->approved($event, $user, $status);
                //@todo reset status
            }
        } else {
            return Response::json(array(
                'success' => false,
                'message'=> Lang::get('site.subscription.no_seats_available')
            ), 400);
        }
        return $this->approved($event, $user, $status);
    }

    public function confirm_old($event, $user, $status)
    {
        if($event->availableSeats >= 1) {
            $status->status = 'CONFIRMED';
            if( $status->save()) {
                $event->subscriptions()->attach($user);
                $event->updateAvailableSeats($event);
                $args['subject'] = 'Kaizen Event Subscription';
                $args['body'] = 'You have been confirmed to the event ' . $event->title;
                $this->mailer->sendMail($user, $args);
                //send mail
                return Response::json(array(
                    'success' => true,
                    'message' => Lang::get('site.subscription.subscribed', array('attribute' => 'subscribed'))
                ), 200);
            } else {
                return Response::json(array(
                    'success' => false,
                    'message' => 'could not subscribe'
                ), 200);
                return $this->approved($event, $user, $status);
                //@todo reset status
            }
        }
    }

    public function approve($event, $user, $status) {
        $status->status = 'APPROVED';
        if( $status->save()) {
            $event->subscriptions()->detach($user);
            $event->updateAvailableSeats($event);
            $args['subject'] = 'Kaizen Event Subscription';
            $args['body'] = 'You have been approved for the event ' . $event->title. '. Please '. link_to_action('SubscriptionsController@subscribe', 'Click Here', $event->id).' to confirm the subscriptions';
            return ($this->mailer->sendMail($user, $args)) ? 'done' : 'not done';
        }
    }

    public function reject($event,$user,$status) {
        $status->status = 'REJECTED';
        if( $status->save()) {
            $event->subscriptions()->detach($user);
            $event->updateAvailableSeats($event);
            $args['subject'] = 'Kaizen Event Subscription';
            $args['body'] = 'Your Request have been rejected for the event ' . $event->title;
            return ($this->mailer->sendMail($user, $args)) ? 'done' : 'not done';
        }
    }

    public function pending($event,$user,$status) {
        $status->status = 'PENDING';
        if( $status->save()) {
            $event->subscriptions()->detach($user);
            $event->updateAvailableSeats($event);
            $args['subject'] = 'Kaizen Event Subscription';
            $args['body'] = 'You have been put on pending list for the event ' . $event->title.'';
            return ($this->mailer->sendMail($user, $args)) ? 'done' : 'not done';
        }
    }

}