<?php

namespace App\Jobs;

use App\Interfaces\FileInterface;
use App\Interfaces\EdocsInterface;
use Illuminate\Support\Facades\Storage;

class EdocsJob implements EdocsInterface
{
    protected $fileInterface;
    /**
     * Construct the job.
     * @return mixed
     * @return array
     */
    public function __construct(FileInterface $fileInterface) {
        $this->fileInterface = $fileInterface;
    }
    /**
     * Execute the job.
     * @return array
     * @param mixed $txt_docu_reference
     * @param mixed $id
     */
    public function uploadFile($txt_docu_reference,$id) // $request->txt_docu_reference
    {
        $currentPath= 'public/edocs/'.$id;
        $newFolderPath= 'public/edocs/'.$id.'_'.time();
        if (Storage::exists($currentPath)) {
            Storage::move($currentPath, $newFolderPath); //change file name if exist
        }
        $arr_filtered_filename = [];
        $arr_original_filename = [];
        foreach ($txt_docu_reference as $key => $file) { //$request->file('txt_docu_reference')
            $original_filename = $file->getClientOriginalName(); //'/etc#hosts/@Álix Ãxel likes - beer?!.pdf';
            $filtered_filename = $key.'_'.$this->fileInterface->Slug($original_filename, '_', '.');	 // _etc_hosts_alix_axel_likes_beer.pdf //Interface

            // $file->storeAs($folderPath, $filtered_filename, 'public'); // 'storage' disk is used for storing files // not active
            Storage::putFileAs($currentPath, $file, $filtered_filename);//change file to storage //active
            $arr_original_filename[] =$original_filename;
            $arr_filtered_filename[] =$filtered_filename;
        }
        return [
            'filtered_document_name' => $filtered_filename
        ];
    }
    // public function slug($string, $slug, $extra)
	// {
	// 	return strtolower(trim(preg_replace('~[^0-9a-z' . preg_quote($extra, '~') . ']+~i', $slug, $this->Unaccent($string)), $slug));
    // }

	// public function unaccent($string) // normalizes (romanization) accented chars
	// {
	// 	if (strpos($string = htmlentities($string, ENT_QUOTES, 'UTF-8'), '&') !== false)
	// 	{
	// 		$string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $string), ENT_QUOTES, 'UTF-8');
	// 	}
	// 	return $string;
	// }
}
