<?php

if (!function_exists('deleteImageExists')) {	
	function deleteImageExists($img) {
		if (\File::exists($img)) {
		    \File::delete($img);
		}
	}
}

if (!function_exists('uploadImage')) {
	function uploadImage($file, $id) {
        $name = $id.'.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];

        \Image::make($file)->save(public_path('image/').$name);

        return $name;
	}
}