<?php


namespace App\Http\Controllers\Encryption;


use App\Application\Encryption\Command\FindServerKeyCommand;
use App\Application\Encryption\Command\StoreSecretDataCommand;
use App\Application\Encryption\FindServerKeyUseCase;
use App\Application\Encryption\StoreSecretDataUseCase;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Encryption\Request\FindServerKeyRequest;
use App\Http\Controllers\Encryption\Request\StoreSecretDataRequest;
use App\Http\Controllers\Encryption\Response\FindServerKeyResponse;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;


class EncryptionController extends Controller
{
    private FindServerKeyUseCase $findServerKey;
    private StoreSecretDataUseCase $storeSecretData;

    public function __construct(FindServerKeyUseCase $findServerKey, StoreSecretDataUseCase $storeSecretData)
    {
        $this->findServerKey = $findServerKey;
        $this->storeSecretData = $storeSecretData;
    }

    public function findServerKey(FindServerKeyRequest $request): Response
    {
        $command = new FindServerKeyCommand($request->getData());
        $publicKey = $this->findServerKey->execute($command);

        $data = FindServerKeyResponse::build($publicKey);

        return ResponseBuilder::asSuccess()->withData($data)
            ->withHttpCode(200)->build();
    }

    public function storeSecretData(StoreSecretDataRequest $request)
    {
        $command = new StoreSecretDataCommand($request->getData());
        $this->storeSecretData->execute($command);
dd($command);
    }
}
