<?php 

 declare(strict_types=1); 

namespace Magma\Session;

use Throwable;
use Magma\Session\Exception\SessionException;
use Magma\Session\Storage\SessionStorageInterface;
use Magma\Session\Exception\SessionInvalidArgumentException;

class Session implements SessionInterface
{

  protected SessionStorageInterface $storage;

  protected string $sessionName;

  protected const SESSION_PATTERN = '/^[a-zA-Z0-9_\.]{1,64}$/';

  public function __construct(string $sessionName, SessionStorageInterface $storage = null)
  {
    if($this->isSessionKeyValid($sessionName) === false)
    {
      throw new SessionInvalidArgumentException($sessionName . ' is not a valid session name');
    }
    $this->sessionName = $sessionName;
    $this->storage = $storage;
  }

  public function set(string $key, $value) : void
  {
    $this->ensureSessionKeyIsValid($key);
    try{
      $this->storage->setSession($key, $value);
    }catch(Throwable $throwable){
      throw new SessionException('An exception was thrown in retrieving the key from the session storage.' . $throwable);
    }
  }

  public function setArray(string $key, $value) : void
  {
    $this->ensureSessionKeyIsValid($key);
    try{
      $this->storage->setArraySession($key, $value);
    }catch(Throwable $throwable){
      throw new SessionException('An exception was thrown in retrieving the key from the session storage. ' . $throwable);
    }
  }

  public function get(string $key, $default = null)
  {
    $this->ensureSessionKeyIsValid($key);
    try{
      return $this->storage->getSession($key, $default);
    }catch(Throwable $throwable){
      throw new SessionException('An exception was thrown in retrieving the key from the session storage. ' . $throwable);
    }
  }

  public function delete(string $key): bool
  {
    $this->ensureSessionKeyIsValid($key);
    try{
      return $this->storage->deleteSession($key);
    }catch(Throwable $throwable){
      throw new SessionException('An exception was thrown in retrieving the key from the session storage. ' . $throwable);
    }
  }

  public function invalidate(): void
  {
    $this->storage->invalidate();
  }

  public function flush(string $key, $value)
  {
    $this->ensureSessionKeyIsValid($key);
    try{
      $this->storage->flush($key, $value);
    }catch(Throwable $throwable){
      throw new SessionException('An exception was thrown in retrieving the key from the session storage. ' . $throwable);
    }
  }

  public function has(string $key) : bool
  {
    $this->ensureSessionKeyIsValid($key);
    return $this->storage->hasSession($key);
  }

  protected function isSessionKeyValid(string $key) : bool
  {
    return (bool) preg_match(self::SESSION_PATTERN, $key);
  }

  protected function ensureSessionKeyIsValid(string $key) : void
  {
    if($this->isSessionKeyValid($key) === false){
      throw new SessionInvalidArgumentException($key . ' is not a valid session key');
    }
  }

}

?>