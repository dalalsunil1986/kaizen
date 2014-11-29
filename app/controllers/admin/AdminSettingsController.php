<?php

use Acme\Country\CountryRepository;
use Acme\EventModel\EventRepository;
use Acme\Setting\SettingRepository;
use Illuminate\Support\Facades\Redirect;

class AdminSettingsController extends AdminBaseController {

    private $settingRepository;
    /**
     * @var CountryRepository
     */
    private $countryRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * @param SettingRepository $settingRepository
     * @param CountryRepository $countryRepository
     * @param EventRepository $eventRepository
     */
    public function __construct(SettingRepository $settingRepository, CountryRepository $countryRepository, EventRepository $eventRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->countryRepository = $countryRepository;
        parent::__construct();
        $this->eventRepository = $eventRepository;
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
     * @param $id
     * Event ID or Package ID .. settable_id
     */
    public function edit($id)
    {
        $setting                  = $this->settingRepository->findById($id);
        $feeTypes                 = $this->settingRepository->feeTypes;
        $approvalTypes            = $this->settingRepository->approvalTypes;
        $currentRegistrationTypes = explode(',', $setting->registration_types);
        $registrationTypes        = $this->settingRepository->registrationTypes;
        $countries                = $this->countryRepository->getAll()->lists('name', 'id');
        $currentCountries         = $setting->settingable->eventCountries->modelKeys();
        $this->render('admin.settings.edit', compact('setting', 'feeTypes', 'approvalTypes', 'registrationTypes', 'currentRegistrationTypes', 'countries', 'currentCountries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id Setting ID
     * @return Response
     */
    public function update($id)
    {
        $setting = $this->settingRepository->findById($id);

        // check for an invalid registration type
        $registrationTypes = Input::get('registration_types');
        if ( !empty($registrationTypes) ) {
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

        // update countries
        $event = $setting->settingable;

//        foreach ( Input::get('country_ids') as $countryId ) {
        $event->eventCountries()->sync(Input::get('country_ids'));
//        }

        // If First time the settings are created, then redirect to options page
        if ( Input::get('store') == 'true' ) {
            return Redirect::action('AdminSettingsController@editOptions', $id)->with('success', 'Event Settings Updated');
        }

        return Redirect::action('AdminEventsController@index')->with('success', 'Event Settings Updated');
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
        $setting = $this->settingRepository->findById($id);

        // get the current available registration types for the event from the db
        $registrationTypes = explode(',', $setting->registration_types);

        if ( !in_array('ONLINE', $registrationTypes) ) {
            // if online option is not available, Redirect Back
            return Redirect::action('AdminEventsController@index')->with('error', 'This Event has no Online Feature');
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

    /**
     * @param $id SettingsID
     */
    public function editOptions($id)
    {
        $setting   = $this->settingRepository->findById($id, ['settingable.location.country']);
        $event     = $setting->settingable;
        $currentCountries = $event->eventCountries;
        $freeEvent = $event->isFreeEvent();
        $this->render('admin.settings.edit-options', compact('setting', 'event', 'freeEvent','currentCountries'));
    }
}
