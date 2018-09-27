<?php

namespace Drupal\d8_routing_demo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class SimpleForm extends FormBase {

	public function getFormId() {
		return 'd8_routing_demo_simple_form';
	}

	public function buildForm(array $form, FormStateInterface $form_state) {
    $form ['demo_textfield'] = [
      '#type' => 'textfield',
      '#title' => t('Enter some text'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    ];
    $form['qualification'] = [
      '#type' => 'select',
      '#title' => $this->t('Qualification'),
      '#options' => array('ug' => 'ug', 'pg' => 'pg','other' => 'other')
    ];
     $form ['other'] = [
      '#type' => 'textfield',
      '#title' => t('Other Country'),
      '#size' => 60,
      '#states' => array(
        'visible' => array(
          ':input[name="qualification"]' => array('value' => 'other'),
        ),
      )
    ];
    $form['country'] = [
      '#type' => 'select',
      '#title' => $this->t('Country'),
      '#options' => array('India' => 'India', 'UK' => 'UK')
    ];
    $form ['india-states'] = [
      '#type' => 'select',
      '#title' => t('India States'),
      '#options' => array('TN' => 'TN', 'KA' => 'KA'),
      '#states' => array(
        'visible' => array(
          ':input[name="country"]' => array('value' => 'India'),
        ),
      )
    ];
    $form ['uk-states'] = [
      '#type' => 'select',
      '#title' => t('UK States'),
      '#options' => array('London' => 'London'),
      '#states' => array(
        'visible' => array(
          ':input[name="country"]' => array('value' => 'UK'),
        ),
      )
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Submit')
    ];

    return $form;
  }

public function validateForm(array &$form, FormStateInterface $form_state) {

	if(strlen($form_state->getValue('demo_textfield')) < 5) {
		$message = 'Please enter minimum 5 characters';
		$form_state->setErrorByName('demo_textfield', $message);
	}
}
public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->messenger()->addMessage(
      $this->t('Form submitted successfully.')
    );
}

}