<?php

use Acme\Mail\SubscriptionMailer;
use Acme\Repo\Statuses\StatusInterface;

class AdminStatusesController extends AdminBaseController {
    protected $model;
    protected $user;
    protected $mailer;
    protected $category;
    protected $status;
    protected $repo;

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

    public function create(StatusInterface $repo)
    {
        $this->repo = $repo;
        return $this;
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
                return $this->create(new \Acme\Repo\Statuses\Confirmed())->setStatus($event,$user,$status);
                break;
            case 'PENDING':
                return $this->create(new \Acme\Repo\Statuses\Pending())->setStatus($event,$user,$status);
                break;
            case 'REJECTED' :
                return $this->create(new \Acme\Repo\Statuses\Rejected())->setStatus($event,$user,$status);
                break;
            case 'APPROVED' :
                return $this->create(new \Acme\Repo\Statuses\Approved())->setStatus($event,$user,$status);
                break;
            default :
                break;
        }

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

    public function setStatus($event,$user,$status) {
        return $this->repo->setAction($event,$user,$status);
    }

}