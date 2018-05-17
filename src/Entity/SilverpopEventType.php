<?php

namespace Drupal\silverpop\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Silverpop event type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "silverpop_event_type",
 *   label = @Translation("Silverpop event type"),
 *   label_collection = @Translation("Silverpop event type"),
 *   label_singular = @Translation("Silverpop event type"),
 *   label_plural = @Translation("Silverpop event types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count Silverpop event type",
 *     plural = "@count Silverpop event types",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\silverpop\SilverpopEventTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\silverpop\Form\SilverpopEventTypeForm",
 *       "edit" = "Drupal\silverpop\Form\SilverpopEventTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     },
 *     "route_provider" = {
 *       "default" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer silverpop event types",
 *   config_prefix = "silverpop_event_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "event_name",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "event_type",
 *     "css_selector",
 *     "page_visibility",
 *     "page_request_path",
 *     "data",
 *     "traits",
 *     "locked",
 *   },
 *   links = {
 *     "add-form" = "/admin/config/services/silverpop/event-type/add",
 *     "edit-form" =
 *   "/admin/config/services/silverpop/event-type/{silverpop_event_type}/edit",
 *     "delete-form" = "/admin/config/services/silverpop/event-type/{silverpop_event_type}/delete",
 *     "collection" = "/admin/config/services/silverpop/event-types",
 *   }
 * )
 */
class SilverpopEventType extends ConfigEntityBase implements SilverpopEventTypeInterface {

  /**
   * An event friendly name to track.
   *
   * @var string
   */
  protected $label;

  /**
   * An event type to track.
   *
   * @var string
   */
  protected $event_type;

  /**
   * CSS selector of site link to track clicks.
   *
   * @var string
   */
  protected $css_selector;

  /**
   * CSS selector of site link to track clicks.
   *
   * @var string
   */
  protected $page_visibility;

  /**
   * CSS selector of site link to track clicks.
   *
   * @var string
   */
  protected $page_request_path;

  /**
   * An associative array of info that should be passed with the event.
   *
   * @var array
   */
  protected $data;

  /**
   * {@inheritdoc}
   */
  public function setEventName($label) {
    $this->label = $label;
  }

  /**
   * {@inheritdoc}
   */
  public function getEventName() {
    return $this->label;
  }

  /**
   * {@inheritdoc}
   */
  public function setEventType($event_type) {
    $this->event_type = $event_type;
  }

  /**
   * {@inheritdoc}
   */
  public function getEventType() {
    return $this->event_type;
  }

  /**
   * {@inheritdoc}
   */
  public function setCssSelector($css_selector) {
    $this->css_selector = $css_selector;
  }

  /**
   * {@inheritdoc}
   */
  public function getCssSelector() {
    return $this->css_selector;
  }

  /**
   * {@inheritdoc}
   */
  public function setPageVisibility($page_visibility) {
    $this->page_visibility = $page_visibility;
  }

  /**
   * {@inheritdoc}
   */
  public function getPageVisibility() {
    return $this->page_visibility;
  }

  /**
   * {@inheritdoc}
   */
  public function setPageRequestPath($page_request_path) {
    $this->page_request_path = $page_request_path;
  }

  /**
   * {@inheritdoc}
   */
  public function getPageRequestPath() {
    return $this->page_request_path;
  }

  /**
   * {@inheritdoc}
   */
  public function setData($data) {
    $this->data = $data;
  }

  /**
   * {@inheritdoc}
   */
  public function getData() {
    return $this->data;
  }

  /**
   * Returns the human name for the page visibility.
   *
   * @param int $key
   *   The page visibility key.
   *
   * @return string
   *   The human name for the visibility type.
   */
  public function mapPageVisibility($key) {
    $map_array = [
      0 => 'Include on the selected pages',
      1 => 'Omit from the selected pages',
    ];

    return $map_array[$key];
  }

}
