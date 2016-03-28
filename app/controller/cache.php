<?php

class Cache {
    private $key = '';

    function __construct($key) {
        $this->key = $key;
    }

    function has() {
        if($this->isApcEnabled()){
            // APC available
            return apc_exists($this->key);
        } else {
            return false;
        }
    }

    function set($value, $ttl) {
        if($this->isApcEnabled()){
            apc_store($this->key, $value, $ttl);
        }
    }

    function get() {
        if($this->isApcEnabled()){
            return apc_fetch($this->key);
        }
    }

    private function isApcEnabled() {
        return (extension_loaded('apc') && ini_get('apc.enabled'));
    }
}
