<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Image;

trait CreateThumbnailTrait
{
    /** 
     * @param int $width
     * @param int $height
     * @return string|null
     */
    public function createThumb($width = 45, $height = 45)
    {        
        /** @var int $width */
        $width = $width ?? 45;
        
        /** @var int $height */
        $height = $height ?? 45;
        
        /** @var string $fileNameWithExtension */
        $fileNameWithExtension = "piperun.png";
        
        /** @var string $contents */
        $contents = Storage::disk('local')->get('public/'.$fileNameWithExtension);
        
        /** @var array $fileInfo */
        $fileInfo = pathinfo($fileNameWithExtension);
        
        /** @var string $fileName */
        $fileName = $fileInfo['filename'];
        
        /** @var string $fileExtension */
        $fileExtension = $fileInfo['extension'];
        
        /** @var string $thumbnail */
        $thumbnail = $fileName."_{$width}x{$height}_".time().'.'.$fileExtension;
        
        // Put file on local folder
        Storage::disk('local')->put('public/profile_images/thumbnail/'.$thumbnail, $contents);
        
        /** @var string $thumbnailPath */
        $thumbnailPath = Storage::url('profile_images/thumbnail/'.$thumbnail);
        
        /** @var Image $image */
        $image = $this->createThumbnail($thumbnailPath, $width, $height);
        
        return $image->filename ?? null;
    }

    /**
    * Create a thumbnail of specified size
    * 
    * @param string $path
    * @param int $width
    * @param int $height
    * @return Image
    */
    public function createThumbnail($path, $width, $height)
    {
        /** @var string $path */
        $path = public_path($path);
        
        /** @var Image $img */
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        
        return $img->save($path);
    }
}