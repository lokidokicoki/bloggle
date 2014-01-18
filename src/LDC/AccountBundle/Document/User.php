<?php
namespace LDC\AccountBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;


/**
 * @MongoDB\Document(collection="users")
 * @MongoDBUnique(fields="email")
 */
class User 
{
	/**
	 * @MongoDB\Id
	 */
	protected $id;
	/**
	 * @MongoDB\String
	 * @Assert\NotBlank()
	 */
	protected $username;
	/**
	 * @MongoDB\String
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 */
	protected $email;
	/**
	 * @MongoDB\String
	 */
	protected $firstname;
	/**
	 * @MongoDB\String
	 */
	protected $lastname;
	/**
	 * @MongoDB\String
	 * @Assert\NotBlank()
	 */
	protected $password;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get username
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string $firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string $lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password)
    {
		// nt very safe encryption, poss. use sha512?
        $this->password = sha1($password);
        return $this;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }
}
?>
