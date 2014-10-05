<?php namespace Tricks\Repositories\Eloquent;

use Tricks\Board;
use Tricks\User;
use Tricks\Comment;
use Tricks\Repositories\CommentRepositoryInterface;
use Tricks\Services\Forms\BoardForm;

use Illuminate\Support\Facades\Log;

class CommentRepository extends AbstractRepository implements CommentRepositoryInterface {
	
	protected $comment;
	
	public function __construct(Comment $comment) {
		$this->model = $comment;
	}
	
	
	/**
	 * Create a new board in the database.
	 *
	 * @param  array $data
	 * @return \Tricks\Comment
	 */
	public function create(array $data)
	{
		$comment = $this->getNew();
		
		$comment->content    = e($data['content']);
		$comment->commentable_type = $data['commentable_type'];
		$comment->commentable_id = $data['commentable_id'];
		$comment->user_id     = $data['user_id'];
		$comment->save();
		
		return $comment;

	}
	
	
	/**
	 * Get the board creation form service.
	 *
	 * @return \Tricks\Services\Forms\BoardForm
	 */
	public function getCreationForm()
	{
		// return new CommentForm;
	}
	
	public function update($id, array $data) {
		//TODO
	}
	
	/**
	 * Delete the specified Board from the database.
	 *
	 * @param  mixed $id
	 * @return void
	*/
	public function delete($id) {
		//TODO 
	}
	
	/**
	 * Get an array of key-value paris of all boards
	 * 
	 * @return Array
	 */
	public function listAll() {
		$boards = $this->model->lists('board_name', 'id');
		return $boards;	
	}
	
	
		
	
} 
