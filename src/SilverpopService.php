<?php

namespace Drupal\silverpop;

use Drupal\silverpop\Entity\SilverpopEventType;
use Drupal\Component\Utility\Unicode;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Path\AliasManagerInterface;
use Drupal\Core\Path\CurrentPathStack;
use Drupal\Core\Path\PathMatcherInterface;

/**
 * A utility service providing functionality related to the silverpop module.
 */
class SilverpopService {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The current path service.
   *
   * @var \Drupal\Core\Path\CurrentPathStack
   */
  protected $currentPath;

  /**
   * The patch matcher service.
   *
   * @var \Drupal\Core\Path\PathMatcherInterface
   */
  protected $pathMatcher;

  /**
   * The path alias manager.
   *
   * @var \Drupal\Core\Path\AliasManagerInterface
   */
  protected $aliasManager;

  /**
   * Constructs a new SilverpopService object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Path\CurrentPathStack $current_path
   *   The current path.
   * @param \Drupal\Core\Path\AliasManagerInterface $alias_manager
   *   The path alias manager.
   * @param \Drupal\Core\Path\PathMatcherInterface $path_matcher
   *   The path matcher service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, CurrentPathStack $current_path, AliasManagerInterface $alias_manager, PathMatcherInterface $path_matcher = NULL) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentPath = $current_path;
    $this->aliasManager = $alias_manager;
    $this->pathMatcher = $path_matcher ?: \Drupal::service('path.matcher');
  }

  /**
   * Fetch event tracking info for the current page.
   *
   * Based on visibility setting this function returns the events that should be
   * tracked in the current page.
   *
   * @return array
   *   The array of silverpop_event_type objects.
   */
  public function silverpopGetEventsEnabledForCurrentPage() {
    static $events_for_page;

    // Cache visibility result if function is called more than once.
    if (isset($events_for_page)) {
      return $events_for_page;
    }

    $events_for_page = [];
    $event_types = $this->entityTypeManager
      ->getStorage('silverpop_event_type')
      ->loadMultiple();

    foreach ($event_types as $event_type) {
      /** @var \Drupal\silverpop\Entity\SilverpopEventType $event_type */
      $visibility_request_path_pages = $event_type->getPageRequestPath();

      // If we don't have any paths, add tracking for this event for this page.
      if (empty($visibility_request_path_pages)) {
        $events_for_page[$event_type->id()] = $event_type;
        continue;
      }

      // Match all paths.
      $paths = preg_split("(\r\n?|\n)", $visibility_request_path_pages);
      $paths_match = $this->validatePaths($paths, $event_type->getPageVisibility());

      if ($paths_match) {
        $events_for_page[$event_type->id()] = $event_type;
      }
    }

    return $events_for_page;
  }

  /**
   * Validate the paths with the current page.
   *
   * Returns TRUE if the paths match.
   */
  public function validatePaths($paths, $visibility_request_path_mode) {
    $current_path = $this->currentPath->getPath();
    $path_alias = Unicode::strtolower(
      $this->aliasManager
        ->getAliasByPath($current_path)
    );

    foreach ($paths as $key => $path) {
      $paths[$key] = $path === '<front>'
        ? $path
        : '/' . ltrim($path, '/');
    }

    // Check if the current page matches any of the include paths.
    foreach ($paths as $page) {
      $page_match = $this->pathMatcher
        ->matchPath($path_alias, $page)
        || (($current_path != $path_alias)
          && $this->pathMatcher->matchPath($current_path, $page));

      // When $visibility_request_path_mode has a value of 0, the tracking
      // code is displayed on all pages except those listed in $paths. When
      // set to 1, it is displayed only on those pages listed in $paths.
      if ($page_match) {
        // If we have a page_match but the visibility is for excluding it from
        // that path return FALSE.
        if ($visibility_request_path_mode == SilverpopEventType::PAGE_VISIBILITY_EXCLUDE) {
          return FALSE;
        }
        return TRUE;
      }
    }

    // If we have no page matches but the visibility is for excluding the listed
    // paths, return TRUE.
    if (!$page_match && $visibility_request_path_mode == SilverpopEventType::PAGE_VISIBILITY_EXCLUDE) {
      return TRUE;
    }

    return FALSE;
  }

}
