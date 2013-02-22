<?php
/**
 * Underscore.string.php 
 * 
 * Multi-Byte compatible PHP port of underscore.string JS library.
 * 
 * Underscore.string.php is licensed under the MIT license
 * Underscore.string.php was inspired by and borrowed from Underscore.string.js/Underscore.php
 * For docs and downloads, see: http://migg24.github.com/underscore-string-php

 * @version 0.1
 * @author Michael Dreher
 * @copyright Michael Dreher
 */

// Returns an instance of __str for OO-style calls
function __str($item = null) {
    $__str = new __str;
    if (func_num_args() > 0) {
        $__str->_wrapped = $item;
    } 
    return $__str;
}

class __str {
    public function isBlank($str = null) {
        list($str) = self::_wrapArgs(func_get_args(), 1);
        if ($str == null) $str = '';
        return self::_wrap(preg_match('/^\s*$/', $str));
    }

    public function stripTags($str = null, $allowable = null) {
        list($str, $allowable) = self::_wrapArgs(func_get_args(), 2);
        if ($str == null) return self::_wrap('');
        if ($allowable == null) $allowable = '';
        return self::_wrap(strip_tags($str, $allowable));
    }
    
    public function capitalize($str = null) {
        list($str) = self::_wrapArgs(func_get_args(), 1);
        if ($str == null) return self::_wrap('');
        return self::_wrap(ucfirst($str));
    }
    
    public function chop($str = null, $step = null) {
        list($str, $step) = self::_wrapArgs(func_get_args(), 2);
        if ($str == null) return self::_wrap(array());
        if ($step == null || $step < 1) $step = 1;
        $chars = preg_split('/(?<!^)(?!$)/u', $str); // multibyte split
        
        if ($step == 1) {
            return self::_wrap($chars);
        } else {
            $i = 0; $j = 0;
            $result = array();
            while (count($chars) > 0) {
                if ($j++ % $step == 0) $i++;
                $result[$i] .= array_shift($chars);
            }
        }
        return self::_wrap($result);
    }
    
    public function clean($str = null) {
        list($str) = self::_wrapArgs(func_get_args(), 1);
        if ($str == null) return self::_wrap('');
        return self::_wrap(preg_replace('/\s+/', ' ', self::trim($str)));
    }
    
    public function count($str = null, $substr = null) {
        list($str, $substr) = self::_wrapArgs(func_get_args(), 2);
        if ($str == null || $substr == null) return self::_wrap(0);
        return self::_wrap(mb_substr_count($str, $substr));
    }
    
    // chars
    
    // swapCase
    
    // escapeHTML
    
    // unescapeHTML
    
    // escapeRegExp
    
    // splice
    
    // insert
    
    // include
    
    // join
    
    // lines
    
    // reverse
    
    // startsWith
    
    // endsWith
    
    // succ
    
    // titleize
    
    // camelize
    
    // underscored
    
    // dasherize
    
    // classify
    
    // humanize
    
    public function trim($str = null) {
        list($str) = self::_wrapArgs(func_get_args(), 1);
        if ($str == null) return self::_wrap('');
        return self::_wrap(trim($str));
    }

    // ltrim
    
    // rtrim
    
    // truncate
    
    // prune
    
    // words
    
    // pad
    
    // lpad
    
    // rpad
    
    // lrpad
    
    // toNumber
    
    // numberFormat
    
    // ...
    
    // Aliases
    
    
    // Utility Functions taken from underscore.php by Brian Haveri (@brianhaveri)
    
    // Singleton
    private static $_instance;
    public function getInstance() {
        if(!isset(self::$_instance)) {
            $c = __CLASS__;
            self::$_instance = new $c;
        }
        return self::$_instance;
    }

    // All methods should wrap their returns within _wrap
    // because this function understands both OO-style and functional calls
    public $_wrapped; // Value passed from one chained method to the next
    private function _wrap($val) {
        if(isset($this) && isset($this->_chained) && $this->_chained) {
            $this->_wrapped = $val;
            return $this;
        }
        return $val;
    }

    // All methods should get their arguments from _wrapArgs
    // because this function understands both OO-style and functional calls
    private function _wrapArgs($caller_args, $num_args=null) {
        $num_args = (is_null($num_args)) ? count($caller_args) - 1 : $num_args;

        $filled_args = array();
        if(isset($this) && isset($this->_wrapped)) {
            $filled_args[] =& $this->_wrapped;
        }
        if(count($caller_args) > 0) {
            foreach($caller_args as $k=>$v) {
                $filled_args[] = $v;
            }
        }

        return array_pad($filled_args, $num_args, null);
    }

    // Get a collection in a way that supports strings
    private function _collection($collection) {
        return (!is_array($collection) && !is_object($collection)) ? str_split((string) $collection) : $collection;
    }
}