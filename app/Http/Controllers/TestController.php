<?php


namespace App\Http\Controllers;


use App\Domain\Auth\User;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\RSA;
use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;

class TestController extends Controller
{

    public function foo(Request $request)
    {
       // $this->encryptWithServerKey();
        $this->createKey();
        $this->test();
    }

    public function encryptWithServerKey()
    {
        $publicKey = PublicKey::fromString(env('PUBLIC_KEY'));
        $encrypt = base64_encode($publicKey->encrypt('123'));
        dd($encrypt);
    }

    public function createKey()
    {
        [$privateKey, $publicKey] = (new KeyPair())->generate();
        dd($privateKey, $publicKey);
    }

    public function test()
    {
        $privateKey = PrivateKey::fromString('-----BEGIN PRIVATE KEY-----
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
2nAWRgzYFMBDaC1t/r6dS4u/6x3M
-----END PRIVATE KEY-----');

        $encryptedData = base64_encode($privateKey->encrypt('123'));
dd($encryptedData);
        $publicKey = PublicKey::fromString('-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAlRyXDeZ5a/ntw0oAGsy1
vLODQsqBsoLjYi9ydLwpTb0z93FExM6HDlgQSJCLyqEYe9yfmZF7Eet5ucVAU4HF
DIW9+Y5Cknw2mBlfQzCR8tFNhntNd0okj94S//0nHqnG/LziIBAHty5Drto+vYNO
MXUU4NtBgEr3N1vnK/uk5Q+MN3/AzxfbQebNw6mW7QmA9tL7oQYjkUKV95VhJ6WI
sFHCF3AwI18O9rvzKCEP0xzQXK1tBPiCBOuVz+2IInS4erECZhePMAPPEPEH+ELs
vm72m/uJCBWAFtNbMb/lWgfehMvikRvEZJxx5cMX6t8jI++MfSKhkSBRAP/owuzL
g1gdp/4MsA43RdjjkNu2WEdEKin0517rheaGbvRbqhOA6C82Due/CwhNBEZN8AX6
0vmyJA7ybX4n+EG0M9+c5wWI3RD7SCjNyQ73YEIK45GJ7R6uJCb6uJkvK6AFuqTt
E60jMDrArOI30SZT7XtJQdw+7RyEX/NTFV/ySjTNAnrRSj+F6PTQiZLxvT9g5bJD
3bf8fcP69vCoSHhyuMWSTT6WD8LtC8/ejrarq5+YqzYInplR9wthiJ1xwXN6Mse+
wHJsQS8g5AI5iMtX7bQ7U75aNbX6+HfvSabuO6njtw2tlBxOFLwhU+qGiQX0ZEdw
2VsMmtQ+YE1zCgLh8WdA0WECAwEAAQ==
-----END PUBLIC KEY-----');


        $text = $publicKey->decrypt($encryptedData);

        dd($text);




        dd($privateKey->decrypt(base64_decode($text)));


    }

}
