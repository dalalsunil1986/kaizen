<?php
use Acme\Category\CategoryRepository;
use Acme\EventModel\EventRepository;
use Acme\Location\LocationRepository;
use Acme\Package\PackageRepository;
use Acme\Photo\PhotoRepository;
use Acme\Setting\SettingRepository;
use Acme\Tag\TagRepository;
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
    protected $eventTags;
    /**
     * @var Acme\Setting\SettingRepository
     */
    private $settingRepository;
    /**
     * @var Acme\EventModel\EventPhotoService
     */
    private $imageService;
    /**
     * @var Acme\Package\PackageRepository
     */
    private $packageRepository;
    /**
     * @var Acme\Tag\TagRepository
     */
    private $tagRepository;

    function __construct(EventRepository $eventRepository, CategoryRepository $categoryRepository, LocationRepository $locationRepository, UserRepository $userRepository, PhotoRepository $photoRepository, SettingRepository $settingRepository, PackageRepository $packageRepository, eventModel $eventTags, TagRepository $tagRepository)
    {
        $this->eventRepository    = $eventRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository     = $userRepository;
        $this->photoRepository    = $photoRepository;
        $this->locationRepository = $locationRepository;
        $this->settingRepository  = $settingRepository;
        $this->packageRepository  = $packageRepository;
        $this->eventTags          = $eventTags;
        $this->tagRepository      = $tagRepository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $events   = $this->eventRepository->getAll(array('category', 'location.country','setting'))->paginate(10);
        $packages = $this->packageRepository->getAll();
        $this->render('admin.events.index', compact('events', 'packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $category = $this->select + $this->categoryRepository->getEventCategories()->lists('name_ar', 'id');
        $author   = $this->select + $this->userRepository->getRoleByName('author')->lists('username', 'id');
        $location = $this->select + $this->locationRepository->getAll()->lists('name_ar', 'id');
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

        if ( !$val->isValid() ) {
            return Redirect::back()->withInput()->withErrors($val->getErrors());
        }

        if (Input::get('date_start') < Input::get('date_end')) {
            dd('wrong value');
        }

        if ( !$event = $this->eventRepository->create($val->getInputData()) ) {
            return Redirect::back()->with('errors', $this->eventRepository->errors())->withInput();
        }

        if ( !$setting = $this->settingRepository->create(['settingable_type' => 'EventModel', 'settingable_id' => $event->id]) ) {
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
        $event      = $this->eventRepository->findById($id, ['photos']);
        $tags       = $this->tagRepository->getAll();
        $tags_array = $event->tags->lists('id');

        $category = $this->select + $this->categoryRepository->getEventCategories()->lists('name_ar', 'id');
        $author   = $this->select + $this->userRepository->getRoleByName('author')->lists('username', 'id');
        $location = $this->select + $this->locationRepository->getAll()->lists('name_ar', 'id');

        $this->render('admin.events.edit', compact('event', 'category', 'author', 'location', 'tags_array', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $event = $this->eventRepository->findById($id);

        $val = $this->eventRepository->getEditForm($id);

        if ( !$val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if (Input::get('date_start') > Input::get('date_end')) {
            return Redirect::back()->with('error', 'Event Date Start Cannot be greater than Event End Date');
        }

        if ( !$this->eventRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->eventRepository->errors())->withInput();
        }

        // update the tags
        $tags = is_array(Input::get('tag')) ? Input::get('tag') : [];
        $this->tagRepository->attachTags($event, $tags );

        return Redirect::action('AdminEventsController@edit', $id)->with('success', 'Updated');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ( $this->eventRepository->findById($id)->delete() ) {
            //  return Redirect::home();
            return Redirect::action('AdminEventsController@index')->with('success', 'Event Deleted');
        }

        return Redirect::action('AdminEventsController@index')->with('error', 'Error: Event Not Found');
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

    public function getSettings($id)
    {
        $event               = $this->eventRepository->findById($id);
        $subscriptions_count = $event->subscriptions()->where('status','CONFIRMED')->count();
        $favorites_count     = $event->favorites()->count();
        $followers_count     = $event->followers()->count();
        $requests_count      = $event->subscriptions()->count();

        $this->render('admin.events.settings', compact('event', 'subscriptions_count', 'favorites_count', 'followers_count', 'requests_count'));
    }

    public function getDetails($id)
    {
        $event               = $this->eventRepository->findById($id);
        $subscriptions_count = $event->subscriptions()->where('status','CONFIRMED')->count();
        $favorites_count     = $event->favorites()->count();
        $followers_count     = $event->followers()->count();
        $requests_count      = $event->subscriptions()->count();

        $this->render('admin.events.details', compact('event', 'subscriptions_count', 'favorites_count', 'followers_count', 'requests_count'));
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
        $event = $this->eventRepository->findById($id);
        $subscriptions = $event->subscriptions()->ofStatus('CONFIRMED')->get();

        $this->render('admin.events.subscriptions', compact('event','subscriptions'));
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
