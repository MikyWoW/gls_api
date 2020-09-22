<?php declare(strict_types=1);

namespace GLS;

class Request
{
    /**
     * User name (email address)
     */
    public string $Username;

    /**
     * Password SHA512 array byte
     */
    public array $Password;
}