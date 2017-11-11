<?php

namespace DictionaryBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DictionaryEntryRepository extends EntityRepository
{
    private $base = 'SELECT e FROM DictionaryBundle:DictionaryEntry e WHERE';
    private $results;
    private $limit;
    private $query;
    
    public function findBySearchQuery($query, $limit=1, $offset=0)
    {
        $this->results = [];
        $this->limit = $limit;
        $this->query = $query;
        
        foreach($this->determineApproaches($query) as $approach)
        {
            $this->results = array_merge(
                    $this->results, $this->$approach[0]($approach[1]));
            
            if(count($this->results) >= $this->limit) break;
        }
        return $this->results;
    }
    
    private function determineApproaches($query)
    {
        $approaches = [];
        if(preg_match("/^[ a-zA-Z]+$/", $query))
        {
            $approaches[] = ['containsMatches', 'e.meanings'];
        } 
        elseif(preg_match("/^[ぁ-ヺ]+$/", $query)) 
        {
            $approaches[] = ['exactMatches','e.reading'];
            $approaches[] = ['startsWithMatches','e.reading'];
        } 
        else 
        {
            $approaches[] = ['exactMatches','e.kanji'];
            $approaches[] = ['startsWithMatches','e.kanji'];
        }
      
        return $approaches;
    }
    
    private function exactMatches($field)
    {
        return $this->getEntityManager()->createQuery(
            $this->base." ".$field." = :value")
                ->setParameter("value", $this->query)
                ->setMaxResults($this->residualResultLimit())
                ->getResult();
    }
    
    private function startsWithMatches($field)
    {
        return $this->getEntityManager()->createQuery(
                $this->base." ".$field." != :exactValue AND ".$field." LIKE :value")
                    ->setParameter("exactValue",$this->query)
                    ->setParameter("value", $this->query."%")
                    ->setMaxResults($this->residualResultLimit())
                    ->getResult();
    }
    
    private function endsWithMatches($field)
    {
        return $this->getEntityManager()->createQuery(
                $this->base." ".$field." != :exactValue AND ".$field." LIKE :value")
                    ->setParameter("exactValue",$this->query)
                    ->setParameter("value", "%".$this->query)
                    ->setMaxResults($this->residualResultLimit())
                    ->getResult();
    }
    
    private function containsMatches($field)
    {
        return $this->getEntityManager()->createQuery(
                $this->base." ".$field." != :exactValue AND ".$field." LIKE :value")
                    ->setParameter("exactValue",$this->query)
                    ->setParameter("value", "%".$this->query."%")
                    ->setMaxResults($this->residualResultLimit())
                    ->getResult();
    }
    
    private function residualResultLimit()
    {
        return $this->limit - count($this->results);
    }
    

}