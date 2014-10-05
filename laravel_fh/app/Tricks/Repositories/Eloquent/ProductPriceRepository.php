<?php

namespace Tricks\Repositories\Eloquent;

use Tricks\ProductPrice;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Tricks\Services\Forms\ProductPriceForm;
use Tricks\Exceptions\CategoryNotFoundException;
use Tricks\Repositories\ProductPriceRepositoryInterface;

class ProductPriceRepository extends AbstractRepository implements ProductPriceRepositoryInterface
{
    /**
     * Create a new DbCategoryRepository instance.
     *
     * @param  \Tricks\Category  $category
     * @return void
     */
    public function __construct(ProductPrice $productprice)
    {
        $this->model = $productprice;
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
        $productprice = $this->getNew();

        $productprice->product_id        = e($data['product_id']);
        $productprice->price = $data['price'];
        $productprice->save();

        return $productprice;
    }

  

    /**
     * Get the category create/update form service.
     *
     * @return \Tricks\Services\Forms\CategoryForm
     */
    public function getForm()
    {
        return new ProductPriceForm;
    }
}
