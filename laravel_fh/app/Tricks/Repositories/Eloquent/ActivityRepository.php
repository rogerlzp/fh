<?php

namespace Tricks\Repositories\Eloquent;

use Disqus;
use Tricks\Tag;
use Tricks\User;
use Tricks\Trick;
use Tricks\Category;
use Tricks\Activity;
use Illuminate\Support\Str;
use Tricks\Services\Forms\TrickForm;
use Tricks\Services\Forms\ActivityForm;
use Tricks\Services\Forms\TrickEditForm;
use Tricks\Exceptions\TagNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Tricks\Exceptions\CategoryNotFoundException;
use Tricks\Repositories\ActivityRepositoryInterface;

class ActivityRepository extends AbstractRepository implements ActivityRepositoryInterface
{
    /**
     * Category model.
     *
     * @var \Tricks\Category
     */
    protected $category;

    /**
     * Tag model.
     *
     * @var \Tricks\Tag
     */
    protected $tag;

    /**
     * Create a new DbTrickRepository instance.
     *
     * @param  \Tricks\Activity  $activity
     * @param  \Tricks\Category  $category
     * @param  \Tricks\Tag  $tag
     * @return void
     */
    public function __construct(Activity $activity, Category $category, Tag $tag)
    {
        $this->model    = $activity;
        $this->category = $category;
        $this->tag      = $tag;
    }

    /**
     * Find all the activity for the given user paginated.
     *
     * @param  \Tricks\User $user
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
   public function findAllForUser(User $user, $perPage = 9)
    {
        $activities = $user->activities()->orderBy('created_at', 'DESC')->paginate($perPage);

        return $tricks;
    }
 
    /**
     * Find all activities that are favorited by the given user paginated.
     *
     * @param  \Tricks\User $user
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Activity[]
     */
    public function findAllFavorites(User $user, $perPage = 9)
    {
        $activities = $user->votes()->orderBy('created_at', 'DESC')->paginate($perPage);

        return $activities;
    }

    /**
     * Find a activity by the given slug.
     *
     * @param  string $slug
     * @return \Tricks\Trick
     */
    public function findBySlug($slug)
    {
        return $this->model->whereSlug($slug)->first();
    }

    /**
     * Find all the Activity paginated.
     *
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Activity[]
     */
    public function findAllPaginated($perPage = 9)
    {
        $activity = $this->model->orderBy('created_at', 'DESC')->paginate($perPage);

        return $activity;
    }

    /**
     * Find all activities order by the creation date paginated.
     *
     * @param  integer $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Activity[]
     */
    public function findMostRecent($per_page = 9)
    {
        return $this->findAllPaginated($per_page);
    }

    /**
     * Find the tricks ordered by the number of comments paginated.
     *
     * @param  integer $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    
    public function findMostCommented($perPage = 9)
    {
        $activities = $this->model->orderBy('created_at', 'desc')->get();
/*
        $tricks = Disqus::appendCommentCounts($tricks);

        $tricks = $tricks->sortBy(function ($trick) {
            return $trick->comment_count;
        })->reverse();

        $page = \Input::get('page', 1);
        $skip = ($page - 1) * $perPage;
        $items = $tricks->all();
        array_splice($items, 0, $skip);

        return \Paginator::make($items, count($tricks), $perPage);
        */
    }
 
    /**
     * Find the activities ordered by popularity (most liked / viewed) paginated.
     *
     * @param  integer  $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Activity[]
     */
    public function findMostPopular($per_page = 9)
    {
        return $this->model
                    ->orderByRaw('(activity.vote_cache * 5 + activity.view_cache) DESC')
                    ->paginate($per_page);
    }

    /**
     * Find the last 15 activities that were added.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Activity[]
     */
    public function findForFeed()
    {
        return $this->model->orderBy('created_at', 'desc')->limit(15)->get();
    }

    /**
     * Find all activities.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Activity[]
     */
    public function findAllForSitemap()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    /**
     * Find all activities for the category that matches the given slug.
     *
     * @param  string $slug
     * @param  integer $perPage
     * @return array
     */
    public function findByCategory($slug, $perPage = 9)
    {
        $category = $this->category->whereSlug($slug)->first();

        if (is_null($category)) {
            throw new CategoryNotFoundException('The category "'.$slug.'" does not exist!');
        }

        $activities = $category->activities()->orderBy('created_at', 'DESC')->paginate($perPage);

        return [ $category, $activities ];
    }

    /**
     * Find all activities that match the given search term.
     *
     * @param  string $term
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function searchByTermPaginated($term, $perPage = 12)
    {
        $activities =  $this->model
                        ->orWhere('title', 'LIKE', '%'.$term.'%')
                        ->orWhere('description', 'LIKE', '%'.$term.'%')
                        ->orWhereHas('tags', function ($query) use ($term) {
                            $query->where('title', 'LIKE', '%' . $term . '%')
                                  ->orWhere('slug', 'LIKE', '%' . $term . '%');
                        })
                        ->orWhereHas('categories', function ($query) use ($term) {
                            $query->where('name', 'LIKE', '%' . $term . '%')
                                  ->orWhere('slug', 'LIKE', '%' . $term . '%');
                        })
                        ->orderBy('created_at', 'desc')
                        ->orderBy('title', 'asc')
                        ->paginate($perPage);

        return $activities;
    }

    /**
     * Get a list of tag ids that are associated with the given activities.
     *
     * @param  \Tricks\Activity $activity
     * @return array
     */
    public function listTagsIdsForTrick(Activity $activity)
    {
        return $activity->tags->lists('id');
    }

    /**
     * Get a list of category ids that are associated with the given activity.
     *
     * @param  \Tricks\Activity $activity
     * @return array
     */
    public function listCategoriesIdsForTrick(Activity $activity)
    {
        return $activity->categories->lists('id');
    }

    /**
     * Create a new a in the database.
     *
     * @param  array $data
     * @return \Tricks\Activity
     */
    public function create(array $data)
    {
        $activity = $this->getNew();

        $activity->user_id     = $data['user_id'];
        $activity->title       = e($data['title']);
        $activity->slug        = Str::slug($data['title'], '-');
        if ($activity->slug == "") {
        	$activity->slug =  $activity->title  ;
        } else if (!$activity->slug){
        	$activity->slug =  $activity->title  ;
        }
        $activity->description = e($data['description']);
        $activity->topic = e($data['topic']);
        $activity->startDate = e($data['startDate']);
        $activity->endDate = e($data['endDate']);
        $activity->address = e($data['address']);
        $activity->join_endtime = e($data['join_endtime']);
        $activity->fee = e($data['fee']);
        $activity->traffic = e($data['traffic']);
        $activity->yy = e($data['yy']);
        $activity->note = e($data['note']);
        
        $activity->save();

 //       $activity->tags()->sync($data['tags']);
 //      $activity->categories()->sync($data['categories']);

        return $activity;
    }

    /**
     * Update the activity in the database.
     *
     * @param  \Tricks\Activity $activity
     * @param  array $data
     * @return \Tricks\Activity
     */
    public function edit(Activity $activity, array $data)
    {
        //$trick->user_id = $data['user_id'];
    //	$activity = $this->findById($id);
    	
        $activity->title       = e($data['title']);
        $activity->slug        = Str::slug($data['title'], '-');
        if ($activity->slug == "") {
        	$activity->slug =  $activity->title  ;
        } else if (!$activity->slug){
        	$activity->slug =  $activity->title  ;
        }
        
        $activity->description = e($data['description']);
        $activity->topic        = e($data['topic']);
        $activity->startDate        = e($data['startDate']);
        $activity->endDate        = e($data['endDate']);
        $activity->address        = e($data['address']);
        $activity->join_endtime = e($data['join_endtime']);
        $activity->fee = e($data['fee']);
        $activity->traffic = e($data['traffic']);
        $activity->yy = e($data['yy']);
        $activity->note = e($data['note']);
        
        $activity->save();

        $activity->tags()->sync($data['tags']);
        $activity->categories()->sync($data['categories']);

        return $activity;
        
    }        


    /**
     * Increment the view count on the given activity.
     *
     * @param  \Tricks\Activity $activity
     * @return \Tricks\Activity
     */
    public function incrementViews(Activity $activity)
    {
        $activity->view_cache = $activity->view_cache + 1;
        $activity->save();

        return $activity;
    }

    /**
     * Find all activities for the tag that matches the given slug.
     *
     * @param  string $slug
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function findByTag($slug, $perPage = 9)
    {
        $tag = $this->tag->whereSlug($slug)->first();

        if (is_null($tag)) {
            throw new TagNotFoundException('The tag "' . $slug . '" does not exist!');
        }

        $activities = $tag->activities()->orderBy('created_at', 'desc')->paginate($perPage);

        return [ $tag, $activities ];
    }

    /**
     * Find the next activity that was added after the given activity.
     *
     * @param  \Tricks\Activity  $activity
     * @return \Tricks\Activity|null
     */
    public function findNextTrick(Activity $activity)
    {
        $next = $this->model->where('created_at', '>=', $activity->created_at)
                            ->where('id', '<>', $activity->id)
                            ->orderBy('created_at', 'asc')
                            ->first([ 'slug', 'title' ]);

        return $next;
    }

    /**
     * Find the previous activity added before the given trick.
     *
     * @param  \Tricks\Activity  $activity
     * @return \Tricks\Activity|null
     */
    public function findPreviousTrick(Activity $activity)
    {
        $prev = $this->model->where('created_at', '<=', $activity->created_at)
                            ->where('id', '<>', $activity->id)
                            ->orderBy('created_at', 'desc')
                            ->first([ 'slug', 'title' ]);

        return $prev;
    }

    /**
     * Check if the user owns the trick corresponding to the given slug.
     *
     * @param  string  $slug
     * @param  mixed   $userId
     * @return bool
     */
    public function isTrickOwnedByUser($slug, $userId)
    {
        return $this->model->whereSlug($slug)->whereUserId($userId)->exists();
    }

    /**
     * Get the activity creation form service.
     *
     * @return \Tricks\Services\Forms\ActivityForm
     */
    public function getCreationForm()
    {
        return new ActivityForm;
    }

    /**
     * Get the activity edit form service.
     *
     * @return \Tricks\Services\Forms\ActivityEditForm
     */
    public function getEditForm($id)
    {
        return new ActivityEditForm($id);
    }
    
    /**
     * Find a activity by id.
     *
     * @param  mixed $id
     * @return \Tricks\Activity
     */
    public function findById($id)
    {
    	return $this->model->find($id);
    }
    


}
