<?php
class DBClient {
    private $dbhost = "si4g.c9bvymxyu8bt.eu-west-1.rds.amazonaws.com";
    private $dbuser = "root";
    private $dbpassword = "AW5_RD5_S14G!:;,";
    private $dbname = "ct_website";
    private $connection;
    public function __construct() {
        if ($_SERVER['SERVER_NAME'] == "localhost") {
            $this->dbhost = "centre-terre-database";
            $this->dbuser = "root";
            $this->dbpassword = "root";
        }
    }
	public function open() {
		$this->connection = new mysqli ( $this->dbhost, $this->dbuser, $this->dbpassword, $this->dbname );
		if ($this->connection->connect_error) {
			die ( "Database connection failed : " . $this->connection->connect_error );
		}
	}
	public function query($sql) {
		$this->connection->set_charset ( 'utf8' );
		$result = $this->connection->query ( $sql );
		return $result;
	}
	public function lastInsertId() {
		return $this->connection->insert_id;
	}
	public function escape($var) {
		return $this->connection->real_escape_string($var);
	}
	public function close() {
		$this->connection->close ();
	}
}