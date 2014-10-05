<?php

namespace Controllers;

use Tricks\Repositories\ActivityRepositoryInterface;

class HomeController extends BaseController
{
    /**
     * Activity repository.
     *
     * @var \Tricks\Repositories\ActivityRepositoryInterface
     */
    protected $activity;

    /**
     * Create a new HomeController instance.
     *
     * @param  \Tricks\Repositories\ActivityRepositoryInterface  $activity
     * @return void
     */
    public function __construct(ActivityRepositoryInterface $activity)
    {
        parent::__construct();

        $this->activity = $activity;
    }

    /**
     * Show the homepage.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $activities = $this->activity->findAllPaginated();

        $this->view('home.index', compact('activities'));
    }

    /**
     * Show the about page.
     *
     * @return \Response
     */
    public function getAbout()
    {
        $this->view('home.about');
    }
}
