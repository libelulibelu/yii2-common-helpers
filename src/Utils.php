<?php

namespace Libelula\CommonHelpers;

use MongoDB\BSON\UTCDateTime;
use Yii;

class Utils
{

  public const DATE_FORMAT = 'Y-m-d H:i:s';

  public static function getNow(string $format = self::DATE_FORMAT): string
  {
    return date($format);
  }

  public static function getNowTime(string $format = self::DATE_FORMAT)
  {
    return strtotime(self::getNow($format));
  }

  public static function getDate(
    int $time,
    string $format = self::DATE_FORMAT
  ) {
    return date($format, $time);
  }

  public static function getNowMenosDias(
    int $dias,
    string $format = self::DATE_FORMAT
  ): string {
    return date($format, strtotime("-{$dias} days"));
  }

  public static function getNowMongo(): UTCDateTime
  {
    return self::getMongoDate(self::getNow());
  }

  public static function getMongoDate(string $date): UTCDateTime
  {
    $date = str_replace('/', '-', $date);
    return new UTCDateTime(strtotime($date) * 1000);
  }

  /**
   * @param float|int $precio
   */
  public static function getDosDecimales($precio): string
  {
    return number_format(round($precio, 2), 2, '.', '');
  }

  /**
   * Si no tenemos fecha devolvemos un string vacio
   */
  public static function getDateFromMongo(
    UTCDateTime $date = null,
    string $format = self::DATE_FORMAT
  ): string {
    if (is_null($date)) {
      return '';
    }
    $date = (string) $date;
    return date($format, ($date / 1000));
  }

  public static function getMongoDateFromTime(int $time): UTCDateTime
  {
    $date = self::getDate($time);
    return new UTCDateTime(strtotime($date) * 1000);
  }

  public static function getIDActualUser()
  {
    return Yii::$app->user->identity->_id ?? null;
  }

  public static function getMinutesTranscurridos(
    int $init
  ): float {
    $now = strtotime(Utils::getNow());
    $mins = ($init - $now) / 60;
    $mins = abs($mins);
    return floor($mins);
  }

  public static function getUserIP()
  {
    return Yii::$app->request->userIp;
  }
}
