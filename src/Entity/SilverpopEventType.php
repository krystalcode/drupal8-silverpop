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
 *   admin_permission = "administer silverpop_event_type",
 *   config_prefix = "silverpop_event_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *     "css_selector",
 *     "page_visibility",
 *     "page_request_path",
 *     "data",
 *   },
 *   links = {
 *     "add-form" = "/admin/config/services/silverpop/event-types/add",
 *     "edit-form" = "/admin/config/services/silverpop/event-types/{silverpop_event_type}/edit",
 *     "delete-form" = "/admin/config/services/silverpop/event-types/{silverpop_event_type}/delete",
 *     "collection" = "/admin/config/services/silverpop/event-types",
 *   }
 * )
 */
class SilverpopEventType extends ConfigEntityBase implements SilverpopEventTypeInterface {

  /**
   * Indicates that an event should be included in the defined paths.
   */
  const PAGE_VISIBILITY_INCLUDE = 0;

  /**
   * Indicates that an event should be excluded from the defined paths.
   */
  const PAGE_VISIBILITY_EXCLUDE = 1;

  /**
   * The configuration entity ID.
   *
   * @var string
   */
  protected $id;

  /**
   * A human-friendly label for the event.
   *
   * @var string
   */
  protected $label;

  /**
   * A description for the event.
   *
   * @var string
   */
  protected $description;

  /**
   * CSS selector of site link to track clicks.
   *
   * @var string
   */
  protected $css_selector;

  /**
   * Whether to include the event on the denoted pages or exclude.
   *
   * @var string
   */
  protected $page_visibility;

  /**
   * The paths this event should be included in/excluded from.
   *
   * @var string
   */
  protected $page_request_path;

  /**
   * An associative array of data that should be passed with the event.
   *
   * @var array
   */
  protected $data;

  /**
   * {@inheritdoc}
   */
  public function setLabel($label) {
    $this->label = $label;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription($description) {
    $this->description = $description;
    return $this;
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
  public function setData(array $data) {
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
      self::PAGE_VISIBILITY_INCLUDE => 'Include on the selected pages',
      self::PAGE_VISIBILITY_EXCLUDE => 'Omit from the selected pages',
    ];

    return $map_array[$key];
  }

}
