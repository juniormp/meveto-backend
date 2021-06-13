<?php


namespace App\Infrastructure\Service;


use Exception;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;

class CouldNotDecryptDataException extends Exception
{
    public function render(): Response
    {
        return ResponseBuilder::asError(102)
            ->withData([102 => trans('api.could_not_decrypt_data')])
            ->withHttpCode(400)
            ->build();
    }
}
