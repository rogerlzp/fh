<?php 
namespace Tricks\Repositories;


interface BoardRepositoryInterface {
	
	/**
	 * Create a new board in the database.
	 *
	 * @param  array $data
	 * @return \Tricks\Board
	 */
	public function create(array $data);
	
	/**
	 * Update the specified board in the database.
	 *
	 * @param  mixed $id
	 * @param  array $data
	 * @return \Tricks\Board
	*/
	public function update($id, array $data);
	
	/**
	 * Delete the specified Board from the database.
	 *
	 * @param  mixed $id
	 * @return void
	*/
	public function delete($id);
	
	/**
	 * Get an array of key-value (id => name) pairs of all boards.
	 *
	 * @return array
	 */
	public function listAll();
	
	/**
	 * Find all boards.
	 *
	 * @param  string $orderColumn
	 * @param  string $orderDir
	 * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Board[]
	*/
	// public function findAll($orderColumn = 'created_at', $orderDir = 'desc');
	
	
	/**
	 * Find a board by id.
	 *
	 * @param  mixed $id
	 * @return \Tricks\Board
	 */
	//public function findById($id);
	
	
	
}