<?php

namespace Drupal\d8_routing_demo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;


class DIForm extends FormBase {
  protected $db;

  public function __construct(Connection $db){

    $this->db = $db;
  }

	public function getFormId() {
		return 'd8_routing_demo_di_form';
	}
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }
	public function buildForm(array $form, FormStateInterface $form_state) {
    $form ['first_name'] = [
      '#type' => 'textfield',
      '#title' => t('First Name'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    ];
    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => t('Last Name'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    ];
     

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Submit')
    ];

    return $form;
  }


public function submitForm(array &$form, FormStateInterface $form_state) {

   $result = $this->db->insert('d8_demo')
  ->fields([
    'first_name' => $form_state->getValue('first_name'),
    'last_name' => $form_state->getValue('last_name'),

  ])
  ->execute();

    $this->messenger()->addMessage(
      $this->t('Form submitted successfully.')
    );
}

}