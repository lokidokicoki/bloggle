<?php
namespace LDC\BloggleBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;

/**
 * @MongoDB\Document
 * @MongoDBUnique(fields="title")
 */
class Blog
{
	/**
	 * @MongoDB\Id
	 */
	protected $id;

	/**
	 * @MongoDB\String
	 */
	protected $userid;

	/**
	 * @MongoDB\String
	 * @Assert\NotBlank()
	 */
	protected $title;

	/**
	 * @MongoDB\Collection
	 * @MongoDB\ReferenceMany(targetDocument="Post")
	 */
	protected $posts;

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
     * Set userid
     *
     * @param string $userid
     * @return self
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Get userid
     *
     * @return string $userid
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set posts
     *
     * @param collection $posts
     * @return self
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
        return $this;
    }

    /**
     * Get posts
     *
     * @return collection $posts
     */
    public function getPosts()
    {
        return $this->posts;
    }
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add post
     *
     * @param LDC\BloggleBundle\Document\Post $post
     */
    public function addPost(\LDC\BloggleBundle\Document\Post $post)
    {
        $this->posts[] = $post;
    }

    /**
     * Remove post
     *
     * @param LDC\BloggleBundle\Document\Post $post
     */
    public function removePost(\LDC\BloggleBundle\Document\Post $post)
    {
        $this->posts->removeElement($post);
    }
}
