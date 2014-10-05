<?php namespace Controllers;

use Tricks\Repositories\LikeRepositoryInterface;
use Tricks\Repositories\BoardRepositoryInterface;
use Tricks\Repositories\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Log;
use Tricks\Image;

class LikeController extends BaseController {
	
	protected $like;

	
	/**
	 * Create a new BoardController instance.
	 *
	 * @param \Tricks\Repositories\BoardRepositoryInterface  $board
	 * @return void
	 */
	public function __construct(LikeRepositoryInterface $like)
	{
		parent::__construct();
	
		$this->like = $like;
	}
	
	/**
	 * Show the single board page.
	 *
	 * @param  string $id
	 * @return \Response
	 */
	public function postLike()
	{
		Log::info("LikeController.postLike");
		$imageId = Input::get('image_id');
		$boardId = Input::get('board_id');
		Log::info('imageId: '.$imageId);
		if($imageId) {
			$liketable_type = 'Tricks\\Image';
		} 
	
		$data = array(
				'liketable_type' => $liketable_type,
				'liketable_id' => $imageId,
				'user_id' => Auth::user()->id,
		);
		
		Log::info('liketable_type'.$liketable_type);
	//	Log::info('liketable_id'.$liketable_id);
		
		$like = $this->like->create($data);

		return $like;	
	}
	
	/**
	 * Show the single board page.
	 *
	 * @param  string $id
	 * @return \Response
	 */
	public function postDislike()
	{
		Log::info("LikeController.postDislike");
		$imageId = Input::get('image_id');
		$boardId = Input::get('board_id');
		Log::info('imageId: '.$imageId);
		if($imageId) {
			$liketable_type = 'Tricks\\Image';
		}
	

		$like = $this->like->findByData(Auth::user()->id, $liketable_type, $imageId);
		$like->delete();
		
		return Response::json('success', 200);
	}
	
	

	
	
	
	
}