<?php

namespace Drupal\d8_routing_demo\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class WeatherConfigForm extends ConfigFormBase {

	public function getFormId() {
		return 'd8_routing_demo_weather_config_form';
	}

	public function buildForm(array $form, FormStateInterface $form_state) {
	$app_value = $this->config('d8_routing_demo.weather')->get('app_id');
	$app_value1 = $this->config('d8_routing_demo.weather1')->get('app_id1');
    $form ['app_id'] = [
      '#type' => 'textfield',
      '#title' => t('Enter app id'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
      '#default_value' => $app_value,
    ];
    $form ['app_id1'] = [
      '#type' => 'textfield',
      '#title' => t('Enter app id 2'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
      '#default_value' => $app_value1,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Submit')
    ];

    return $form;
  }


public function submitForm(array &$form, FormStateInterface $form_state) {

$this->config('d8_routing_demo.weather')
      ->set('app_id', $form_state->getValue('app_id'))
      ->save();

$this->config('d8_routing_demo.weather1')
      ->set('app_id1', $form_state->getValue('app_id1'))
      ->save();

 parent::submitForm($form, $form_state);
}

protected function getEditableConfigNames() {
    return [
      'd8_routing_demo.weather',
      'd8_routing_demo.weather1',
    ];
  }
}