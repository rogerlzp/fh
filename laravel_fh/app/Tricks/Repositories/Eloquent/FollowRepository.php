<?php namespace Tricks\Repositories\Eloquent;

use Tricks\Follow;
use Tricks\Repositories\FollowRepositoryInterface;
use Tricks\Services\Forms\ImageForm;
use Tricks\User;

use Illuminate\Support\Facades\Log;

class FollowRepository extends AbstractRepository implements FollowRepositoryInterface {

	protected $follow;

	public function __construct(Follow $follow) {
		$this->model = $follow;
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
		Log::info('create in followsRepositry.php');
		Log::info($data);
		$follow = $this->getNew();
		$follow->follow_id = $data['follow_id'];
		$follow->user_id     = $data['user_id'];
		$follow->save();
		return $follow;
	}
	
	/**
	 * delete follow relation ship
	 * @param unknown $user_id
	 * @param unknown $follow_id
	 */
	public function deleteFollow($user_id, $follow_id){
		$follow = $this->model->where('user_id', $user_id)
		->where('follow_id', $follow_id);
		$follow->delete();
	}
	
	public function delete($id){}


}