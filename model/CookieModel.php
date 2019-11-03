<?php

namespace Model;

class CookieModel {
    
    public function createCookie($name, $value) {
        $time = time() + 3600; // one hour
        setcookie($name, $value, $time);
    }

    public function removeCookie($name) {
        setcookie($name, null, time() - 3600);
    }
    
    public function cookieExists($name) : bool {
        return isset($_COOKIE[$name]);
    }
    
    public function getCookie($name) : String {
        return cookieExists($name) ? $_COOKIE[$name] : '';
    } 
}

