<?php

namespace Tricks\Repositories\Eloquent;

use Tricks\Category2;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Tricks\Services\Forms\Category2Form;
use Tricks\Exceptions\CategoryNotFoundException;
use Tricks\Repositories\Category2RepositoryInterface;

class Category2Repository extends AbstractRepository implements Category2RepositoryInterface
{
    /**
     * Create a new DbCategoryRepository instance.
     *
     * @param  \Tricks\Category  $category
     * @return void
     */
    public function __construct(Category2 $category2)
    {
        $this->model = $category2;
    }

    /**
     * Get an array of key-value pairs of all categories.
     *
     * @return array
     */
    public function listAll()
    {
        $categories = $this->model->lists('name', 'id');

        return $categories;
    }

    /**
     * Find all categories.
     *
     * @param  string  $orderColumn
     * @param  string  $orderDir
     * @return \Illuminate\Database\Eloquent\Collection|\Category[]
     */
    public function findAll($orderColumn = 'created_at', $orderDir = 'desc')
    {
        $categories = $this->model
                           ->orderBy($orderColumn, $orderDir)
                           ->get();

        return $categories;
    }

    /**
     * Find all categories with the associated number of tricks.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Trick[]
     */
    public function findAllWithTrickCount()
    {
        return $this->model->leftJoin('category_trick', 'categories.id', '=', 'category_trick.category_id')
                           ->leftJoin('tricks', 'tricks.id', '=', 'category_trick.trick_id')
                           ->groupBy('categories.slug')
                           ->orderBy('trick_count', 'desc')
                           ->get([
                               'categories.name',
                               'categories.slug',
                               DB::raw('COUNT(tricks.id) as trick_count')
                           ]);
    }

    /**
     * Find a category by id.
     *
     * @param  mixed $id
     * @return \Tricks\Category
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create a new category in the database.
     *
     * @param  array $data
     * @return \Tricks\Category
     */
    public function create(array $data)
    {
        $category2 = $this->getNew();

        $category2->name        = e($data['name']);
        $category2->slug        = Str::slug($category2->name, '-');
        $category2->description = $data['description'];
 //       $category2->order       = $this->getMaxOrder() + 1;

        $category2->save();

        return $category2;
    }

    /**
     * Update the specified category in the database.
     *
     * @param  mixed $id
     * @param  array $data
     * @return \Tricks\Category
     */
    public function update($id, array $data)
    {
        $category2 = $this->findById($id);

        $category2->name         = e($data['name']);
        $category2->slug         = Str::slug($category2->name, '-');
        $category2->description  = $data['description'];

        $category2->save();

        return $category2;
    }

    /**
     * The the highest order number from the database.
     *
     * @return int
     */
    /*
    public function getMaxOrder()
    {
        return $this->model->max('order');
    }
	*/

    /**
     * Delete the specified category from the database.
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
        $category = $this->findById($id);
    //    $category->tricks()->detach();  //TODO: update the products later
        $category->delete();
    }

    /**
     * Re-arrange the categories in the database.
     *
     * @param  array $data
     * @return void
     */
    public function arrange(array $data)
    {
        $ids = array_values($data);
        $categories = $this->model->whereIn('id', $ids)->get([ 'id' ]);

        foreach ($data as $order => $id) {
            if ($category = $categories->find($id)) {
                $category->order = $order;
                $category->save();
            }
        }
    }

    /**
     * Get the category create/update form service.
     *
     * @return \Tricks\Services\Forms\CategoryForm
     */
    public function getForm()
    {
        return new Category2Form;
    }
}
