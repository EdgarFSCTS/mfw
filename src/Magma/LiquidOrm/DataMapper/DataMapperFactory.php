<?php 

 declare(strict_types=1); 

namespace Magma\LiquidOrm\DataMapper;

class DataMapperFactory
{
  public function __construct()
  {}

  public function create(string $databaseConnectionString, string $dataMapperEnviromentConfiguration): DataMapperInterface
  {
    $credentials = (new $dataMapperEnviromentConfiguration([]))->getDatabaseCredentials('mysql');
    $databaseConnectionObject = new $databaseConnectionString($credentials);
    if(!$databaseConnectionObject instanceof DatabaseConnectionInterface){
      throw new DataMapperException($databaseConnectionString . ' is not a valid database connection object');
    }
    return new DataMapper($databaseConnectionObject);
  }
}

?>