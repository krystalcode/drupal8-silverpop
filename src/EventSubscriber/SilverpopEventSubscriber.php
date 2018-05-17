<?php

namespace Drupal\silverpop\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\silverpop\Event\SilverpopEvent;
use Drupal\silverpop\Event\SilverpopEvents;

/**
 * Redirect .html pages to corresponding Node page.
 */
class SilverpopEventSubscriber implements EventSubscriberInterface {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  /**
   * Constructs a new OrderAssignment object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $event_dispatcher
   *   The event dispatcher.
   */
  public function __construct(ConfigFactoryInterface $config_factory, EventDispatcherInterface $event_dispatcher) {
    $this->configFactory = $config_factory;
    $this->eventDispatcher = $event_dispatcher;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('event_dispatcher')
    );
  }

  /**
   * @inheritdoc
   */
  public static function getSubscribedEvents() {
    $events = [
      KernelEvents::RESPONSE => ['onReponse'],
      SilverpopEvents::BEFORE_SUBMIT => ['onBeforeSubmitEvent'],
    ];

    return $events;
  }

  /**
   * Track events for silverpop.
   *
   * This is where we actually send out the event/page view data to Silverpop.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *   The FilterReponseEvent event.
   */
  public function onReponse(FilterResponseEvent $event) {
  }

  /**
   * Allows the user to alter the event data before it is sent.
   *
   * @param \Drupal\silverpop\Event\SilverpopEvent $event
   *   The silverpop event.
   */
  public function onBeforeSubmitEvent(SilverpopEvent $event) {
  }

}
