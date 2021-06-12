<?php


namespace App\Http\Controllers\Encryption;


use App\Application\Encryption\Command\FindServerKeyCommand;
use App\Application\Encryption\FindServerKeyUseCase;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Encryption\Request\FindServerKeyRequest;
use App\Http\Controllers\Encryption\Response\FindServerKeyResponse;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;


class EncryptionController extends Controller
{
    private FindServerKeyUseCase $findServerKey;

    public function __construct(FindServerKeyUseCase $findServerKey)
    {
        $this->findServerKey = $findServerKey;
    }

    public function findServerKey(FindServerKeyRequest $request): Response
    {
        $command = new FindServerKeyCommand($request->getData());
        $publicKey = $this->findServerKey->execute($command);

        $data = FindServerKeyResponse::build($publicKey);

        return ResponseBuilder::asSuccess()->withData($data)
            ->withHttpCode(200)->build();
    }
}
