<?php

namespace Tricks\Repositories;

use Tricks\User;
use Tricks\Activity;
use Tricks\Trick;

interface ActivityRepositoryInterface
{
    /**
     * Find all the activities for the given user paginated.
     *
     * @param  \User $user
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Activity[]
     */
    public function findAllForUser(User $user, $perPage = 9);

    /**
     * Find all acivities that are favorited by the given user paginated.
     *
     * @param  \User $user
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Activity[]
     */
    public function findAllFavorites(User $user, $perPage = 9);

    /**
     * Find a activity by the given slug.
     *
     * @param  string $slug
     * @return \Tricks\Activity
     */
    public function findBySlug($slug);

    /**
     * Find all the activites paginated.
     *
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Activity[]
     */
    public function findAllPaginated($perPage = 9);

    /**
     * Find all activities order by the creation date paginated.
     *
     * @param  integer $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Activity[]
     */
    public function findMostRecent($per_page = 9);

    /**
     * Find the activities ordered by the number of comments paginated.
     *
     * @param  integer $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Activity[]
     */
    public function findMostCommented($per_page = 9);

    /**
     * Find the activities ordered by popularity (most liked / viewed) paginated.
     *
     * @param  integer $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Activity[]
     */
    public function findMostPopular($per_page = 9);

    /**
     * Find the last 15 activities that were added.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Activity[]
     */
    public function findForFeed();

    /**
     * Find all activities for sitemap.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Activity[]
     */
    public function findAllForSitemap();

    /**
     * Find all activities that match the given search term.
     *
     * @param  string $term
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Activity[]
     */
    public function searchByTermPaginated($term, $perPage);

    /**
     * Find all activities for the category that matches the given slug.
     *
     * @param  string $slug
     * @param  integer $perPage
     * @return array
     */
    public function findByCategory($slug, $perPage = 9);

    /**
     * Get a list of tag ids that are associated with the given activity.
     *
     * @param  \Tricks\Activity $activity
     * @return array
     */
    public function listTagsIdsForTrick(Activity $activity);

    /**
     * Get a list of category ids that are associated with the given activity.
     *
     * @param  \Tricks\Activity $activity
     * @return array
     */
    public function listCategoriesIdsForTrick(Activity $activity);

    /**
     * Create a new activity in the database.
     *
     * @param  array $data
     * @return \Tricks\Activity
     */
    public function create(array $data);

    /**
     * Update the activity in the database.
     *
     * @param  \Tricks\Activity $activity
     * @param  array $data
     * @return \Tricks\Activity
     */
    public function edit(Activity $activity, array $data);

    /**
     * Increment the view count on the given activity.
     *
     * @param  \Tricks\Activity  $activity
     * @return \Tricks\Activity
     */
    public function incrementViews(Activity $activity);

    /**
     * Find all tricks for the tag that matches the given slug.
     *
     * @param  string $slug
     * @param  integer $perPage
     * @return array
     */
    public function findByTag($slug, $perPage = 9);

    /**
     * Find the next activity that was added after the given activity.
     *
     * @param  \Tricks\Activity  $aqtivity
     * @return \Tricks\Activity|null
     */
    public function findNextTrick(Activity $activity);
	
    /**
     * Find the previous activity added before the given activity.
     *
     * @param  \Tricks\Activity  $activity
     * @return \Tricks\Activity|null
     */
    public function findPreviousTrick(Activity $activity);

    /**
     * Check if the user owns the activity corresponding to the given slug.
     *
     * @param  string  $slug
     * @param  mixed   $userId
     * @return bool
     */
    public function isTrickOwnedByUser($slug, $userId);
}
