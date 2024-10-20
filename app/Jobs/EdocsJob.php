<?php

namespace App\Jobs;

use App\Interfaces\EdocsInterface;

class EdocsJob implements EdocsInterface
{
    /**
     * Execute the job.
     *
     * @return mixed
     */
    public function uploadFile($txt_docu_reference,$id) // $request->txt_docu_reference
    {
        return 'true';
        if(isset($txt_docu_reference) ){
        $oldPath= 'public/edocs/'.$id;
        $newFolderPath= 'public/edocs/'.$id.'_'.time();
        if (Storage::exists($oldPath)) {
            Storage::move($oldPath, $newFolderPath); //change file name if exist
        }
        $arr_original_filename = [];
        $arr_filtered_filename = [];
        if ( $txt_docu_reference) { // $request->hasfile('txt_docu_reference')
            foreach ($txt_docu_reference as $key => $file) { //$request->file('txt_docu_reference')
                $original_filename = $file->getClientOriginalName(); //'/etc#hosts/@Álix Ãxel likes - beer?!.pdf';
                $filtered_filename = $key.'_'.$this->Slug($original_filename, '_', '.');	 // _etc_hosts_alix_axel_likes_beer.pdf //Interface

                // $file->storeAs($folderPath, $filtered_filename, 'public'); // 'storage' disk is used for storing files
                Storage::putFileAs($oldPath, $file, $filtered_filename);//change file to storage
                $arr_original_filename[] =$original_filename;
                $arr_filtered_filename[] =$filtered_filename;
            }
            // APilotRun::where('id', $id)
            // ->update([
            //     'filename' => implode(' | ',$arr_original_filename),
            //     'filtered_filename' => implode(' | ',$arr_filtered_filename)
            // ]);
        }
        }
    }
    public function slug($string, $slug, $extra)
	{
		return strtolower(trim(preg_replace('~[^0-9a-z' . preg_quote($extra, '~') . ']+~i', $slug, $this->Unaccent($string)), $slug));
    }

	public function unaccent($string) // normalizes (romanization) accented chars
	{
		if (strpos($string = htmlentities($string, ENT_QUOTES, 'UTF-8'), '&') !== false)
		{
			$string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $string), ENT_QUOTES, 'UTF-8');
		}
		return $string;
	}
}
