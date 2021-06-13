<?php


namespace App\Http\Controllers\Encryption;


use App\Application\Encryption\Command\StoreSecretDataCommand;
use App\Application\Encryption\StoreSecretDataUseCase;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Encryption\Request\StoreSecretDataRequest;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;


class EncryptionController extends Controller
{
    private StoreSecretDataUseCase $storeSecretData;

    public function __construct(StoreSecretDataUseCase $storeSecretData)
    {
        $this->storeSecretData = $storeSecretData;
    }

    public function findServerKey(Request $request): Response
    {
        $publicKey = env('PUBLIC_KEY');

        return ResponseBuilder::asSuccess()->withData($publicKey)
            ->withHttpCode(200)->build();
    }

    public function storeSecretData(StoreSecretDataRequest $request): Response
    {
        $command = new StoreSecretDataCommand($request->getData());
        $this->storeSecretData->execute($command);

        return ResponseBuilder::asSuccess()
            ->withHttpCode(201)->build();
    }
}
