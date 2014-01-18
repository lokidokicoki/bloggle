<?php
namespace LDC\AccountBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;


/**
 * @MongoDB\Document(collection="users")
 * @MongoDBUnique(fields="email")
 */
class User implements UserInterface, EquatableInterface
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
	 * @MongoDB\Index(unique=true, order="asc")
	 */
	protected $email;

	/**
	 * @MongoDB\String
	 */
	protected $salt;

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
	 * @MongoDB\Collection
	 */
	protected $roles;

	public function __construct(){
		$this->salt = "";
		$this->roles=array('ROLE_USER');
	}
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
     * Get salt
     *
	 * @inheritDoc
     * @return string $salt
     */
    public function getSalt()
    {
        return $this->salt;
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
	 * @inheritDoc
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
	 * @inheritDoc
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

	/**
	 * @inheritDoc
	 */
	public function getRoles(){
		return $this->roles;
	}

	/**
	 * @inheritDoc
	 */
	public function eraseCredentials() {
	}

	/**
	 * @inheritDoc
	 */
	public function isEqualTo(UserInterface $user)
    {
        return $user->getUsername() === $this->username;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return self
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * Set roles
     *
     * @param collection $roles
     * @return self
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }
}
