<?php

namespace Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Tricks\Repositories\ActivityRepositoryInterface;

class ActivityController extends BaseController
{
    /**
     * Activity repository.
     *
     * @var \Tricks\Repositories\ActivityRepositoryInterface
     */
    protected $activity;

    /**
     * Create a new ActivityController instance.
     *
     * @param \Tricks\Repositories\ActivityRepositoryInterface  $activity
     * @return void
     */
    public function __construct(ActivityRepositoryInterface $activity)
    {
        parent::__construct();

        $this->activity = $activity;
    }

    /**
     * Show the single activity page.
     *
     * @param  string $slug
     * @return \Response
     */
    public function getShow($slug = null)
    {
        if (is_null($slug)) {
            return $this->redirectRoute('home');
        }

        $activity = $this->activity->findBySlug($slug);

        if (is_null($activity)) {
            return $this->redirectRoute('home');
        }

        Event::fire('activity.view', $activity);

        $next = $this->activity->findNextTrick($activity);
        $prev = $this->activity->findPreviousTrick($activity);

        $this->view('activity.single', compact('activity', 'next', 'prev'));
    }

    /**
     * Handle the liking of a activity.
     *
     * @param  string $slug
     * @return \Response
     */
    public function postLike($slug)
    {
        if (! Request::ajax() || ! Auth::check()) {
            $this->redirectRoute('browse.recent');
        }

        $activity = $this->activity->findBySlug($slug);

        if (is_null($activity)) {
            return Response::make('error', 404);
        }

        $user = Auth::user();

        $voted = $activity->votes()->whereUserId($user->id)->first();

        if(!$voted) {

            $user = $activity->votes()->attach($user->id, [
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime
            ]);
            $activity->vote_cache = $activity->vote_cache + 1;

        } else {
            $activity->votes()->detach($voted->id);
            $activity->vote_cache = $activity->vote_cache - 1;
        }

        $activity->save();

        return Response::make($activity->vote_cache, 200);
    }
}
