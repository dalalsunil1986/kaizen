<?php

use Acme\Setting\SettingRepository;
use Acme\Event\EventRepository;
use Illuminate\Support\Facades\Redirect;

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
        $setting           = $this->settingRepository->findById($id);
        $feeTypes          = $this->eventRepository->feeTypes;
        $approvalTypes     = $this->eventRepository->approvalTypes;
        $registrationTypes = $this->eventRepository->registrationTypes;
        $this->render('admin.settings.edit', compact('setting', 'feeTypes', 'approvalTypes', 'registrationTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
//        dd(Input::all());
        $setting = $this->settingRepository->findById($id);

        // check for an invalid registration type
        if ( ! empty(Input::get('registration_type')) ) {
            foreach ( Input::get('registration_type') as $registrationType ) {
                if ( ! in_array($registrationType, $this->eventRepository->registrationTypes) ) {
                    return Redirect::back()->with('error', 'Wrong Value ')->withInput();
                }
            }
        }

        $val = $this->settingRepository->getEditForm($id);

        if ( ! $val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( ! $this->settingRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->userRepository->errors())->withInput();
        }

        return Redirect::action('AdminPhotosController@create',['imageable_type' => $setting->settable_type , 'imageable_id'=> $setting->settable_id]);
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

}
