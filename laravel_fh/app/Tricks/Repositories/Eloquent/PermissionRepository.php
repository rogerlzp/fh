<?php

namespace Tricks\Repositories\Eloquent;

use Tricks\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Tricks\Services\Forms\PermissionForm;
use Tricks\Exceptions\TagNotFoundException;
use Tricks\Repositories\PermissionRepositoryInterface;

class PermissionRepository extends AbstractRepository implements PermissionRepositoryInterface
{
    /**
     * Create a new PermissionRepository instance.
     *
     * @param  \Tricks\Tag $tags
     * @return void
     */
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    /**
     * Get an array of key-value (id => name) pairs of all tags.
     *
     * @return array
     */
    public function listAll()
    {
        $permissios = $this->model->lists('name', 'id');

        return $permissios;
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
        $permissios = $this->model
                     ->orderBy($orderColumn, $orderDir)
                     ->get();

        return $permissios;
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
        $permission = $this->getNew();

        $permission->name = $data['name'];
        $permission->display_name =  $data['display_name'];

        $permission->save();

        return $permission;
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
        $permission = $this->findById($id);

        $permission->name = $data['name'];
        $permission->display_name = $data['display_name'];

        $permission->save();

        return $permission;
    }

    /**
     * Delete the specified Permission from the database.
     * TODO: remove the joint tables 
     * @param  mixed  $id
     * @return void
     */
    public function delete($id)
    {
        $permission = $this->findById($id);

     
        $permission->delete();
    }

    /**
     * Get the permission create/update form service.
     *
     * @return \Tricks\Services\Forms\PermissionForm
     */
    public function getForm()
    {
        return new PermissionForm;
    }
}
