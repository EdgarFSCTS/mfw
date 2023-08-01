<?php 

 declare(strict_types=1); 

namespace Magma\LiquidOrm\DataRepository;

use Magma\LiquidOrm\DataRepository\Exception\DataRepositoryException;

class DataRepositoryFactory
{

  protected string $tableSchema;

  protected string $tableSchemaID;

  protected string $crudIdentifier;
  
  public function __construct(string $crudIdentifier, string $tableSchema, string $tableSchemaID)
  {
    $this->crudIdentifier = $crudIdentifier;
    $this->tableSchema = $tableSchema;
    $this->tableSchemaID = $tableSchemaID;
  }

  public function create(string $dataReposotoryString) : object
  {
    $dataRespositoryObject = new $dataReposotoryString();
    if(!$dataRespositoryObject instanceof DataReposotoryInterface){
      throw new DataRepositoryException($dataReposotoryString . ' is not a valid repository object');
    }
    return $dataRespositoryObject;
  }
}


?>