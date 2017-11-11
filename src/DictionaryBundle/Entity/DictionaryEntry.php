<?php

namespace DictionaryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dictionary_entries")
 */
class DictionaryEntry 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", name="kanji", unique=true)
     */
    private $kanji;
    
    /**
     * @ORM\Column(type="string", name="reading")
     */
    private $reading;
    
    /**
     * @ORM\Column(type="text", name="meanings")
     */
    private $meanings;
}