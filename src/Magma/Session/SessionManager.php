<?php 

declare(strict_types=1); 

namespace Magma\Session; 

use Magma\Session\SessionFactory;

class SessionManager
{
  public function initialize()
  {
    $factory = new SessionFactory();
    return $factory->create('', 'Magma\Session\Storage\NativeSessionStorage::class', []);
  }
} 

?>