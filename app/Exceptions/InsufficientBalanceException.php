<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InsufficientBalanceException extends Exception
{
    protected $code = 400;

    public function render($request): JsonResponse
    {
        return response()->json(['error' => $this->getMessage()], $this->getCode());
    }
}
