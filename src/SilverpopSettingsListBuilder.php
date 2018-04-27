<?php

namespace Drupal\silverpop;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\silverpop\Entity\SilverpopSettingsInterface;

/**
 * Defines the list builder for Silverpop settings.
 */
class SilverpopSettingsListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Event Name');
    $header['event_type'] = $this->t('Event Type');
    $header['css_selector'] = $this->t('CSS Selector');
    $header['page_request_path'] = $this->t('Page Request Path');
    $header['page_visibility'] = $this->t('Page Visibility');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\silverpop\Entity\SilverpopSettingsInterface $entity */
    $row['label'] = $entity->getEventName();
    $row['event_type'] = $entity->getEventType();
    $row['css_selector'] = $entity->getCssSelector();
    $row['page_request_path'] = $entity->getPageRequestPath();
    $row['page_visibility'] = $entity->mapPageVisibility($entity->getPageVisibility());
    return $row + parent::buildRow($entity);
  }

}
