<?php

namespace App\Services;

use Exception;
use http\Client\Request;

class ImageService
{
    /**
     * @throws Exception
     */
    public function store($request, $path = 'images'): string
    {
        $image = $request->file('image_url');

        $imageName = time() . '.' . $image->extension();

        $image->storeAs($path, $imageName);

        return $path . '/' . $imageName;
    }

}
