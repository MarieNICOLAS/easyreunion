<?php

namespace App\Services;

class PKCEService
{
    public $challengeCode;
    public $verifier;

    function __construct(int $length = 128)
    {
        $chars = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9), ['-', '.', '_', '~']);
        $charsLength = count($chars);

        $verifier = '';

        for ($i = 0; $i < $length; ++$i)
        {
            $index = random_int(0, $charsLength - 1);
            $verifier .= $chars[$index];
        }

        $this->verifier = $verifier;
        $this->challengeCode = $this->generateChallenge($verifier);
    }

    private function generateChallenge(string $verifier): string
    {
        // https://datatracker.ietf.org/doc/html/rfc7636#section-4.2
        $hash = hash('sha256', $verifier, true);

        //  https://datatracker.ietf.org/doc/html/rfc4648#section-5
        return rtrim(strtr(base64_encode($hash), ['+' => '-', '/' => '_']), '=');
    }

    public function verifyChallenge(string $code): bool
    {
        return $code === $this->generateChallenge($this->verifier);
    }
}
