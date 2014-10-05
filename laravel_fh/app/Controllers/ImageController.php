<?php namespace Controllers;

use ImageUpload;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


use Illuminate\Support\Facades\Auth;
use Tricks\Repositories\TrickRepositoryInterface;
use Tricks\Repositories\UserRepositoryInterface;
use Tricks\Repositories\BoardRepositoryInterface;
use Tricks\Repositories\ImageRepositoryInterface;

class ImageController extends BaseController {

	protected $board;
	protected $image;
	
	public function __construct(BoardRepositoryInterface $board, ImageRepositoryInterface $image) {
		parent::__construct();
		Log::info('__construct');
		$this->board      = $board;
		$this->image      = $image;
	}

	public function getUploadForm() {
		return  $this->view('image.new');
	}
	public function postUpload() {

		Log::info('postUpload');
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			ImageUpload::enableCORS($_SERVER['HTTP_ORIGIN']);
		}

		if (Request::server('REQUEST_METHOD') == 'OPTIONS') {
			exit;
		}

		$json = ImageUpload::handleImage(Input::file('filedata'));

		if ($json !== false) {
			return Response::json($json, 200);
		}

		return Response::json('error', 400);




	}

	/**
	 * list the most popular images when the use is not logged
	 */
	
	public function getIndex() {
		$images = $this->image->findAll(10);
		
		Log::info("getIndex");
		Log::info($images);

	
		
		return  $this->view('image.all', compact('images'));
	}
	
	/**
	 * list the most popular images when the use is not logged
	 */
	
	public function getSingle($id) {

		$image = $this->image->findById($id);
		$comments = $image->comments;
		Log::info('getSingle comments: '.$comments);
		
		return  $this->view('image.single_show', compact('image', 'comments'));
	}
	

	
	

}
