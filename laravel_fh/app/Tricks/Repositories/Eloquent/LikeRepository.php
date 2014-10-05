<?php namespace Tricks\Repositories\Eloquent;

use Tricks\Like;
use Tricks\Repositories\LikeRepositoryInterface;
use Tricks\Services\Forms\ImageForm;
use Tricks\User;

use Illuminate\Support\Facades\Log;

class LikeRepository extends AbstractRepository implements LikeRepositoryInterface {

	protected $like;

	public function __construct(Like $like) {
		$this->model = $like;
	}


	/**
	 * Create a new like in the database.
	 * @todo update the cache
	 * @param  array $data
	 * @return \Tricks\Like
	 * 
	 */
	
	public function create(array $data)
	{
		$like = $this->getNew();
		$like->liketable_type = $data['liketable_type'];
		$like->liketable_id = $data['liketable_id'];
		$like->user_id     = $data['user_id'];
		$like->save();
	
		return $like;
	
	}


	/**
	 * Get the image creation form service.
	 *
	 * @return \Tricks\Services\Forms\ImageForm
	 */
	public function getCreationForm()
	{
		return new LikeForm;
	}

	public function update($id, array $data) {
		//TODO
	}

	/**
	 * Delete the specified Image from the database.
	 *
	 * @param  mixed $id
	 * @return void
	 */
	public function delete($id) {
		//TODO
	}

	public function findByData($user_id, $liketable_type, $liketable_id){
		$like = $this->model->where('user_id', $user_id)
							->where('liketable_type', $liketable_type)	
							->where('liketable_id', $liketable_id);
		
		
		return $like;
	}
	


}
