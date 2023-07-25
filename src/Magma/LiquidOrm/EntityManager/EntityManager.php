<?php 

 declare(strict_types=1); 

namespace Magma\LiquidOrm\EntityManager;

use Magma\LiquidOrm\EntityManager\EntityManagerInterface;
use Magma\LiquidOrm\EntityManager\CrudInterface;

class EntityManager implements EntityManagerInterface
{

  protected CrudInterface $crud;

  public function __construct(CrudInterface $crud)
  {
    $this->crud = $crud;
  }
  public function getCrud(): object
  {
    return $this->crud;
  }
}

?>