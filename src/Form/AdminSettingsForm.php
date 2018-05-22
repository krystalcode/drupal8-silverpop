<?php

namespace Drupal\silverpop\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\RendererInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Manage Silverpop integration settings for this site.
 */
class AdminSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'silverpop_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['silverpop.admin_settings'];
  }

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * Constructs a ConfigTranslationController.
   *
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer.
   */
  public function __construct(RendererInterface $renderer) {
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('renderer')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('silverpop.admin_settings');

    $form['silverpop_tracking'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Silverpop Tracking'),
      '#collapsible' => TRUE,
    ];

    $tracking_image_example_url = drupal_get_path('module', 'silverpop') . '/images/silverpop-web-tracking-code.png';

    $tracking_image = [
      '#theme' => 'image',
      '#attributes' => ['style' => 'border: 1px solid #666; width: 50%;'],
      '#alt' => $this->t('Web Tracking Code example.'),
      '#uri' => $tracking_image_example_url,
    ];

    $form['silverpop_tracking']['silverpop_help'] = [
      '#markup' => '<p>You will need to grab two values from the Silverpop web tracking
      code to add tracking to this website.</p><p>' . $this->renderer->render($tracking_image) . '</p>',
    ];

    $form['silverpop_tracking']['silverpop_tracked_domains'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Tracked Domains'),
      '#default_value' => $config->get('silverpop_tracked_domains'),
      '#description' => 'Enter a comma-separated list of domains for Silverpop to
      track from <a target="_blank" href="https://pilot.silverpop.com/viewOrganization.do">https://pilot.silverpop.com/viewOrganization.do</a>.',
      '#rows' => 2,
    ];

    $form['silverpop_tracking']['silverpop_script_src'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Silverpop Script Source URL'),
      '#default_value' => $config->get('silverpop_script_src'),
      '#description' => 'Copy the source URL from the web tracking code on
      <a target="_blank" href="https://pilot.silverpop.com/viewOrganization.do">https://pilot.silverpop.com/viewOrganization.do</a>.',
      '#rows' => 2,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('silverpop.admin_settings')
      ->set('silverpop_tracked_domains', $form_state->getValue('silverpop_tracked_domains'))
      ->set('silverpop_script_src', $form_state->getValue('silverpop_script_src'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
