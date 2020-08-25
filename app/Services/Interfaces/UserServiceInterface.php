<?php
namespace App\Services\Interfaces;

interface UserServiceInterface 
{
	public function listUser($request, $perPage);
	public function find($id);
	public function update($request, $id);
	public function insert($request);
	public function delete($id);
	public function upload($request);
	public function genders();
	public function departments();
}