<?php

namespace Drupal\silverpop\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\silverpop\SilverpopEvent;

/**
 * Redirect .html pages to corresponding Node page.
 */
class SilverpopEventSubscriber implements EventSubscriberInterface {

  /**
   * @inheritdoc
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = ['trackEvents'];
    return $events;
  }

  /**
   * Track events for silverpop.
   *
   * This is where we actually send out the event/page view data to Silverpop.
   */
  public function trackEvents(FilterResponseEvent $event) {
    $config = \Drupal::config('silverpop.admin_settings');
    $domains = $config->get('silverpop_tracked_domains');

    // Load the Symfony event dispatcher object through services.
    $dispatcher = \Drupal::service('event_dispatcher');

    // Create our event class object.
    $event = new SilverpopEvent();
    // Now, dispatch.
    $dispatcher->dispatch(SilverpopEvent::SUBMIT, $event);

    // Add Silverpop page tracking.
    /*if ($domains) {
      $meta = array(
        '#tag' => 'meta',
        '#attributes' => array(
          'name' => 'com.silverpop.brandeddomains',
          'content' => $domains,
        ),
      );

      drupal_add_html_head($meta, 'silverpop_webtracking_metatag');
    }

    // Add custom page name meta tag for Silverpop web tracking summary report.
    $meta_page_name = array(
      '#tag' => 'meta',
      '#attributes' => array(
        'name' => 'com.silverpop.pagename',
        'content' => drupal_get_title(),
      ),
    );
    drupal_add_html_head($meta_page_name, 'silverpop_webtracking_page_name');

    $tracking_source = variable_get('silverpop_script_src', '');

    if ($tracking_source) {
      drupal_add_js($tracking_source, 'external');
    }

    // Add event tracking.
    $result = db_query("SELECT * FROM {silverpop_settings}");

    foreach ($result as $row) {
      $event_name = check_plain($row->event_name);
      $event_type = check_plain($row->event_type);
      $css_selector = check_plain($row->css_selector);

      $tracking_js = "return ewt.trackLink({name:'$event_name',type:'$event_type',link:this });";

      drupal_add_js("jQuery('$css_selector').click(function () { $tracking_js });",
        array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)
      );
    }

    $response = $event->getResponse();
    kint($response);
    $response->headers->set('X-Custom-Header', 'MyValue');*/
  }

}
