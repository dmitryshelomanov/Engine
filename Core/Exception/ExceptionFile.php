<?php
    namespace Engine\exception;

    use Engine\traits\TException;
    use Exception;

    class ExceptionFile extends Exception
    {
        use TException;
        public function __construct($msg)
        {
            $this->writeToFile(
                "Error message {$msg}\n".
                "on lines {$this->getLine()} error in {$this->getFile()}\n".
                "with {$this->getTraceAsString()}\n\n"
            );
            die();
        }
    }