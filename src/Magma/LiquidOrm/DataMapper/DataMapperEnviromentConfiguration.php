<?php 

 declare(strict_types=1); 

namespace Magma\LiquidOrm\DataMapper;

use Magma\LiquidOrm\DataMapper\Exception\DataMapperInvalidArgumentException;

class DataMapperEnviromentConfiguration
{
  private array $credentials = [];

  public function __construct(array $credentials){
    $this->credentials = $credentials;
  }

  public function getDatabaseCredentials(string $driver) : array
  {
    $connectionArray = [];
    $driver = [
      "mysql" => [
        "dsn" => "mysql:host=localhost",
        "username" => "test",
        "password" => "1234"
      ],
      "pgsql" => [
        "dsn" => "pgsql:host=localhost",
        "username" => "test",
        "password" => "1234"
      ],
    ];
    foreach ($this->credentials as $credential){
      if(array_key_exists($credential, $driver)){
        $connectionArray = $credential[$driver];
      }
    }
    return $connectionArray;
  }

  private function isCredentialsValid(string $driver) : void
  {
    if(empty($driver) && !is_string($driver)){
      throw new DataMapperInvalidArgumentException("Invalid argument. This is either missing or off the invalid data type.");
    }
    if(!is_array($this->credentials)){
      throw new DataMapperInvalidArgumentException("Invalid credendials.");
    }
    if(!in_array($driver, array_keys($this->credentials[$driver]))){
      throw new DataMapperInvalidArgumentException("Invalid or unsupport database driver.");
    }
  }
}

?>