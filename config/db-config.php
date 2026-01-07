<?php
// config/db-config.php - UNIVERSAL DATABASE CONFIG

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!class_exists('Database')) {
    class Database {
        // Singleton instance
        private static $instance = null;
        
        // Database credentials
        private $host = "localhost";
        private $username = "root";
        private $password = "";
        private $database = "db_ecom";
        
        // Connection object
        protected $conn;

        /**
         * Constructor - bisa dipanggil langsung atau via getInstance()
         */
        public function __construct() {
            $this->conn = new mysqli(
                $this->host, 
                $this->username, 
                $this->password, 
                $this->database
            );
            
            if ($this->conn->connect_error) {
                die("Connection Failed: " . $this->conn->connect_error);
            }
            
            $this->conn->set_charset("utf8mb4");
        }

        /**
         * Get singleton instance (untuk admin)
         * @return Database
         */
        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Get database connection
         * @return mysqli
         */
        public function getConnection() {
            return $this->conn;
        }

        /**
         * Execute query
         */
        public function query($sql) {
            return mysqli_query($this->conn, $sql);
        }

        /**
         * Escape string
         */
        public function escape($value) {
            return mysqli_real_escape_string($this->conn, $value);
        }

        /**
         * Get affected rows
         */
        public function affectedRows() {
            return mysqli_affected_rows($this->conn);
        }

        /**
         * Get last insert ID
         */
        public function insertId() {
            return mysqli_insert_id($this->conn);
        }
    }
}

// ========================================
// BACKWARD COMPATIBILITY
// Untuk kode lama yang pakai $con global
// ========================================

if (!isset($GLOBALS['db_instance'])) {
    $GLOBALS['db_instance'] = Database::getInstance();
}

$con = $GLOBALS['db_instance']->getConnection();
$GLOBALS['con'] = $con;
?>