<?php

namespace Drupal\silverpop\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Entity\EntityDescriptionInterface;

/**
 * Defines the interface for Silverpop event types.
 */
interface SilverpopEventTypeInterface extends ConfigEntityInterface, EntityDescriptionInterface {

  /**
   * Sets the label.
   *
   * @param string $label
   *   The label of the event.
   *
   * @return $this
   */
  public function setLabel($label);

  /**
   * Gets the CSS selector.
   *
   * @return string
   *   The css selector.
   */
  public function getCssSelector();

  /**
   * Sets the CSS selector.
   *
   * @param string $css_selector
   *   The CSS selector.
   *
   * @return $this
   */
  public function setCssSelector($css_selector);

  /**
   * Gets the paths this event should be included in/excluded from.
   *
   * @return string
   *   The paths of the pages.
   */
  public function getPageRequestPath();

  /**
   * Sets the paths this event should be included in/excluded from.
   *
   * @param string $page_request_path
   *   The page paths.
   *
   * @return $this
   */
  public function setPageRequestPath($page_request_path);

  /**
   * Gets whether to include the event on the denoted pages or exclude.
   *
   * @return int
   *   Denotes 0 to include on listed pages, 1 to hide on listed pages.
   */
  public function getPageVisibility();

  /**
   * Sets whether to include the event on the denoted pages or exclude.
   *
   * @param int $page_visibility
   *   Denotes 0 to include on listed pages, 1 to hide on listed pages.
   *
   * @return $this
   */
  public function setPageVisibility($page_visibility);

  /**
   * Gets the associative data.
   *
   * @return array
   *   The associative data array.
   */
  public function getData();

  /**
   * An array of data to pass along with the event to silverpop.
   *
   * @param array $data
   *   The associative data array.
   *
   * @return $this
   */
  public function setData(array $data);

}
