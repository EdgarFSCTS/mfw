<?php 

 declare(strict_types=1); 

namespace Magma\LiquidOrm\DataMapper;

use PDO;
use Throwable;
use PDOStatement;
use Magma\DatabaseConnection\DatabaseConnectionInterface;
use Magma\LiquidOrm\DataMapper\Exception\DataMapperException;

class DataMapper implements DataMapperInterface
{

  private DatabaseConnectionInterface $dbh;
  private PDOStatement $stmt;
  
  /**
   * Main constructor class
   * 
   * @param DatabaseConnectionInterface $dbh
   * @return void
   */
  public function __construct(DatabaseConnectionInterface $dbh){
    $this->dbh = $dbh;
  }

  private function isEmpty($value, string $errorMessaje = null){
    if(empty($value)){
      throw new DataMapperException($errorMessaje);
    }
  }
  private function isArray(array $value){
    if(!is_array($value)){
      throw new DataMapperException('Your argument needs to be an array');
    }
  }

  public function prepare(string $sql): DataMapperInterface
  {
    $this->stmt = $this->dbh->open()->prepare($sql);
    return $this;
  }

  public function bind($value){
    try{
      switch($value){
        case is_bool($value):
        case intval($value):
          $dataType = PDO::PARAM_BOOL;
        break;
        case is_null($value):
          $dataType = PDO::PARAM_NULL;
        break;
        default:
          $dataType = PDO::PARAM_STR;
        break;
      }
      return $dataType;
    }catch(DataMapperException $exception){
      throw $exception;
    }
  }

  public function bindParameters(array $fields, bool $isSearch = false) : self
  {
    $this->isArray($fields);
    if(is_array($fields)){
      $type = ($isSearch === false) ? $this->bindValues($fields) : $this->bindSearchValues($fields);
      if($type){
        return $this;
      }
    }
    return false;
  }

  protected function bindValues(array $fields){
    // $this->isArray($fields);
    try{
      foreach($fields as $key => $value){
        $this->stmt->bindValue(":{$key}", $value, $this->bind($value));
      }
    }catch(DataMapperException $exception){
      throw $exception;
    }
    return $this->stmt;
  }

  protected function bindSearchValues(array $fields){
    // $this->isArray($fields);
    try{
      foreach($fields as $key => $value){
        $this->stmt->bindValue(":{$key}", '%' . $value . '%', $this->bind($value));
      }
    }catch(DataMapperException $exception){
      throw $exception;
    }
    return $this->stmt;
  }

  public function execute()
  {
    if($this->stmt){
      return $this->stmt->execute();
    }
  }

  public function numRows() : int
  {
    if($this->stmt){
      return $this->stmt->rowCount();
    }
  }

  public function result(): Object
  {
    if($this->stmt){
      return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
  }

  /**
   * @inheritDoc
   * 
   * @return array
   */
  public function results(): array
  {
    if($this->stmt) return $this->stmt->fetchAll();
  }

  public function getLastId() : int
  {
    try{
      if($this->dbh->open()){
        $lastID = $this->dbh->open()->lastInsertId();
        if(!empty($lastID)){
          return intval($lastID);
        }
      }
    }catch(Throwable $throwable){
      throw $throwable;
    }
  }

  public function buildQueryParameters(array $conditions = [], array $parameters = []) : array
  {
    return (!empty($parameters) || (!empty($conditions)) ? array_merge($conditions, $parameters) : $parameters);
  }

  public function persist(string $sqlQuery, array $parameters)
  {
    try{
      return $this->prepare($sqlQuery)->bindParameters($parameters)->execute();
    }catch(Throwable $throwable){
      throw $throwable;
    }
  }

  
}
