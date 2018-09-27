<?php
namespace Drupal\d8_routing_demo\Controller;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;
use Drupal\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Drupal\d8_routing_demo\Event\DataEntryEvent;

class DataController implements ContainerInjectionInterface{

  protected $connection;
  protected $dispatcher;

  public function __construct(Connection $connection, ContainerAwareEventDispatcher $dispatcher) {
    $this->connection = $connection;
    $this->dispatcher = $dispatcher;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('event_dispatcher')
    );
  }
public function getLastEntry(){

   $results = $this->connection->select('d8_demo', 'dd')
      ->fields('dd')
      ->orderBy('id', 'DESC')
      ->range(0,1)
      ->execute()
      ->fetchAll();
    $last_value = $results[0];
    return $last_value;
}
public function insertToTable($firstName, $lastName) {
    $this->connection->insert('d8_demo')
      ->fields([
        'first_name' => $firstName,
        'last_name' => $lastName,
      ])
      ->execute();

    $this->dispatcher->dispatch(
      DataEntryEvent::DATA_INSERT,
      new DataEntryEvent($firstName,$lastName)
    );
  }
}