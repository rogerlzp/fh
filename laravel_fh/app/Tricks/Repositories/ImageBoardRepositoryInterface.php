<?php
namespace Tricks\Repositories;


interface ImageBoardRepositoryInterface {

	/**
	 * Create a new image in the database.
	 *
	 * @param  array $data
	 * @return \Tricks\Board
	 */
	public function create(array $data);

	/**
	 * Update the specified image in the database.
	 *
	 * @param  mixed $id
	 * @param  array $data
	 * @return \Tricks\Image
	*/
	public function update($id, array $data);

	/**
	 * Delete the specified Image from the database.
	 *
	 * @param  mixed $id
	 * @return void
	*/
	public function delete($id);





}