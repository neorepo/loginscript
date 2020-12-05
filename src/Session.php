<?php
// https://docs.oracle.com/en/database/oracle/oracle-database/12.2/tdpph/introducing-PHP-with-oracle-database.html#GUID-E422BF2E-17B9-432D-A2A7-89138BAE5B7A
class Session {

    public $username = null;
    public $csrftoken = null;

    public function isPrivilegedUser() {
        return ($this->username === 'ADMIN');
    }

    public function setSession() {
        $_SESSION['username'] = $this->username;
        $_SESSION['csrftoken'] = $this->csrftoken;
    }

    public function getSession() {
        $this->username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
        $this->csrftoken = isset($_SESSION['csrftoken']) ? $_SESSION['csrftoken'] : null;
    }

    /**
     * Logout the current user
     */
    public function clearSession() {
        $_SESSION = array();
        $this->username = null;
        $this->csrftoken = null;
    }

    public function setCsrfToken() {
        $this->csrftoken = self::generate();
        $this->setSession();
    }

    private static function generate($length = 32) {
        if (!isset($length) || intval($length) <= 8) {
            $length = 32;
        }
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
        if (function_exists('mcrypt_create_iv')) {
            return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
        }
        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length));
        }
    }

    public static function validate($token) {
        if ( !isset($token) || !hash_equals($_SESSION['csrftoken'], $token) ) {
            return false;
        }
        return true;
    }
}