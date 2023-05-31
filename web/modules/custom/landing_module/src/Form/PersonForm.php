<?php

namespace Drupal\landing_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PersonForm extends FormBase
{

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
        $documentTypes = [
            'C.C' => 'Cédula de Ciudadanía',
            'C.E' => 'Cédula de Extranjería',
        ];

        $genres = [
            'Femenino' => 'Femenino',
            'Masculino' => 'Masculino',
            'Otro' => 'Otro'
        ];

        $form['#attributes']['class'][] = 'form-container form-person-container';
        $form['#attributes']['novalidate'][] = 'true';
        $form['document_type'] = [
            '#type' => 'select',
            '#title' => 'Tipo de documento',
            '#options' => $documentTypes,
            '#required' => TRUE,
            '#attributes' =>  [
                'class' => ['form-container__input__input'],
            ],
        ];
        $form['document_number'] =
            [
                '#type' => 'textfield',
                '#title' => 'Número de documento',
                '#size' => 280,
                '#maxlength' => 280,
                '#minlength' => 3,
                '#required' => TRUE,
                '#pattern' => '^\d+(\.\d+)*$',
                '#attributes' =>  [
                    'class' => ['form-container__input__input'],
                ],
            ];

        $form['person_name'] =
            [
                '#type' => 'textfield',
                '#title' => 'Nombre Completo',
                '#size' => 280,
                '#maxlength' => 280,
                '#minlength' => 8,
                '#required' => TRUE,
                '#pattern' => '^[ a-zA-ZÀ-ÿ\u00f1\u00d1]*$',
                '#attributes' =>  [
                    'class' => ['form-container__input__input'],
                ],
            ];

        $form['person_age'] =
            [
                '#type' => 'textfield',
                '#title' => 'Edad',
                '#size' => 2,
                '#maxlength' => 2,
                '#minlength' => 2,
                '#required' => TRUE,
                '#pattern' => '^\d+(\.\d+)*$',
                '#attributes' =>  [
                    'class' => ['form-container__input__input'],
                ],
            ];

        $form['genre'] = [
            '#type' => 'select',
            '#title' => 'Género',
            '#options' => $genres,
            '#required' => TRUE,
            '#attributes' =>  [
                'class' => ['form-container__input__input'],
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
        if (strlen($form_state->getValue('document_number')) < 5) {
            $form_state->setErrorByName('document_number', 'El número de documento debe contener mínimo 5 números');
        }

        if (strlen($form_state->getValue('person_name')) < 5) {
            $form_state->setErrorByName('person_name', 'El nombre debe contener al menos 8 caracteres');
        }

        if ($form_state->getValue('person_age') < 18) {
            $form_state->setErrorByName('person_age', 'Debes ser mayor de edad para cotizar un seguro con nosotros.');
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $person_info = [];
        $person_info[] = $this->session->get('vehicle_plate', []);
        $person_info[] = $form_state->getValue('document_type');
        $person_info[] = $form_state->getValue('document_number');
        $person_info[] = $form_state->getValue('person_name');
        $person_info[] = $form_state->getValue('person_age');
        $person_info[] = $form_state->getValue('genre');
        
        $this->session->set('person_info', $person_info);
        dpm($person_info);
        header("Location: /resume");
        exit();
    }
}
