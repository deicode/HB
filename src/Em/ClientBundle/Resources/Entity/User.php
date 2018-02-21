<?php

namespace Em\ClientBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
//use FOS\MessageBundle\Model\ParticipantInterface;

use FOS\UserBundle\Model\User as BaseUser;


/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Em\ClientBundle\Entity\UserRepository")
 */

class User extends BaseUser
{
/**
* @var integer
*
* @ORM\Column(name="id", type="integer")
* @ORM\Id
* @ORM\GeneratedValue(strategy="AUTO")
*/
protected $id;


    /**
    * Get id
    *
    * @return integer
    */
    public function getId()
    {
    return $this->id;
    }
}