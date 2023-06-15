<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class Tools
{

    public function parse_file($file, $path, $ext = "png", $file_old = "")
    {
        // if (strpos($file, "base64") === false) {
        //     return $file_old;
        // }
        if (!empty($file_old) && Storage::disk('public')->exists($file_old)) { //deleta file old
            $this->_deletePhotoIfExists($file_old);
        }

        $file = preg_replace('#^data:image/[^;]+;base64,#', '', $file);
        $content = base64_decode($file);
        // $file = fopen('php://temp', 'r+');
        // fwrite($file, $content);
        $file_name = md5(
            uniqid(
                microtime(),
                true
            )
        ) .'.'. $ext;

        $pathSave = "{$path}/{$file_name}";
        Storage::disk('public')->put($pathSave, $content);

        return $pathSave;
    }

    public function getExtensionFileName($img)
    {
        $extension = explode("/", $img);
        $ext = explode(";", $extension[1]);
        return $ext[0];
    }

    public function _deletePhotoIfExists($file_path): void
    {
        Storage::disk('public')->delete($file_path);
    }

    public function putFile($file, $path)
    {
        return Storage::disk('public')->put($path, $file);
    }

    public function getUrlFile($path)
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }
        return null;
    }

    public function soNumero($str)
    {
        return preg_replace("/[^0-9]/", "", $str);
    }
}
