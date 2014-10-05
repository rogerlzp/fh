<?php

namespace Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Tricks\Repositories\ActivityRepositoryInterface;
use Tricks\Repositories\TagRepositoryInterface;
use Tricks\Repositories\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;

class ActivityController extends BaseController
{
    /**
     * Activity repository.
     *
     * @var \Tricks\Repositories\ActivityRepositoryInterface
     */
    protected $activity;
    
    protected $tags;
    protected $catrgories;

    /**
     * Create a new ActivityController instance.
     *
     * @param  \Tricks\Repositories\ActivityRepositoryInterface  $activity
     * @return void
     */
    public function __construct(ActivityRepositoryInterface $activity,         
    		TagRepositoryInterface $tags,
        CategoryRepositoryInterface $categories)
    {
        parent::__construct();

        $this->activity = $activity;
        $this->tags = $tags;
        $this->categories = $categories;
    }

    /**
     * Show the admin activity index page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $activities = $this->activity->findAllPaginated();

        $this->view('admin.activity.list', compact('activities'));
    }

    /**
     * Handle the creation of a activity.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postIndex()
    {
        $form = $this->activity->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.activity.index')
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $activity = $this->activity->create($form->getInputData());

        return $this->redirectRoute('admin.activity.index');
    }

    /**
     * Update the order of the activity.
     *
     * @return \Response
     */
    public function postArrange()
    {
        $decoded = Input::get('data');

        if ($decoded) {
            $this->activity->arrange($decoded);
        }

        return 'ok';
    }

    /**
     * Show the activity edit form.
     *
     * @param  mixed $id
     * @return \Response
     */
    public function getView($id)
    {
        $activity = $this->activity->findById($id);
        $tagList      = $this->tags->listAll();
        $categoryList = $this->categories->listAll();

        
        $this->view('admin.activity.edit', compact('activity', 'tagList', 'categoryList'));
    }

    /**
     * Handle the editing of a activity.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postView($id)
    {
        $form = $this->activity->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.activity.view', $id)
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $activity = $this->activity->update($id, $form->getInputData());
        


        return $this->redirectRoute('admin.activity.view', $id);
    }

    /**
     * Delete a activity from the database.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $this->activity->delete($id);

        return $this->redirectRoute('admin.activity.index');
    }
    
    
    /**
     * activity create form
     */
    public function getCreate() {
    	$this->view('admin.activity.new');
    }
    

    /**
     * activity create form
     */
    public function getDetail() {
   // 	$this->view('admin.activity.new');
    }
    
    
    /**
     * activity post create  
     * @return unknown
     */
    
    public function postCreate()
    {
    	Log::info('postCreate in ActivityController');
    	$form = $this->activity->getCreationForm();
    	if (! $form->isValid()) {
    		Log::info('Invalid');
    		return $this->redirectBack(['errors' => $form->getErrors() ]);
    	}
    	$data = [];
    	$data['user_id'] = Auth::user()->id;
    	$data['title'] = Input::get('title');
    	$data['description'] = Input::get('description');
    	$data['topic'] = Input::get('topic');
    	$data['startDate'] = Input::get('startDate');
    	$data['endDate'] = Input::get('endDate');
    	$data['address'] = Input::get('address');
    	$data['join_endtime'] = Input::get('join_endtime');
    	$data['fee'] = Input::get('fee');
    	$data['traffic'] = Input::get('traffic');
    	$data['yy'] = Input::get('yy');
    	$data['note'] = Input::get('note');


    	$activity = $this->activity->create($data);
    	

    	$tagList      = $this->tags->listAll();
    	$categoryList = $this->categories->listAll();
    	 
    	
    	return $this->view('admin.activity.detail', compact('activity', 'tagList', 'categoryList'));
    	// $this->redirectRoute('admin.activity.detail', $activity);

    }
    
    
    /**
     * Show the edit activity page.
     *
     * @param  string $slug
     * @return \Response
     */
    public function getEdit($id)
    {
    	Log::info("getEdit in ActivityController");
    	Log::info($id);
    	$activity        = $this->activity->findById($id);
    	$tagList      = $this->tags->listAll();
    	$categoryList = $this->categories->listAll();
    
    	$selectedTags       = $this->activity->listTagsIdsForActivity($activity);
    	$selectedCategories = $this->activity->listCategoriesIdsForActivity($activity);
    
    	$this->view('activity.edit', [
    			'tagList'            => $tagList,
    			'selectedTags'       => $selectedTags,
    			'categoryList'       => $categoryList,
    			'selectedCategories' => $selectedCategories,
    			'activity'              => $activity
    			]);
    }
    
    /**
     * Handle the editing of a Activity.
     *
     * @param  string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id)
    {
    	Log::info("postEdit in ActivityController");
    	Log::info($id);
    	$activity        = $this->activity->findById($id);
    //	$activity = $this->activity->findBySlug($slug);
    	$form  = $this->activity->getEditForm($activity->id);
    
    	if (! $form->isValid()) {
    		return $this->redirectBack([ 'errors' => $form->getErrors() ]);
    	}
    
    	$data  = $form->getInputData();
    	$activity = $this->activity->edit($activity, $data);
    
    	return $this->redirectRoute('activity.edit', [ $activity->slug ], [
    			'success' => \Lang::get('admin.activity_updated')
    			]);
    }
    /**
     * update the activity
     */
    public function postUpdate() {
    	Log::info('postUpdate in ActivityController');
    	$form = $this->activity->getEditForm();
    	if (! $form->isValid()) {
    		return $this->redirectBack(['errors' => $form->getErrors() ]);
    	}
    	$data = [];
    	$data['user_id'] = Auth::user()->id;
    	$data['title'] = Input::get('title');
    	$data['description'] = Input::get('description');
    	$data['topic'] = Input::get('topic');
    	$data['startDate'] = Input::get('startDate');
    	$data['endDate'] = Input::get('endDate');
    	$data['address'] = Input::get('address');
    	$data['join_endtime'] = Input::get('join_endtime');
    	$data['fee'] = Input::get('fee');
    	$data['traffic'] = Input::get('traffic');
    	$data['yy'] = Input::get('yy');
    	$data['note'] = Input::get('note');
    	
    	
    	$activity = $this->activity->create($data);
    	 
    	
    	$tagList      = $this->tags->listAll();
    	$categoryList = $this->categories->listAll();
    	
    	 
    	return $this->view('admin.activity.detail', compact('activity', 'tagList', 'categoryList'));
    }
}
