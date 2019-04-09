<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UUID
 *
 * @author Marcin
 */
class UUID {
  /**
   * Generates version 1: MAC address
   */
  public static function v1() {
    if (!function_exists('uuid_create'))
      return false;

    uuid_create($context);
    uuid_make($context, UUID_MAKE_V1);
    uuid_export($context, UUID_FMT_STR, $uuid);
    return trim($uuid);
  }

  /**
   * Generates version 3 UUID: MD5 hash of URL
   */
  public static function v3($i_url) {
    if (!function_exists('uuid_create'))
      return false;

    if (!strlen($i_url))
      $i_url = self::v1();

    uuid_create($context);
    uuid_create($namespace);

    uuid_make($context, UUID_MAKE_V3, $namespace, $i_url);
    uuid_export($context, UUID_FMT_STR, $uuid);
    return trim($uuid);
  }

  /**
   * Generates version 4 UUID: random
   */
  public static function v4() {
    if (!function_exists('uuid_create'))
      return false;

    uuid_create($context);

    uuid_make($context, UUID_MAKE_V4);
    uuid_export($context, UUID_FMT_STR, $uuid);
    return trim($uuid);
  }

  /**
   * Generates version 5 UUID: SHA-1 hash of URL
   */
  public static function v5($i_url) {
    if (!function_exists('uuid_create'))
      return false;

    if (!strlen($i_url))
      $i_url = self::v1();

    uuid_create($context);
    uuid_create($namespace);

    uuid_make($context, UUID_MAKE_V5, $namespace, $i_url);
    uuid_export($context, UUID_FMT_STR, $uuid);
    return trim($uuid);
  }
  

public static function generate_uuid($version = 4, $namespace = NULL, $name = NULL){
    switch ( intval($version) ){
        case 1:{
            $time = microtime(true) * 10000000 + 0x01b21dd213814000;
            $time = sprintf("%F", $time);
            preg_match("/^\d+/", $time, $time);
            $time = base_convert($time[0], 10, 16);
            $time = pack("H*", str_pad($time, 16, "0", STR_PAD_LEFT));
            $uuid = $time[4] . $time[5] . $time[6] . $time[7] . $time[2] . $time[3] . $time[0] . $time[1];
            $rand = "";
            for ( $i = 0 ; $i < 2 ; $i++ ) {
                $rand .= chr(mt_rand(0, 255));
            }
            $uuid = $uuid . $rand;
            $uuid[8] = chr(ord($uuid[8]) & 63 | 128);
            $uuid[6] = chr(ord($uuid[6]) & 15 | 16);
            if ( !function_exists('exec') ){
                $rand = "";
                for ( $i = 0 ; $i < 6 ; $i++ ) {
                    $rand .= chr(mt_rand(0, 255));
                }
                $rand = pack("C", ord($rand) | 1);
                $uuid = $uuid . $rand;
            }else{
                exec('/sbin/ifconfig | grep HWadd', $output);
                $output = isset($output[0]) ? $output[0] : NULL;
                if ( empty($output) ){
                    $rand = "";
                    for ( $i = 0 ; $i < 6 ; $i++ ) {
                        $rand .= chr(mt_rand(0, 255));
                    }
                    $rand = pack("C", ord($rand) | 1);
                    $uuid = $uuid . $rand;
                }else{
                    preg_match("/([0-9A-F]{2}[:-]){5}([0-9A-F]{2})/i", $output, $output);
                    $output = isset($output[0]) ? $output[0] : NULL;
                    if ( empty($output) ){
                        $rand = "";
                        for ( $i = 0 ; $i < 6 ; $i++ ) {
                            $rand .= chr(mt_rand(0, 255));
                        }
                        $rand = pack("C", ord($rand) | 1);
                        $uuid = $uuid . $rand;
                    }else{
                        $output = mb_strlen($output, 'UTF-8') == 6 ? $output : preg_replace('/^urn:uuid:/is', '', $output);
                        $output = preg_replace('/[^a-f0-9]/is', '', $output);
                        $output = mb_strlen($output, 'UTF-8') !== 12 ? NULL : pack("H*", $output);
                        $uuid = $uuid . $output;
                    }
                }
            }
            $uuid = bin2hex($uuid);
            return sprintf('%08s-%04s-%04x-%04x-%12s', mb_substr($uuid, 0, 8, 'UTF-8'), mb_substr($uuid, 8, 4, 'UTF-8'), (hexdec(mb_substr($uuid, 12, 4, 'UTF-8')) & 0x0fff) | 0x3000, (hexdec(mb_substr($uuid, 16, 4, 'UTF-8')) & 0x3fff) | 0x8000, mb_substr($uuid, 20, 12, 'UTF-8'));
        }break;
        case 2:{
            trigger_error("UUID v2 has not yet been implemented");
            return false;
        }break;
        case 3:{
            if ( empty($name)  ) {
                trigger_error("Invalid name");
                return false;
            }
            if ( empty($namespace) || preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?' . '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $namespace) !== 1 ) {
                trigger_error("Invalid namespace");
                return false;
            }
            $nhex = str_replace(array('-','{','}'), '', $namespace);
            $nstr = '';
            for( $i = 0 ; $i < mb_strlen($nhex, 'UTF-8') ; $i += 2 ) {
                $nstr .= chr(hexdec($nhex[$i] . $nhex[$i + 1]));
            }
            $hash = hash('md5', $nstr . $name);
            return sprintf('%08s-%04s-%04x-%04x-%12s', mb_substr($hash, 0, 8, 'UTF-8'), mb_substr($hash, 8, 4, 'UTF-8'), (hexdec(mb_substr($hash, 12, 4, 'UTF-8')) & 0x0fff) | 0x3000, (hexdec(mb_substr($hash, 16, 4, 'UTF-8')) & 0x3fff) | 0x8000, mb_substr($hash, 20, 12, 'UTF-8'));
        }break;
        case 4:{
            return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
        }break;
        case 5:{
            if ( empty($name)  ) {
                trigger_error("Invalid name");
                return false;
            }
            if ( empty($namespace) || preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?' . '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $namespace) !== 1 ) {
                trigger_error("Invalid namespace");
                return false;
            }
            $nhex = str_replace(array('-','{','}'), '', $namespace);
            $nstr = '';
            for( $i = 0 ; $i < mb_strlen($nhex, 'UTF-8') ; $i += 2 ) {
                $nstr .= chr(hexdec($nhex[$i] . $nhex[$i + 1]));
            }
            $hash = hash('sha1', $nstr . $name);
            return sprintf('%08s-%04s-%04x-%04x-%12s', mb_substr($hash, 0, 8, 'UTF-8'), mb_substr($hash, 8, 4, 'UTF-8'), (hexdec(mb_substr($hash, 12, 4, 'UTF-8')) & 0x0fff) | 0x5000, (hexdec(mb_substr($hash, 16, 4, 'UTF-8')) & 0x3fff) | 0x8000, mb_substr($hash, 20, 12, 'UTF-8'));
        }break;
        default:{
            trigger_error("Invalid UUID version");
            return false;
        }break;
    }
}

  
  
  
  
}
?>