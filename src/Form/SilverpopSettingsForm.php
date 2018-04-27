<?php

namespace Drupal\silverpop\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for the silverpop_settings forms.
 */
class SilverpopSettingsForm extends EntityForm {

  /**
   * Constructs an SilverpopSettingsForm object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   *   The entityTypeManager.
   */
  public function __construct(EntityTypeManager $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
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

    /** @var \Drupal\silverpop\Entity\SilverpopSettings $silverpop_settings */
    $silverpop_settings = $this->entity;

    // Event name.
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Event Name (no spaces allowed)'),
      '#description' => $this->t('Add the name of the custom event you set up in Silverpop.'),
      '#maxlength' => 255,
      '#default_value' => $silverpop_settings->getEventName(),
      '#required' => TRUE,
    ];
    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $silverpop_settings->id(),
      '#machine_name' => [
        'exists' => [$this, 'exist'],
      ],
      '#disabled' => !$silverpop_settings->isNew(),
      '#description' => $this->t('A unique machine-readable name for this event.'),
    ];

    // Event type.
    $form['event_type'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Event Friendly Name'),
      '#description' => $this->t('Add the friendly name of the custom event you set up in Silverpop.'),
      '#maxlength' => 255,
      '#default_value' => $silverpop_settings->getEventType(),
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
      '#default_value' => $silverpop_settings->getCssSelector(),
    ];

    $form['visibility_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Visibility'),
    ];

    $form['visibility_fieldset']['page_request_path'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Pages'),
      '#default_value' => $silverpop_settings->getPageRequestPath(),
      '#description' => $this->t("Specify pages by using their paths. 
        Enter one path per line. The '*' character is a wildcard. An example 
        path is %user-wildcard for every user page. %front is the front page.
        <br><strong>Leave blank to include on all pages.</strong>", [
        '%user-wildcard' => 'user/*',
        '%front' => '<front>',
      ]),
    ];

    $form['visibility_fieldset']['page_visibility'] = [
      '#title' => $this->t('Pages'),
      '#type' => 'radios',
      '#default_value' => !empty($silverpop_settings->getPageVisibility())
        ?:
        0,
      '#title_display' => 'invisible',
      '#options' => [
        $this->t('Show for the listed pages'),
        $this->t('Hide for the listed pages'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $this->entity->save();

    drupal_set_message($this->t('Saved the %label silverpop setting.', [
      '%label' => $this->entity->label(),
    ]));

    $form_state->setRedirect('entity.silverpop_settings.collection');
  }

  /**
   * Helper function to check whether a SilverpopSettings config entity exists.
   */
  public function exist($id) {
    $entity = $this->entityTypeManager->getStorage('silverpop_settings')->getQuery()
      ->condition('id', $id)
      ->execute();
    return (bool) $entity;
  }

}
