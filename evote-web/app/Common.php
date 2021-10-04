<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */

if (!function_exists('gdupload')) {
	function gdupload($files, $name)
	{
		putenv('GOOGLE_APPLICATION_CREDENTIALS=' . FCPATH ."../". getenv("GOOGLE_DRIVE_CREDENTIAL"));
		$client = new Google_Client();
		$client->useApplicationDefaultCredentials();
		$client->addScope("https://www.googleapis.com/auth/drive");
		$service = new Google_Service_Drive($client);
		$file = new Google_Service_Drive_DriveFile();
		try {
			$file->setName($name);
			$file->setMimeType("image/jpeg");
			$file->setParents([getenv("GOOGLE_DRIVE_FOLDER_ID")]);#folder id
			$createdFile = $service->files->create($file, [
				'data' => file_get_contents($files),
				'mimeType' => 'application/octet-stream',
				'uploadType' => 'multipart'
			]);
			if ($createdFile)
				return $createdFile->getId();
		} catch (\Throwable $th) {
			echo $th;
		}
	}
}
if (!function_exists('gddelete')) {
	function gddelete($id)
	{
		putenv('GOOGLE_APPLICATION_CREDENTIALS=' . FCPATH ."../". getenv("GOOGLE_DRIVE_CREDENTIAL"));
		$client = new Google_Client();
		$client = new Google_Client();
		$client->useApplicationDefaultCredentials();
		$client->addScope("https://www.googleapis.com/auth/drive");
		$service = new Google_Service_Drive($client);
		try {
			if ($service->files->delete($id))
				return true;
		} catch (\Throwable $th) {
			return false;
		}
	}
}

if (!function_exists('is_image')) {
	function is_image($file)
	{
        if(exif_imagetype($file)>0){
            return true;
        }
        return false;
	}
}