<?php
namespace App\Services\Interfaces;

interface UserServiceInterface 
{
	public function listUser($request, $perPage);
	public function find($id);
}