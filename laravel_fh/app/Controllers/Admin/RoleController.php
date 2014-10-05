<?php

namespace Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Tricks\Repositories\RoleRepositoryInterface;

class RoleController extends BaseController
{
    /**
     * Role repository.
     *
     * @var \Tricks\Repositories\CategoryRepositoryInterface
     */
    protected $roles;

    /**
     * Create a new RoleController instance.
     *
     * @param  \Tricks\Repositories\RoleRepositoryInterface  $role
     * @return void
     */
    public function __construct(RoleRepositoryInterface $roles)
    {
        parent::__construct();

        $this->roles = $roles;
    }

    /**
     * Show the admin role index page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $roles = $this->roles->findAll('created_at', 'asc');

        $this->view('admin.role.list', compact('roles'));
    }

    /**
     * Handle the creation of a category.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postIndex()
    {
        $form = $this->roles->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.roles.index')
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $role = $this->roles->create($form->getInputData());

        return $this->redirectRoute('admin.role.index');
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
            $this->roles->arrange($decoded);
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
        $role = $this->roles->findById($id);

        $this->view('admin.role.edit', compact('role'));
    }

    /**
     * Handle the editing of a category.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postView($id)
    {
        $form = $this->roles->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.role.view', $id)
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $role = $this->roles->update($id, $form->getInputData());

        return $this->redirectRoute('admin.role.view', $id);
    }

    /**
     * Delete a category from the database.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $this->roles->delete($id);

        return $this->redirectRoute('admin.role.index');
    }
}
