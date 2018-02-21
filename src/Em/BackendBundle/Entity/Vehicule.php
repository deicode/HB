<?php

namespace Em\BackendBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vehicule
 */
class Vehicule
{
    /**
     * @var int
     */
    private $id;

    /**
     * @Assert\NotNull()
     *  @var string
     */
    private $libelle;


}
