<?php  namespace Controllers;

use Tricks\Repositories\ImageRepositoryInterface;
use Tricks\Repositories\ImageBoardRepositoryInterface;
use Tricks\Repositories\CategoryRepositoryInterface;
use Tricks\Repositories\BoardRepositoryInterface;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;


class UserImageController extends BaseController {
	
	protected $image;
	protected $board;
	protected $image_board;
	
	public function __construct(ImageRepositoryInterface $image, BoardRepositoryInterface $board, ImageBoardRepositoryInterface  $image_board) {
		parent::__construct();
			
		$this->beforeFilter('auth');
		$this->beforeFilter('image.owner', [
				'only' => [ 'getEdit', 'postEdit', 'getDelete' ]
				]);	
		$this->image      = $image;
		$this->board      = $board;
		$this->image_board      = $image_board;
	}
	
	

	/**
	 * Show the create new board page.
	 *
	 * @return \Response
	 */
	public function getNewLocal()
	{
	//	Log::info('getNew');
		$user = Auth::user();
		$boardList = $this->board->findAllForUser($user);
		
		$this->view('image.new', compact('boardList'));
	}
	
	
	/**
	 * Handle the creation of a new board.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postNewLocal()
	{
		Log::info('postNewLocal');
		$form = $this->image->getCreationForm();
	
		if (! $form->isValid()) {
			return $this->redirectBack([ 'errors' => $form->getErrors() ]);
		}
	
		$data = $form->getInputData();
		$data['user_id'] = Auth::user()->id;
		
		$image = $this->image->create($data);
		
		$image_board_data = [];
		$image_board_data['user_id']  = Auth::user()->id;
		$image_board_data['board_id'] = $data['boards'];
		$image_board_data['image_id'] = $image->id;
		$this->image_board->create($image_board_data);
		
		return $this->redirectRoute('user.image');
	}
	
	
	
	/**
	 * Show the create new board page.
	 *
	 * @return \Response
	 */
	public function getNewNet()
	{
		//	Log::info('getNew');
		$user = Auth::user();
	
		Log::info('username ='.$user->username);
		$boardList = $this->board->findAllForUser($user);
		$this->view('image.new_net', compact('boardList'));
	}
	
	
	/**
	 * Handle the creation of a new board.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postNewNet()
	{
		Log::info('postNewNet');
		$form = $this->image->getCreationForm();
	
		if (! $form->isValid()) {
			return $this->redirectBack([ 'errors' => $form->getErrors() ]);
		}
	
		$data = $form->getInputData();
		$data['user_id'] = Auth::user()->id;
		$image = file_get_contents($data['image_path']);
		$image_path =  Auth::user()->id.'_'.rand().".jpg";
		file_put_contents(public_path().'/img/temp/'.$image_path, $image); //Where to save the image on your server
		
		$data['image_type'] = 2 ;
		$data['image_path'] = $image_path ;
		
		Log::info($data['image_path']);
	
		$image = $this->image->create($data);
	
		$image_board_data = [];
		$image_board_data['user_id']  = Auth::user()->id;
		$image_board_data['board_id'] = $data['boards'][0];
		$image_board_data['image_id'] = $image->id;
		$this->image_board->create($image_board_data);
	
		return $this->redirectRoute('user.image');
	}
	
	
	/**
	 * pin an image to a board
	 * 
	 */
	public function postPin()
	{
	
		
		Log::info("postPin");
		Log::info(Input::all());
		$image_board_data = [];
		$image_board_data['user_id']  = Auth::user()->id;
		$image_board_data['board_id'] = Input::get('board_id');
		$image_board_data['image_id'] =  Input::get('image_id');
		$this->image_board->create($image_board_data);
	
		return $this->redirectRoute('image.single', '4' );
	}
	
}
