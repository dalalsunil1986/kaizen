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

    public function index(){
        $requests = $this->status->with(array('user','event'))->latest()->get();
        return View::make('admin.requests.index', compact('requests'));
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
        $repo =  new \Acme\Repo\Statuses\Status($event,$user,$status);
        switch($setStatus) {
            case 'CONFIRMED':
                return $repo->create(new \Acme\Repo\Statuses\Confirmed())->setStatus();
                break;
            case 'PENDING':
                return $repo->create(new \Acme\Repo\Statuses\Pending())->setStatus();
                break;
            case 'REJECTED' :
                return $repo->create(new \Acme\Repo\Statuses\Rejected())->setStatus();
                break;
            case 'APPROVED' :
                return $repo->create(new \Acme\Repo\Statuses\Approved())->setStatus();
                break;
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

    }

    public function pending($event,$user,$status) {

    }

    public function destroy($id)
    {
        $status = $this->status->findOrFail($id);
        $event  = $this->event->findOrFail($status->event_id);
        $user   = $this->user->findOrFail($status->user_id);
        if ($status->find($id)->delete()) {
            $event->subscriptions()->detach($user);
            $event->updateSeats();
            return Redirect::action('AdminStatusesController@index')->with(array('success'=>'Request Deleted'));
        } else {
            return Redirect::action('AdminStatusesController@index')->with(array('error'=>'Request Could not be Deleted'));
        }

    }

}