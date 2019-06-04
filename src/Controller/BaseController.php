<?php


namespace App\Controller;


use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Form\Form;

class BaseController extends AbstractFOSRestController
{
    /**
     * Parses the errors from the form to a more presentable way
     *
     * @param Form $form
     *
     * @return array
     */
    public function getErrorsMessages(Form $form): array
    {
        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        foreach ($form->all() as $child) {
            if ($child->isSubmitted() && !$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorsMessages($child);
            }
        }

        return $errors;
    }

}