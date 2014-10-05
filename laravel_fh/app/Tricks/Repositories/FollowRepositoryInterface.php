<?php
namespace Tricks\Repositories;


interface FollowRepositoryInterface {

	/**
	 * Create a new like in the database.
	 *
	 * @param  array $data
	 * @return \Tricks\Board
	 */
	public function create(array $data);


	/**
	 * Delete the like from the database.
	 *
	 * @param  mixed $id
	 * @return void
	*/
	public function delete($id);





}