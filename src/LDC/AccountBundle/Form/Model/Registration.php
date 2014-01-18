<?php
// src/LDC/AccountBundle/Form/Model/Registration.php
namespace LDC\AccountBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use LDC\AccountBundle\Document\User;

class Registration
{
    /**
     * @Assert\Type(type="LDC\AccountBundle\Document\User")
     */
    protected $user;

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (boolean)$termsAccepted;
    }
}
