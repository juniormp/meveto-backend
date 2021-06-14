<?php


namespace App\Exceptions\Controllers;


use Exception;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;

class InvalidSignatureException extends Exception
{
    public function render(): Response
    {
        return ResponseBuilder::asError(103)
            ->withData([103 => trans('api.invalid_signature')])
            ->withHttpCode(400)
            ->build();
    }
}
