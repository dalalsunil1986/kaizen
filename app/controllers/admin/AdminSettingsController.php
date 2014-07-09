<?php

use Acme\Setting\SettingRepository;
use Acme\Event\EventRepository;

class AdminSettingsController extends AdminBaseController {


    /**
     * @var Acme\Event\EventRepository
     */
    private $eventRepository;
    /**
     * @var Acme\Setting\SettingRepository
     */
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository, EventRepository $eventRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->eventRepository   = $eventRepository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {

    }


    /**
     *
     * @return Jump to store method
     * Direct access to this method is not allowed
     */
    public function create()
    {
        // check for valid session
        $this->checkValidSession();

        //create the record
        $this->store();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // check for valid session
        $this->checkValidSession();

        $settableType = Session::get('settableType');
        $settableId   = Session::get('settableId');

        // If could not create an entry
        // delete the event and redirect
        if ( ! $record = $this->settingRepository->create(['settable_type' => $settableType, 'settable_id' => $settableId]) ) {
            $event = $this->eventRepository->getById($settableId);
            $this->eventRepository->delete($event);

            //@todo redirect
            dd('could not create event');
        }

        // success
        // redirect to edit
        return Redirect::action('AdminSettingsController@edit',$record->id);
        return $this->edit($record->id);
    }

    public function edit($id)
    {
        $setting = $this->settingRepository->requireById($id);
        $feeTypes      = $this->eventRepository->feeTypes;
        $approvalTypes = $this->eventRepository->approvalTypes;
        $this->render('admin.packages.edit',compact($setting,$feeTypes,$approvalTypes));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
    }

    /**
     * @return bool
     * If the Session is invalid
     */
    public function checkValidSession()
    {
        if ( empty(Session::get('settableType')) || (empty(Session::get('settableId'))) ) {
            $event = $this->eventRepository->getById(Session::get('settableId'));
            if ($event) $this->eventRepository->delete($event);
            // redirect user
            dd('session not set');
        }

        return true;
    }

}
