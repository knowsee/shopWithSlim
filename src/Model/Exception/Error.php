<?php
declare(strict_types=1);
namespace App\Model\Exception;
use Exception;
class Error {

    const DEFAULT_ERROR = 0;
    const IMPORTANT_ERROR = 1;
    const ARGS_EMPTY = 2;

    public function __construct(int $errorCode, string $message, ?array $args = array()) {
        switch ($errorCode) {
            case self::DEFAULT_ERROR:
                throw new \Exception($message, E_PARSE);
            case self::IMPORTANT_ERROR:
                throw new \Exception($message, E_ERROR);
            case self::ARGS_EMPTY:
                throw new \Exception($message, E_CORE_ERROR);
        }
    }
}