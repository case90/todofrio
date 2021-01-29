<?php

error_reporting(E_ALL ^ E_DEPRECATED);
/**
 * Pts Prestashop Theme Framework for Prestashop 1.6.x
 *
 * @package   pspagebuilder
 * @version   5.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
 *               <info@prestabrain.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

class Psrijndael
{
    protected $_key;
    protected $_iv;

    public function __construct($key, $iv)
    {
        $this->_key = $key;
        $this->_iv = self::base64Decode($iv);
    }

    /**
     * Base64 is not required, but it is be more compact than urlencode
     *
     * @param string $plaintext
     * @return bool|string
     */
    public function encrypt($plaintext)
    {

        $length = (ini_get('mbstring.func_overload') & 2) ? mb_strlen($plaintext, ini_get('default_charset')) : Tools::strlen($plaintext);

        if ($length >= 1048576) {
            return false;
        }
        return self::base64Encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->_key, $plaintext, MCRYPT_MODE_ECB, $this->_iv)).sprintf('%06d', $length);
        

        /*$length = (ini_get('mbstring.func_overload') & 2) ? mb_strlen($plaintext, ini_get('default_charset')) : strlen($plaintext);
        if ($length >= 1048576) {
            return false;
        }
        $ciphertext = null;
        if (function_exists('openssl_encrypt') && version_compare(phpversion(), '5.3.3', '>=')) {
            $ciphertext = openssl_encrypt($plaintext, 'AES-128-CBC', $this->_key, OPENSSL_RAW_DATA, $this->_iv);
        } elseif (function_exists('mcrypt_encrypt')) {
            $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->_key, $plaintext, MCRYPT_MODE_CBC, $this->_iv);
        } else {
            throw new RuntimeException('Either Mcrypt or OpenSSL extension is required to run Prestashop');
        }
        return base64_encode($ciphertext) . sprintf('%06d', $length);*/

    }

    public function decrypt($ciphertext)
    {

        
       
        /*$output = null;
        if (ini_get('mbstring.func_overload') & 2) {
            $length = intval(mb_substr($ciphertext, -6, 6, ini_get('default_charset')));
            $ciphertext = mb_substr($ciphertext, 0, -6, ini_get('default_charset'));
            if (function_exists('openssl_decrypt') && version_compare(phpversion(), '5.3.3', '>=')) {
                $output = openssl_decrypt(base64_decode($ciphertext), 'AES-128-CBC', $this->_key, OPENSSL_RAW_DATA, $this->_iv);
            } elseif (function_exists('mcrypt_decrypt')) {
                $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->_key, base64_decode($ciphertext), MCRYPT_MODE_CBC, $this->_iv);
            } else {
                throw new RuntimeException('Either Mcrypt or OpenSSL extension is required to run Prestashop');
            }
            return mb_substr(
                $output,
                0,
                $length,
                ini_get('default_charset')
            );
        } else {
            $length = intval(substr($ciphertext, -6));
            $ciphertext = substr($ciphertext, 0, -6);
            if (function_exists('openssl_decrypt') && version_compare(phpversion(), '5.3.3', '>=')) {
                $output = openssl_decrypt(base64_decode($ciphertext), 'AES-128-CBC', $this->_key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $this->_iv);
            } elseif (function_exists('mcrypt_decrypt')) {
                $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->_key, base64_decode($ciphertext), MCRYPT_MODE_CBC, $this->_iv);
            } else {
                throw new RuntimeException('Either Mcrypt or OpenSSL extension is required to run Prestashop');
            }
            return substr($output, 0, $length);
        }*/


        if (ini_get('mbstring.func_overload') & 2) {
            $length = (int)(mb_substr($ciphertext, -6, 6, ini_get('default_charset')));
            $ciphertext = mb_substr($ciphertext, 0, -6, ini_get('default_charset'));
            return mb_substr(
                mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->_key, self::base64Decode($ciphertext), MCRYPT_MODE_ECB, $this->_iv),
                0,
                $length,
                ini_get('default_charset')
            );
        } else {
            $length = (int)(Tools::substr($ciphertext, -6));
            $ciphertext = Tools::substr($ciphertext, 0, -6);
            return Tools::substr(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->_key, self::base64Decode($ciphertext), MCRYPT_MODE_ECB, $this->_iv), 0, $length);
        }
       
    }

    public static function base64Decode($data)
    {
        return call_user_func('base64_decode', $data);
    }

    public static function base64Encode($data)
    {
        return call_user_func('base64_encode', $data);
    }
}
