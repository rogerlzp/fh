<?php namespace Controllers;

use Tricks\Repositories\CommentRepositoryInterface;
use Tricks\Repositories\BoardRepositoryInterface;
use Tricks\Repositories\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Log;
use Tricks\Image;

class CommentController extends BaseController {
	
	protected $comment;

	
	/**
	 * Create a new BoardController instance.
	 *
	 * @param \Tricks\Repositories\BoardRepositoryInterface  $board
	 * @return void
	 */
	public function __construct(CommentRepositoryInterface $comment)
	{
		parent::__construct();
	
		$this->comment = $comment;
	}
	
	/**
	 * Show the single board page.
	 *
	 * @param  string $id
	 * @return \Response
	 */
	public function postComment()
	{
		Log::info("CommentController.postComment");
		$imageId = Input::get('image_id');
		$boardId = Input::get('board_id');
		Log::info('imageId: '.$imageId);
		if($imageId) {
			$commentable_type = 'Tricks\\Image';
		} 
	
		$data = array(
				'commentable_type' => $commentable_type,
				'commentable_id' => $imageId,
				'content' => Input::get('content'),
				'user_id' => Auth::user()->id,
		);
		Log::info('commentable_type: '.$commentable_type);
		
		$comment = $this->comment->create($data);
		Log::info('postComment '. $comment);
		
		return $comment;

		
	}
	
	
	
	
	
}