<?php

namespace DictionaryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * @ORM\Entity(repositoryClass="DictionaryBundle\Repository\DictionaryEntryRepository")
 * @ORM\Table(name="dictionary_entries",indexes={@Index(name="reading_idx", columns={"reading"})})
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
    
    public function getId() {
        return $this->id;
    }

    public function getKanji() {
        return $this->kanji;
    }

    public function getReading() {
        return $this->reading;
    }

    public function getMeanings() {
        return $this->meanings;
    }
}