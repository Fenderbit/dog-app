<?php

namespace App\Services;

use App\Http\Requests\DogRequest;
use Exception;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * @throws Exception
     */
    public function store(DogRequest $request, $path = 'images'): string
    {
        $image = $request->file('image_url');

        $imageName = time() . '.' . $image->extension();

        $image->storeAs('public/' . $path, $imageName);

        return 'storage/public/' . $path . '/' . $imageName;
    }

}
