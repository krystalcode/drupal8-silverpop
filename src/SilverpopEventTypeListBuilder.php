<?php

namespace Drupal\silverpop;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Defines the list builder for Silverpop event type.
 */
class SilverpopEventTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Event Name');
    $header['id'] = $this->t('Event Type');
    $header['css_selector'] = $this->t('CSS Selector');
    $header['page_request_path'] = $this->t('Page Request Path');
    $header['page_visibility'] = $this->t('Page Visibility');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\silverpop\Entity\SilverpopEventTypeInterface $event_type */
    $event_type = $entity;

    $row['label'] = $event_type->label();
    $row['id'] = $event_type->id();
    $row['css_selector'] = $event_type->getCssSelector();
    $row['page_request_path'] = $event_type->getPageRequestPath();

    $row['page_visibility'] = $this->t('Include on all pages');
    if (!empty($event_type->getPageRequestPath())) {
      $row['page_visibility'] = $event_type->mapPageVisibility($event_type->getPageVisibility());
    }

    return $row + parent::buildRow($event_type);
  }

}
