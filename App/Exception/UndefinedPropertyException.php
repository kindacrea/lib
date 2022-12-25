<?php
namespace Kcpck\App\Exception;

class undefinedPropertyException extends \Exception
{
    public function __construct(string $property_name, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct('Property "' . $property_name . '" does not exists!', $code, $previous);
    }
}
