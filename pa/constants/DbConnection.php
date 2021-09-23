<?php
/**
 * Database connection class.
 */
class DBConnection
{
    private $con;

    public function __construct()
    {
    }

    public function connect()
    {
        require_once dirname(__FILE__).'/Constants.php';
        $this->con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$this->con) {
            echo 'Failed to connect to database'.mysqli_connect_errno();
        }

        return $this->con;
    }
}
