<?php

namespace Drupal\public_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class PublicConfigSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['public_config.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'public_config_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('public_config.settings');

    $form['config_items'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Config Items'),
      '#description' => $this->t('Enter config items in the format "Key|Value", one per line.'),
      '#default_value' => $config->get('config_items'),
    ];

    $form['menu_items'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Menu Items'),
      '#description' => $this->t('Enter menu items in the format "Label|URL", one per line.'),
      '#default_value' => $config->get('menu_items'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('public_config.settings')
      ->set('config_items', $form_state->getValue('config_items'))
      ->set('menu_items', $form_state->getValue('menu_items'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}

/**
 * This public_config should have a config that would return something like:
 * Government Warning|Dangerous
 * Copy Right|Bla bla bla
 * Terms and Condition| bla bla bla
 * Privacy Policy | bla bla bla
 *
 *
 * Then also have another field that returns an array of <Menu>:
 * home|/home
 * profile|/profile
 */
