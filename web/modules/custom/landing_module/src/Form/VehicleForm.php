<?php

namespace Drupal\landing_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class VehicleForm extends FormBase {

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('session'),
        );
    }

    public function getFormId()
    {
        return 'vehicle_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['#attributes']['class'][] = 'form-container form-placa-container';
        $form['#attributes']['novalidate'][] = 'true';
        $form['vehicle_plate'] =
            [
                '#type' => 'textfield',
                '#title' => 'Placa',
                '#size' => 60,
                '#maxlength' => 7,
                '#minlength' => 7,
                '#required' => true,
                '#pattern' => '[A-Za-z-À-ž]{3}[0-9]{3}',
                '#attributes' =>  [
                    'class' => ['form-container__input__input'],
                    'placeholder' => ['HJK123']
                ],
            ];

        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => 'Continuar',
            '#attributes' => [
                'class' => ['primary-button']
            ]
        ];

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        if(strlen($form_state->getValue('vehicle_plate')) < 5 ) {
            $form_state->setErrorByName('vehicle_plate', 'La placa debe contener al menos 6 caracteres');
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $plate = $form_state->getValue('vehicle_plate');
        $this->session->set('vehicle_plate', $plate);
        header("Location: /person/identification");
        exit();
    }
}