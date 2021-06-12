<?php


namespace App\Http\Controllers;


use App\Domain\Auth\User;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use phpseclib3\Crypt\RSA;

class TestController extends Controller
{

    public function foo(Request $request)
    {
        dd(User::first()->key);
    }

}
