<?php

namespace Tricks\Repositories\Eloquent;

use Tricks\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Tricks\Services\Forms\PermissionForm;
use Tricks\Exceptions\TagNotFoundException;
use Tricks\Repositories\PermissionRepositoryInterface;

class RoleRepository extends AbstractRepository implements RoleRepositoryInterface
{
    /**
     * Create a new PermissionRepository instance.
     *
     * @param  \Tricks\Tag $tags
     * @return void
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * Get an array of key-value (id => name) pairs of all tags.
     *
     * @return array
     */
    public function listAll()
    {
        $roles = $this->model->lists('name', 'id');

        return $roles;
    }

    /**
     * Find all permissions.
     *
     * @param  string  $orderColumn
     * @param  string  $orderDir
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Tag[]
     */
    public function findAll($orderColumn = 'created_at', $orderDir = 'desc')
    {
        $roles = $this->model
                     ->orderBy($orderColumn, $orderDir)
                     ->get();

        return $roles;
    }

    /**
     * Find a tag by id.
     *
     * @param  mixed  $id
     * @return \Tricks\Tag
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

   

    /**
     * Create a new permission in the database.
     *
     * @param  array  $data
     * @return \Tricks\Tag
     */
    public function create(array $data)
    {
        $role = $this->getNew();

        $role->name = $data['name'];

        $role->save();

        return $role;
    }

    /**
     * Update the specified tag in the database.
     *
     * @param  mixed  $id
     * @param  array  $data
     * @return \Tricks\Category
     */
    public function update($id, array $data)
    {
        $role = $this->findById($id);

        $role->name = $data['name'];


        $role->save();

        return $role;
    }

    /**
     * Delete the specified Permission from the database.
     * TODO: remove the joint tables 
     * @param  mixed  $id
     * @return void
     */
    public function delete($id)
    {
        $role = $this->findById($id);

     
        $role->delete();
    }

    /**
     * Get the permission create/update form service.
     *
     * @return \Tricks\Services\Forms\PermissionForm
     */
    public function getForm()
    {
        return new RoleForm;
    }
}
