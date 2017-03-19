<?php
    namespace Engine\baseModel;

    use Engine\traits\Singleton;
    use PDO;

    class getConnection
    {
        use Singleton;

        /**
         * @return PDO
         */
        public function Connect ()
        {
            $config = config()->get("app.db");
            $user = $config['user'];
            $host = $config['host'];
            $password = $config['password'];
            $dbname = $config['dbname'];
            return new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        }
    }