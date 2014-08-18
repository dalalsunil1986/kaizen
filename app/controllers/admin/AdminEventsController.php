<?php
use Acme\Category\CategoryRepository;
use Acme\Event\EventRepository;
use Acme\Location\LocationRepository;
use Acme\Package\PackageRepository;
use Acme\Photo\PhotoRepository;
use Acme\Setting\SettingRepository;
use Acme\User\UserRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;


class AdminEventsController extends AdminBaseController {

    protected $eventRepository;
    protected $user;
    protected $mailer;
    protected $category;
    protected $photo;
    protected $photoRepository;
    protected $locationRepository;
    /**
     * @var Acme\Setting\SettingRepository
     */
    private $settingRepository;
    /**
     * @var Acme\Event\EventPhotoService
     */
    private $imageService;
    /**
     * @var Acme\Package\PackageRepository
     */
    private $packageRepository;

    function __construct(EventRepository $eventRepository, CategoryRepository $categoryRepository, LocationRepository $locationRepository, UserRepository $userRepository, PhotoRepository $photoRepository, SettingRepository $settingRepository, PackageRepository $packageRepository)
    {
        $this->eventRepository    = $eventRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository     = $userRepository;
        $this->photoRepository    = $photoRepository;
        $this->locationRepository = $locationRepository;
        $this->settingRepository  = $settingRepository;
        $this->packageRepository  = $packageRepository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $events   = $this->eventRepository->getAll(array('category', 'location.country'))->paginate(10);
        $packages = $this->packageRepository->getAll(   );
        $this->render('admin.events.index', compact('events', 'packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $category = $this->select + $this->categoryRepository->getEventCategories()->lists('name_en', 'id');
        $author   = $this->select + $this->userRepository->getRoleByName('author')->lists('username', 'id');
        $location = $this->select + $this->locationRepository->getAll()->lists('name_en', 'id');

        $this->render('admin.events.create', compact('category', 'author', 'location'));
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

        if ( ! $event = $this->eventRepository->create($val->getInputData()) ) {
            return Redirect::back()->with('errors', $this->eventRepository->errors())->withInput();
        }

        if ( ! $setting = $this->settingRepository->create(['settingable_type' => 'EventModel', 'settingable_id' => $event->id]) ) {
            $this->eventRepository->delete($event);
            //@todo redirect
            dd('could not create event');
        }

        // Create a settings record for the inserted event
        // Settings Record needs to know Which type of Record and The Foreign Key it needs to Create
        // So pass these fields with Session (settableType,settableId)

        return Redirect::action('AdminSettingsController@edit', $setting->id);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $event    = $this->eventRepository->findById($id, ['photos']);
        $category = $this->select + $this->categoryRepository->getEventCategories()->lists('name_en', 'id');
        $author   = $this->select + $this->userRepository->getRoleByName('author')->lists('username', 'id');
        $location = $this->select + $this->locationRepository->getAll()->lists('name_en', 'id');

        $this->render('admin.events.edit', compact('event', 'category', 'author', 'location'));
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
        $this->eventRepository->findById($id);

        $val = $this->eventRepository->getEditForm($id);

        if ( ! $val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( ! $this->eventRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->eventRepository->errors())->withInput();
        }

        return Redirect::action('AdminEventsController@edit', $id)->with('success', 'Updated');

//        $validation->fill(Input::except(array('thumbnail', 'addresspicker_map', 'type', 'approval_type')));
//        if ( ! $validation->save() ) {
//            return Redirect::back()->withInput()->withErrors($validation->getErrors());
//        }
//
//        //update type
//        $type = Type::where('event_id', $id)->first();
//        if ( ! $type ) {
//            $type           = new Type();
//            $type->event_id = $id;
//        }
//        $type->type          = Input::get('type');
//        $type->approval_type = Input::get('approval_type');
//        if ( ! $type->save() ) {
//            return Redirect::to('admin/event/' . $validation->id . '/edit')->withErrors($type->getErrors());
//        }

        //update available seats
//        $event                  = $this->eventRepository->find($validation->id);
//        $total_seats            = $event->total_seats;
//        $total_seats_taken      = Subscription::findEventCount($event->id);
//        $available_seats        = $total_seats - $total_seats_taken;
//        $event->available_seats = $available_seats;
//        $event->save();

//        return parent::redirectToAdmin()->with('success', 'Updated Event ' . $validation->title);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ( $this->eventRepository->findOrFail($id)->delete() ) {
            //  return Redirect::home();
            return parent::redirectToAdmin()->with('success', 'Event Deleted');
        }

        return parent::redirectToAdmin()->with('error', 'Error: Event Not Found');
    }


    /**
     * @param $id
     * @return statement
     * Send Notification Email for the Event Followers
     */

    public function mailFollowers($id)
    {
        $event = $this->eventRepository->findById($id)->followers;
        try {
            $this->mailer->sendMail($event, Input::all());
        }
        catch ( \Exception $e ) {
            return Redirect::back()->with('error', 'Email Could not send');
        }

        return Redirect::back()->with('success', 'Email Sent');
    }

    public function mailFavorites($id)
    {
        $event = $this->eventRepository->findById($id)->favorites;
        try {
            $this->mailer->sendMail($event, Input::all());
        }
        catch ( \Exception $e ) {
            return Redirect::back()->with('error', 'Email Could not send');
        }

        return Redirect::back()->with('success', 'Email Sent');
    }

    public function mailSubscribers($id)
    {
        $event = $this->eventRepository->findById($id)->subscribers;
        try {
            $this->mailer->sendMail($event, Input::all());
        }
        catch ( \Exception $e ) {
            return Redirect::back()->with('error', 'Email Could not send');
        }

        return Redirect::back()->with('success', 'Email Sent');
    }

    public function settings($id)
    {
        $event               = $this->eventRepository->findById($id);
        $subscriptions_count = $event->subscriptions()->count();
        $favorites_count     = $event->favorites()->count();
        $followers_count     = $event->followers()->count();
//        $requests_count      = $event->statuses()->count();
        $requests_count      = 0;

        $this->render('admin.events.settings', compact('event', 'subscriptions_count', 'favorites_count', 'followers_count', 'requests_count'));
    }

    /**
     * @param $id
     * @return mixed
     * Returns the Followers For the Post, Event
     */
    public function getFollowers($id)
    {
        $users = $this->eventRepository->findById($id)->followers;
        $event = $this->eventRepository->findById($id);

        $this->render('admin.events.followers', compact('users', 'event'));
    }

    /**
     * @param $id
     * @return mixed
     * Returns the Favorites For the Post, Event
     */
    public function getFavorites($id)
    {
        $users = $this->eventRepository->findById($id)->favorites;
        $event = $this->eventRepository->findById($id);

        $this->render('admin.events.favorites', compact('users', 'event'));
    }

    /**
     * @param $id
     * @return mixed
     * Returns the Subscriptions For the Post, Event
     */
    public function getSubscriptions($id)
    {
        $users = $this->eventRepository->findById($id)->subscriptions;
        $event = $this->eventRepository->findById($id);

        $this->render('admin.events.subscriptions', compact('users', 'event'));
    }

    public function getRequests($id)
    {
        $event = $this->eventRepository->findById($id);
//        dd($event->subscriptions);

        $this->render('admin.events.requests', compact('event'));
    }


    public function selectType()
    {
        $this->render('admin.events.select-type');
    }


}
