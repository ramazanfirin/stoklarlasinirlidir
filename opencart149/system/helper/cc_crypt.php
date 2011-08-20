<?php
class cc_crypt_mod
{

    private $gz_type = 'gzdeflate';
    var $uncomp = 'gzinflate';
    var $level_compression = 9;

    function Encode($string,  $key)
    {
        $result = '';
        $string = $this->clean_string($string);
        for($i = 0; $i < strlen($string); $i++) {
            $char = substr($string,  $i,  1);
            $keychar = substr($key,  ($i % strlen($key))-1,  1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
        $result = $this->compress($result,  $this->gz_type,  $this->level_compression);
        return base64_encode($result);
    }
    function Decode($string,  $key)
    {
        $uncomp = &$this->uncomp;
        $result = '';
        $string = base64_decode($string);
        $string = $uncomp($string);
        for($i = 0; $i < strlen($string); $i++) {
            $char = substr($string,  $i,  1);
            $keychar = substr($key,  ($i % strlen($key))-1,  1);
            $char = chr(ord($char) - ord($keychar));
            $result .= $char;
        }
        return $result;
    }

    function randomstring()
    {
        return mt_rand(99999999,  9999999999);
    }

    function clean_string($str)
    {
        $str = stripslashes(trim($str));
        return $str;
    }
    function compress($string,  $type,  $level)
    {
        $uncomp = &$this->uncomp;
        switch ($type) {
            case 'gzdeflate':
                $string = gzdeflate($string,  $level);
                $uncomp = 'gzinflate';
                $uncompress = base64_encode('gzinflate');
                return $string;
                break;

            case 'gzcompress':
                $string = gzcompress($string,  $level);
                $uncomp = 'gzuncompress';
                $uncompress = base64_encode('gzuncompress');
                return $string;
                break;
        }
        return $string;
    }
}
?>