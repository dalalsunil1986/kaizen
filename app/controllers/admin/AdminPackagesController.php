<?php

use Acme\Package\PackageRepository;

class AdminPackagesController extends AdminBaseController {


    /**
     * @var Acme\Event\PackageRepository
     */
    private $packageRepository;

    function __construct(PackageRepository $packageRepository)
    {
        parent::__construct();
        $this->packageRepository = $packageRepository;
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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $val = $this->eventRepository->getCreateForm();

        if ( ! $val->isValid() ) {
            return Redirect::back()->withInput()->withErrors($val->getErrors());
        }

        if ( ! $record = $this->eventRepository->create($val->getInputData()) ) {
            return Redirect::back()->with('errors', $this->eventRepository->errors())->withInput();
        }

        // Create a settings record for the inserted event
        // Settings Record needs to know Which type of Record and The Foreign Key it needs to Create
        // So pass these fields with Session (settableType,settableId)
        return Redirect::action('AdminSettingsController@create')->with(['settableType' => 'SINGLE', 'settableId' => $record->id]);
    }

    public function edit($id)
    {
        $this->render('admin.packages.create');
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

}
