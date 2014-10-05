<?php

namespace Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Tricks\Repositories\CategoryRepositoryInterface;
use Tricks\Repositories\Category2RepositoryInterface;

class Category2Controller extends BaseController
{
    /**
     * Category2 repository.
     *
     * @var \Tricks\Repositories\Category2RepositoryInterface
     */
    protected $categories2;

    /**
     * Create a new CategoriesController instance.
     *
     * @param  \Tricks\Repositories\Category2RepositoryInterface  $categories2
     * @return void
     */
    public function __construct(Category2RepositoryInterface $categories2)
    {
        parent::__construct();

        $this->categories2 = $categories2;
    }

    /**
     * Show the admin categories2 index page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $categories = $this->categories2->findAll();

        $this->view('admin.categories2.list', compact('categories'));
    }

    /**
     * Handle the creation of a category2.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postIndex()
    {
        $form = $this->categories2->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.categories2.index')
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $category = $this->categories2->create($form->getInputData());

        return $this->redirectRoute('admin.category2.index');
    }

    /**
     * Update the order of the categories2.
     *
     * @return \Response
     */
    public function postArrange()
    {
        $decoded = Input::get('data');

        if ($decoded) {
            $this->categories2->arrange($decoded);
        }

        return 'ok';
    }

    /**
     * Show the category edit form.
     *
     * @param  mixed $id
     * @return \Response
     */
    public function getView($id)
    {
        $category = $this->categories2->findById($id);

        $this->view('admin.categories2.edit', compact('category'));
    }

    /**
     * Handle the editing of a category.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postView($id)
    {
        $form = $this->categories2->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.category2.view', $id)
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $category = $this->categories2->update($id, $form->getInputData());

        return $this->redirectRoute('admin.category2.view', $id);
    }

    /**
     * Delete a category from the database.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $this->categories2->delete($id);

        return $this->redirectRoute('admin.category2.index');
    }
}
