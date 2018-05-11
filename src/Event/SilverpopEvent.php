<?php

namespace Drupal\silverpop\Event;

use Symfony\Component\EventDispatcher\Event;

class SilverpopEvent extends Event {

  /**
   * Submit a silverpop event.
   *
   * Fired before the event is sent to silverpop.
   *
   * @Event
   */
  const BEFORE_SUBMIT = 'silverpop_event_type.event.before_submit';
}
