<?php

namespace Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Tricks\Repositories\PermissionRepositoryInterface;

class PermissionController extends BaseController
{
    /**
     * Permission repository.
     *
     * @var \Tricks\Repositories\PermissionRepositoryInterface
     */
    protected $permissions;

    /**
     * Create a new PermissionController instance.
     *
     * @param  \Tricks\Repositories\PermissionRepositoryInterface  $role
     * @return void
     */
    public function __construct(PermissionRepositoryInterface $permissions)
    {
        parent::__construct();

        $this->permissions = $permissions;
    }

    /**
     * Show the admin role index page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $permissions = $this->permissions->findAll('created_at', 'asc');

        $this->view('admin.permission.list', compact('permissions'));
    }

    /**
     * Handle the creation of a category.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postIndex()
    {
        $form = $this->permissions->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.permission.index')
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $permission = $this->permissions->create($form->getInputData());

        return $this->redirectRoute('admin.permission.index');
    }

    /**
     * Update the order of the categories.
     *
     * @return \Response
     */
    public function postArrange()
    {
        $decoded = Input::get('data');

        if ($decoded) {
            $this->permissions->arrange($decoded);
        }

        return 'ok';
    }

    /**
     * Show the role edit form.
     *
     * @param  mixed $id
     * @return \Response
     */
    public function getView($id)
    {
        $permission = $this->permissions->findById($id);

        $this->view('admin.permission.edit', compact('permission'));
    }

    /**
     * Handle the editing of a category.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postView($id)
    {
        $form = $this->permissions->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.permission.view', $id)
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $permission = $this->permissions->update($id, $form->getInputData());

        return $this->redirectRoute('admin.permission.view', $id);
    }

    /**
     * Delete a category from the database.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $this->permissions->delete($id);

        return $this->redirectRoute('admin.permission.index');
    }
}
