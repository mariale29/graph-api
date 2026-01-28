<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 * title="Graph API en Laravel",
 * version="1.0.0",
 * description="Documentación de los endpoints de Node"
 * )
 * * @OA\Server(url="http://localhost:8000")
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
