<?php

namespace App\Helpers;

class EnvironmentVariables
{
    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        if (getenv($key) !== false) {
            return getenv($key);
        }

        return $default;
    }

    /**
     * Recupera todas as variáveis de ambiente.
     *
     * @return array
     */
    public static function all(): array
    {
        return $_ENV;
    }
}