<?php namespace Controllers;

use Tricks\Repositories\BoardRepositoryInterface;


class BoardController extends BaseController {
	
	protected $board;

	
	/**
	 * Create a new BoardController instance.
	 *
	 * @param \Tricks\Repositories\BoardRepositoryInterface  $board
	 * @return void
	 */
	public function __construct(BoardRepositoryInterface $board)
	{
		parent::__construct();
	
		$this->board = $board;
	}
	
	/**
	 * Show the single board page.
	 *
	 * @param  string $id
	 * @return \Response
	 */
	public function getShow($id)
	{
		if (is_null($id)) {
			return $this->redirectRoute('home');
		}
	
		$board = $this->board->findById($id);
	
		if (is_null($board)) {
			return $this->redirectRoute('home');
		}
	
	//	Event::fire('board.view', $board);
	
		$this->view('board.single', compact('board'));
		
	}
	
	
	
	
	
}