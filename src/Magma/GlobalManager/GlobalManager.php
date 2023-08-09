<?php 

declare(strict_types=1); 

namespace Magma\GlobalManager;

use Magma\GlobalManager\Exception\GlobalManagerException;
use Magma\GlobalManager\Exception\GlobalManagerInvalidArgumentException;
use Magma\GlobalManager\GlobalManagerInterface;
use Throwable;

class GlobalManager implements GlobalManagerInterface
{


  public static function set(string $key, $value) : void
  {
    $GLOBALS[$key] = $value;
  }

  public static function get(string $key) : mixed
  {
    self::isGlobalValid($key);
    try{
      return $GLOBALS[$key];
    }catch(Throwable $throwable){
      throw new GlobalManagerException('An exception was thown trying to retrieve the data.');
    }
  }

  private static function isGlobalValid(string $key) : void
  {
    if(!isset($GLOBALS[$key])){
      throw new GlobalManagerInvalidArgumentException('Invalid global key. Please ensure you have set the global lstate for ' . $key);
    }
    if(empty($key)){
      throw new GlobalManagerInvalidArgumentException('Argument cannot be empty.');
    }
  }

} 

?>