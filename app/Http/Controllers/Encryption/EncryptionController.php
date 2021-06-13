<?php


namespace App\Http\Controllers\Encryption;


use App\Application\Encryption\Command\FindSecretCommand;
use App\Application\Encryption\Command\StoreSecretDataCommand;
use App\Application\Encryption\FindSecretUseCase;
use App\Application\Encryption\StoreSecretDataUseCase;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Encryption\Request\FindSecretRequest;
use App\Http\Controllers\Encryption\Request\StoreSecretDataRequest;
use App\Http\Controllers\Encryption\Response\FindSecretResponse;
use App\Http\Controllers\Encryption\Response\FindServerKeyResponse;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;


class EncryptionController extends Controller
{
    private StoreSecretDataUseCase $storeSecretData;
    private FindSecretUseCase $findSecret;

    public function __construct(StoreSecretDataUseCase $storeSecretData, FindSecretUseCase $findSecret)
    {
        $this->storeSecretData = $storeSecretData;
        $this->findSecret = $findSecret;
    }

    public function findServerKey(Request $request): Response
    {
        $publicKey = env('PUBLIC_KEY');

        return ResponseBuilder::asSuccess()->withData(FindServerKeyResponse::build($publicKey))
            ->withHttpCode(200)->build();
    }

    public function storeSecretData(StoreSecretDataRequest $request): Response
    {
        $command = new StoreSecretDataCommand($request->getData());
        $this->storeSecretData->execute($command);

        return ResponseBuilder::asSuccess()
            ->withHttpCode(201)->build();
    }

    public function findSecret(FindSecretRequest $request): Response
    {
        $command = new FindSecretCommand($request->getData());
        $encryptedSecret = $this->findSecret->execute($command);

        return ResponseBuilder::asSuccess()->withData(FindSecretResponse::build($encryptedSecret))
            ->withHttpCode(201)->build();
    }
}
