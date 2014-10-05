<?php  namespace Controllers;

use Tricks\Repositories\BoardRepositoryInterface;
use Tricks\Repositories\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Log;


class UserBoardController extends BaseController {
	
	protected $board;
	
	
	public function __construct(BoardRepositoryInterface $board) {
		parent::__construct();
			
		$this->beforeFilter('auth');
		$this->beforeFilter('board.owner', [
				'only' => [ 'getEdit', 'postEdit', 'getDelete' ]
				]);	
		$this->board      = $board;
	}
	
	

	/**
	 * Show the create new board page.
	 *
	 * @return \Response
	 */
	public function getNew()
	{
	//	Log::info('getNew');
		$this->view('board.new');
	}
	
	
	/**
	 * Handle the creation of a new board.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postNew()
	{
		$form = $this->board->getCreationForm();
	
		if (! $form->isValid()) {
			return $this->redirectBack([ 'errors' => $form->getErrors() ]);
		}
	
		$data = $form->getInputData();
		$data['user_id'] = Auth::user()->id;
	
		$board = $this->board->create($data);
	
		return $board;
	}
	
	/**
	 * Get the board list created by current user
	 * 
	 */
	public function getList() {
		$boards = $this->board->findAllForUser();
		Log::info('getList');
		Log::info($boards);
		return $this->view('board.list', ['boardList' => $boards]);
		
	}
	
	/**
	 * Get the board list created by current user
	 *
	 */
	public function getListByUserId() {		
		$boards = $this->board->findAllForUserId(Auth::user()->id);
		Log::info('getListByUserId');
		Log::info($boards);
		return $boards;
	
	}
	
	
}
