<?php

use Acme\Setting\SettingRepository;
use Illuminate\Support\Facades\Redirect;

class AdminSettingsController extends AdminBaseController {

    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
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
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

    }

    /**
     * @param $id
     * Event ID or Package ID .. settable_id
     */
    public function edit($id)
    {
        $setting                  = $this->settingRepository->findById($id);
        $feeTypes                 = $this->settingRepository->feeTypes;
        $approvalTypes            = $this->settingRepository->approvalTypes;
        $registrationTypes        = $this->settingRepository->registrationTypes;
        $currentRegistrationTypes = explode(',', $setting->registration_types);
        $this->render('admin.settings.edit', compact('setting', 'feeTypes', 'approvalTypes', 'registrationTypes', 'currentRegistrationTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $setting = $this->settingRepository->findById($id);

        // check for an invalid registration type
        $imageableType = Input::get('registration_types');
        if ( !empty($imageableType) ) {
            foreach ( Input::get('registration_types') as $registrationType ) {
                if ( !in_array($registrationType, $this->settingRepository->registrationTypes) ) {
                    return Redirect::back()->with('error', 'Wrong Value ')->withInput();
                }
            }
        }
        $val = $this->settingRepository->getEditForm($id);

        if ( !$val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }
        if ( !$this->settingRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->settingRepository->errors())->withInput();
        }

        return Redirect::action('AdminEventsController@index')->with('success','Event Settings Updated');
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
     * @param $id
     * Event Id
     * Get Add Online Room ( Form )
     */
    public function getAddRoom($id)
    {
        $setting           = $this->settingRepository->findById($id);

        // get the current available registration types for the event from the db
        $registrationTypes = explode(',', $setting->registration_types);

        if ( !in_array('ONLINE', $registrationTypes) ) {
            // if online option is not available, Redirect Back
            return Redirect::action('AdminEventsController@index')->with('error','This Event has no Online Feature');
        }

        $this->render('admin.settings.add-room', compact('setting'));
    }

    public function postAddRoom($id)
    {
        $val = $this->settingRepository->getOnlineRoomForm($id);

        if ( !$val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }
        if ( !$this->settingRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->settingRepository->errors())->withInput();
        }

        return Redirect::action('AdminEventsController@index')->with('success', 'Room Added');

    }

}
