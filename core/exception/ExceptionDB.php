<?php
    namespace Engine\exception;

    use Engine\traits\TException;
    use Exception;

    class ExceptionDB extends Exception
    {
        use TException;
        public function __construct($error)
        {
            $this->writeToFile(
                "Error message {$error}\n".
                "on lines {$this->getLine()} error in {$this->getFile()}\n".
                "with {$this->getTraceAsString()}\n\n"
            );
            die();
        }
    }