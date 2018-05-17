<?php

namespace Drupal\silverpop\Event;

/**
 * Defines the names of events related to Silverpop events.
 */
final class SilverpopEvents {

  /**
   * Name of the event fired before submitting an event to Silverpop.
   *
   * Fired before the event is sent to silverpop.
   *
   * @Event
   *
   * @see \Drupal\silverpop\Event\SilverpopEvent
   */
  const BEFORE_SUBMIT = 'silverpop_event_type.before_submit';

}
