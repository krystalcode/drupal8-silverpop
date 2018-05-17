<?php

namespace Drupal\silverpop\Form;

use Drupal\silverpop\Entity\SilverpopEventType;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for the silverpop_event_type forms.
 */
class SilverpopEventTypeForm extends EntityForm {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs an SilverpopEventTypeForm object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entityTypeManager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    /** @var \Drupal\silverpop\Entity\SilverpopEventType $silverpop_event_type */
    $silverpop_event_type = $this->entity;

    // Event ID; we already have the event type set in Silverpop as a unique
    // identifier so we don't need to create a machine name as an ID.
    $form['id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Event name (no spaces allowed)'),
      '#description' => $this->t('Add the name of the custom event you set up in Silverpop.'),
      '#default_value' => $silverpop_event_type->id(),
      '#disabled' => !$silverpop_event_type->isNew(),
      '#required' => TRUE,
    ];

    // Event name.
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Event friendly name'),
      '#description' => 'Add the friendly name of the custom event you set up in Silverpop.',
      '#maxlength' => 255,
      '#default_value' => $silverpop_event_type->label(),
      '#required' => TRUE,
    ];

    // CSS Selector.
    $form['css_selector'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CSS Selector'),
      '#description' => $this->t('This is the CSS selector that will add
        Silverpop tracking. Examples are CSS id\'s (e.g. "#foobar") or class
        names (e.g. ".foobar"). <br><strong>Leave empty if this is a page tracking
        event.</strong>'
      ),
      '#maxlength' => 255,
      '#default_value' => $silverpop_event_type->getCssSelector(),
    ];

    $form['visibility_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Visibility'),
    ];

    $form['visibility_fieldset']['page_request_path'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Pages'),
      '#default_value' => $silverpop_event_type->getPageRequestPath(),
      '#description' => $this->t(
        "Specify pages by using their paths. Enter one path per line. The '*'
        character is a wildcard. An example path is %user-wildcard for every
        user page. %front is the front page.
        <br><strong>Leave blank to include on all pages.</strong>",
        [
          '%user-wildcard' => 'user/*',
          '%front' => '<front>',
        ]
      ),
    ];

    $page_visibility = $silverpop_event_type->getPageVisibility();
    if ($page_visibility === NULL) {
      $page_visibility = SilverpopEventType::PAGE_VISIBILITY_INCLUDE;
    }
    $form['visibility_fieldset']['page_visibility'] = [
      '#title' => $this->t('Page visibility'),
      '#type' => 'radios',
      '#default_value' => $page_visibility,
      '#title_display' => 'invisible',
      '#options' => [
        SilverpopEventType::PAGE_VISIBILITY_INCLUDE => $this->t('Include in the listed pages'),
        SilverpopEventType::PAGE_VISIBILITY_EXCLUDE => $this->t('Exclude from the listed pages'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $id = $form_state->getValue('id');

    // No spaces allowed.
    if (strpos($id, ' ') !== FALSE) {
      $form_state->setErrorByName(
        'id',
        $this->t('The event name should not contain any spaces.')
      );
    }

    if ($this->entity->isNew() && $this->exists($id)) {
      $form_state->setErrorByName(
        'id',
        $this->t('An event with the same name already exists.')
      );
    }
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $this->entity->save();

    drupal_set_message($this->t('Saved the %label Silverpop event type.', [
      '%label' => $this->entity->label(),
    ]));

    $form_state->setRedirect('entity.silverpop_event_type.collection');
  }

  /**
   * Helper function to check whether a SilverpopEventType config entity exists.
   */
  protected function exists($id) {
    $ids = $this->entityTypeManager
      ->getStorage('silverpop_event_type')
      ->getQuery()
      ->condition('id', $id)
      ->execute();

    return (bool) $ids;
  }

}
