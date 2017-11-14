<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DictionaryEntryRepository")
 * @ORM\Table(name="dictionary_entries",indexes={@Index(name="reading_idx", columns={"reading"}),@Index(name="kanji_idx", columns={"kanji"})})
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
     * @ORM\Column(type="string", name="kanji")
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