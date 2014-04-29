<?php

class AdminStatusesController extends AdminBaseController {
    protected $model;

    public function __construct(Status $model)
    {
        $this->model = $model;
        parent::__construct();
        $this->beforeFilter('Admin');
    }

    public function edit($id)
    {
        $request = $this->model->with(array('user','event'))->find($id);

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
       $request = $this->model->find($id);
       $request->status = Input::get('status');
       if($request->save()) {
           return Redirect::action('AdminEventsController@getRequests',$request->event_id)->with(array('success' =>'User Status Updated'));
       }
       return Redirect::back()->withErrors('Could Not Update the User Status');
    }
}