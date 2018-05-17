<?php

namespace Drupal\silverpop\Event;

use Drupal\silverpop\Entity\SilverpopEventTypeInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Defines the Silverpop event event.
 *
 * @see \Drupal\silverpop\Event\SilverpopEvents
 */
class SilverpopEvent extends Event {

  /**
   * The Silverpop event type.
   *
   * @var \Drupal\silverpop\Entity\SilverpopEventTypeInterface
   */
  protected $silverpopEventType;

  /**
   * Constructs a new SilverpopEvent.
   *
   * @param \Drupal\silverpop\Entity\SilverpopEventTypeInterface $silverpop_event_type
   *   The Silverpop event type.
   */
  public function __construct($silverpop_event_type) {
    $this->silverpopEvent_type = $silverpop_event_type;
  }

  /**
   * Gets the Silverpop event type.
   *
   * @return \Drupal\silverpop\Entity\SilverpopEventTypeInterface
   *   Gets the Silverpop event type.
   */
  public function getSilverpopEventType() {
    return $this->silverpopEventType;
  }

}
