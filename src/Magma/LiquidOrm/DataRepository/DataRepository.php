<?php 

 declare(strict_types=1); 

namespace Magma\LiquidOrm\DataRepository;

use Magma\LiquidOrm\EntityManager\EntityManagerInterface;
use Magma\LiquidOrm\DataRepository\DataReposotoryInterface;
use Magma\LiquidOrm\DataRepository\Exception\DataRepositoryInvalidArgumentException;
use Throwable;

class DataRepository implements DataReposotoryInterface
{

  protected EntityManagerInterface $entityManager;

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }
  
  private function isArray(array $conditions) : void
  {
    if(!is_array($conditions)){
      throw new DataRepositoryInvalidArgumentException('The argument supplied is not an array');
    }
  }

  private function isEmpty(int $id) : void
  {
    if(empty($id)){
      throw new DataRepositoryInvalidArgumentException('The argument supplied is empty');
    }
  }

  public function find(int $id) : array
  {
    $this->isEmpty($id);
    try{
      return $this->findOneBy(['id'=>$id]);
    }catch(Throwable $throwable){
      throw $throwable;
    }
  }

  public function findAll() : array
  {
    try{
      return $this->entityManager->getCrud()->read();
    }catch(Throwable $throwable){
      throw $throwable;
    }
  }

  public function findBy(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []) : array
  {
    try{
      return $this->entityManager->getCrud()->read($selectors,$conditions, $parameters, $optional);
    }catch(Throwable $throwable){
      throw $throwable;
    }
  }
  
  public function findOneBy(array $conditions) : array
  {
    $this->isArray($conditions);
    try{
      return $this->entityManager->getCrud()->read([],$conditions);
    }catch(Throwable $throwable){
      throw $throwable;
    }
  }
  
  public function findObjectBy(array $conditions = [], array $selectors = []) : object
  {
  }

  public function findBySearch(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []) : array
  {
    $this->isArray($conditions);
    try {
      return $this->entityManager->getCrud()->search($selectors,$conditions, $parameters, $optional);
    } catch (Throwable $throwable) {
      throw $throwable;
    }
  }

  public function findByIdAndDelete(array $conditions) : bool
  {
    $this->isArray($conditions);
    try{
      $result = $this->findOneBy($conditions);
      if($result != null && count($result) > 0){
        $delete = $this->entityManager->getCrud()->delete($conditions);
        if($delete){
          return true;
        }
      }
    }catch(Throwable $throwable){
      throw $throwable;
    }
  }

  public function findByIdAndUpdate(array $fields = [], int $id) : bool
  {
    $this->isArray($fields);
    try{
      $result = $this->findOneBy([$this->entityManager->getCrud()->getSchemaId() => $id]);
      if($result != null && count($result) >0){
        $params = (!empty($fields)) ? array_merge([$this->entityManager->getCrud()->getSchemaId => $id], $fields) : $fields;
        $update = $this->entityManager->getCrud()->update($params, $this->entityManager->getCrud()->getSchemaId());
        if($update){
          return true;
        }
      }

    }catch(Throwable $throwable){
      throw $throwable;
    }
  }

  public function findWithSearchAndPaging(array $args, object $request) : array
  {
    return [];
  }

  public function findAndReturn(int $id, array $selectors = []): self
  {
    return $this;
  }

}
