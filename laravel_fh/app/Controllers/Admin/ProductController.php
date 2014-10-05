<?php

namespace Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Tricks\Repositories\ProductRepositoryInterface;
use Tricks\Repositories\ImageRepositoryInterface;
use Tricks\Repositories\ProductPriceRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ProductController extends BaseController
{
    /**
     * Product repository.
     *
     * @var \Tricks\Repositories\ProductRepositoryInterface
     */
    protected $products;
    
    protected $image;
    protected $productprice;

    /**
     * Create a new ProductController instance.
     *
     */
    public function __construct(ProductRepositoryInterface $products, ImageRepositoryInterface $image,
ProductPriceRepositoryInterface $productprice)
    {
        parent::__construct();

        $this->products = $products;
        $this->image = $image;
        $this->productprice = $productprice;
    }

    /**
     * Show the admin products index page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $products = $this->products->findAllPaginated();

        $this->view('admin.product.list', compact('products'));
    }

    /**
     * Handle the creation of a product.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postIndex()
    {
        $form = $this->product->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.product.index')
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $product = $this->products->create($form->getInputData());

        return $this->redirectRoute('admin.product.index');
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
        $product = $this->products->findById($id);

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
        $form = $this->products->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.product.view', $id)
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $product = $this->products->update($id, $form->getInputData());

        return $this->redirectRoute('admin.product.view', $id);
    }

    /**
     * Delete a product from the database.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $this->products->delete($id);

        return $this->redirectRoute('admin.product.index');
    }
    
    /**
     * product create form
     */
    public function getCreate() {
    	$this->view('admin.product.new');	
    }
    
  
    
    public function postCreate()
    {
    	Log::info('postCreate in ProductController');
    	$form = $this->products->getCreationForm();
        	if (! $form->isValid()) {
        		Log::info('Invalid');
    		return $this->redirectBack(['errors' => $form->getErrors() ]);
    	}
    	$data = [];
    	$data['user_id'] = Auth::user()->id;
    	$data['image_id'] = 1; // default image_id
    	$data['name'] = Input::get('name');
    	$data['sku'] = Input::get('sku');
    	$data['stock'] = Input::get('stock');
    	$data['short_description'] = Input::get('short_description');
    	
    	$product = $this->products->create($data);
    	
    	return  $product;

    }
    
    
    public function postUpdateImage() {
    	$id = Input::get('product_id');
    	// Add a new Image first,
    	//TODO: update it to check if it already exists
    	
    	$data=[];
    	$data['image_path'] = Input::get('image_path');
    	$data['user_id'] = Auth::user()->id;
    	
    	$newImage = $this->image->createFromProduct($data);
    	
    	$product = $this->products->findById($id);
    	Log::info($product);
    	$product->image_id = $newImage->id;
    	$product->save();
        
    	return Response::json('success', 200);
    	
    }
    
    public function postUpdatePrice() {
    	$data=[];
    	$data['user_id'] = Auth::user()->id;
    	$data['price'] = Input::get('price');
    	$data['product_id'] = Input::get('product_id');
    	 
    	$price = $this->productprice->create($data);
    
    	return Response::json('success', 200);
    	 
    }
    
    
}
