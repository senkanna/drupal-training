<?php

namespace Drupal\d8_routing_demo\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Drupal\dblog\Logger\DbLog;

/**
 * Class DataEntryEvent.
 */
class DataEntryEvent implements EventSubscriberInterface {

  /**
   * Psr\Log\LoggerInterface definition.
   *
   * @var \Psr\Log\LoggerInterface
   */
 protected $logger;
  /**
   * Constructs a new DataEntryEventSubscriber object.
   */
  public function __construct(DbLog $logger) {
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events['d8_routing_demo.data.insert'] = ['logFirstLastname'];

    return $events;
  }

  /**
   * This method is called whenever the d8_routing_demo.data.insert event is
   * dispatched.
   *
   * @param GetResponseEvent $event
   */
  public function logFirstLastname(Event $event) {


   \Drupal::logger('system')->info($event->firstName .''.$event->lastName);
  }

}
