<?php 

namespace PPSystem\SEParserBundle\Whois;

class WhoisException extends Exception
{
    public function __construct()
    {
        $arg_count = func_num_args();
        $arguments = func_get_args();

        switch ($arg_count)
        {
            case 0:
                $message = 'Undefined';
                break;
            case 1:
                $message = $arguments[0];
                break;
            default:
                $format = array_shift($arguments);
                $message = vsprintf($format, $arguments);
        }

        parent::__construct($message, 0, null);
    }
}
    