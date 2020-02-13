<?php

namespace App\Http\Controllers;

use App\Traits\CreateThumbnailTrait;

class UserController extends Controller
{
    use CreateThumbnailTrait;

    public function create()
    {
        return $this->createThumb(45, 45);
    }
}
