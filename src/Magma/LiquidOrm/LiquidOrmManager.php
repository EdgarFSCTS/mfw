<?php 

 declare(strict_types=1); 

namespace Magma\LiquidOrm;

use Magma\LiquidOrm\EntityManager\Crud;
use Magma\LiquidOrm\QueryBuilder\QueryBuilder;
use Magma\DatabaseConnection\DatabaseConnection;
use Magma\LiquidOrm\DataMapper\DataMapperFactory;
use Magma\LiquidOrm\QueryBuilder\QueryBuilderFactory;
use Magma\LiquidOrm\EntityManager\EntityManagerFactory;
use Magma\LiquidOrm\DataMapper\DataMapperEnviromentConfiguration;

class LiquidOrmManager
{

  protected string $tableSchema; 

  protected string $tableSchemaID;

  protected array $options;

  protected DataMapperEnviromentConfiguration $enviromentConfiguration;

  public function __construct(DataMapperEnviromentConfiguration $enviromentConfiguration, string $tableSchema, string $tableSchemaID, ?array $options = [])
  {
    $this->enviromentConfiguration = $enviromentConfiguration;
    $this->tableSchema = $tableSchema;
    $this->tableSchemaID = $tableSchemaID;
    $this->options = $options;
  }

  public function initialize()
  {
    $dataMapperFactory = new DataMapperFactory();
    $dataMapper = $dataMapperFactory->create(DatabaseConnection::class, DataMapperEnviromentConfiguration::class);
    if($dataMapper){
      $queryBuilderFactory = new QueryBuilderFactory();
      $queryBuilder = $queryBuilderFactory->create(QueryBuilder::class);
      if($queryBuilder){
        $entityManagerFactory = new EntityManagerFactory($dataMapper, $queryBuilder);
        return $entityManagerFactory->create(Crud::class, $this->tableSchema, $this->tableSchemaID, $this->options);
      }
    }
  }

}

?>