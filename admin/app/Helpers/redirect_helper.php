<?php

class RedirectHelper {
    public static function redirect($path, $message = null) {
        if ($message) {
            $_SESSION['message'] = $message;
        }
        header("Location: $path");
        exit;
    }
}
