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
    /** @var \Drupal\silverpop\Entity\SilverpopEventTypeInterface $entity */
    $row['label'] = $entity->label();
    $row['id'] = $entity->id();
    $row['css_selector'] = $entity->getCssSelector();
    $row['page_request_path'] = $entity->getPageRequestPath();
    $row['page_visibility'] = $entity->mapPageVisibility($entity->getPageVisibility());

    return $row + parent::buildRow($entity);
  }

}
