<?php
namespace Drupal\d8_routing_demo\Controller;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;

class DataController implements ContainerInjectionInterface{

protected $db;
public function __construct(Connection $db) {
    $this->db = $db;
  }

public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

function getLastEntry(){

   $results = $this->db->select('d8_demo', 'dd')
      ->fields('dd')
      ->orderBy('id', 'DESC')
      ->range(0,1)
      ->execute()
      ->fetchAll();
    $last_value = $results[0];
    return $last_value;
}
function insertToTable($first_name,$last_name){

    $this->db->insert('d8_demo')
        ->fields([
        'first_name' => $first_name,
         'last_name' => $last_name,
        ])
        ->execute();

}

}