<?php


namespace App\Http\Controllers\Auth;


use App\Application\Auth\Command\RegisterUserCommand;
use App\Application\Auth\RegisterUserUseCase;
use App\Http\Controllers\Auth\Request\RegisterRequest;
use App\Http\Controllers\Auth\Response\RegisterResponse;
use App\Http\Controllers\Controller;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    private RegisterUserUseCase $registerUserUseCase;

    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    public function register(RegisterRequest $request): Response
    {
        $command = new RegisterUserCommand($request->getData());
        $user = $this->registerUserUseCase->execute($command);

        $data = RegisterResponse::build($user);

        return ResponseBuilder::asSuccess()->withData($data)
            ->withHttpCode(200)->build();
    }
}
