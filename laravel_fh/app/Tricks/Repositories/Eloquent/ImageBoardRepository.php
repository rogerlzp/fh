<?php namespace Tricks\Repositories\Eloquent;

use Tricks\Image;
use Tricks\Board;
use Tricks\ImageBoard;
use Tricks\Repositories\ImageBoardRepositoryInterface;
use Tricks\Services\Forms\ImageForm;

class ImageBoardRepository extends AbstractRepository implements ImageBoardRepositoryInterface {
	
	protected $image_board;
	
	public function __construct(ImageBoard $image_board) {
		$this->model = $image_board;
	}
	
	
	/**
	 * Create a new image in the database.
	 *
	 * @param  array $data
	 * @return \Tricks\Board
	 */
	public function create(array $data)
	{
		$image_board = $this->getNew();
	
		$image_board->image_id        = e($data['image_id']);
		$image_board->board_id = $data['board_id'];
		$image_board->user_id     = $data['user_id'];
		$image_board->save();
		
		return $image_board;
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
		
	
} 
