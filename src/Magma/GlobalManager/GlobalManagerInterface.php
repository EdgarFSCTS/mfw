<?php 

declare(strict_types=1); 

namespace Magma\GlobalManager; 

interface GlobalManagerInterface
{

  public static function set(string $key, $value) : void;

  public static function get(string $key) : mixed;

} 

?>