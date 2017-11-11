<?php

namespace DictionaryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use \DictionaryBundle\Entity\DictionaryEntry;

class DefaultController extends Controller
{
    
    /**
     * @Route("/dictionary/search_post", name="dictionary_search_post")
     */
    public function searchPosAction()
    {
        // TODO: Fetch post data through the framework.
        if(
            !isset($_POST) || 
            !isset($_POST['form']) || 
            !isset($_POST['form']['Search'])
        ){
            throw $this->createNotFoundException("No search query given.");
        }
        $query = $_POST['form']['Search'];
        return $this->redirectToRoute('dictionary_search', ['query'=>$query]);
    }
    
    /**
     * @Route("/dictionary/search/{query}", name="dictionary_search")
     */
    public function searchAction($query)
    {
        $entries = $this->repo()->findBySearchQuery($query, 20);
        return $this->showEntries($entries);
    }
    
    /**
     * @Route("/dictionary/id/{id}", name="dictionary_lookup_id", requirements={"id":"\d+"})
     */
    public function idLookupAction($id)
    {
        $entry = $this->repo()->find($id);
        return $this->showEntries([$entry]);
    }
    
     /**
     * @Route("/dictionary/word/{kanji}", name="dictionary_lookup_kanji")
     */
    public function wordLookupAction($kanji)
    {
        $entry = $this->repo()->findOneBy(["kanji"=>$kanji]);
        return $this->showEntries([$entry]);
    }
    
    private function repo()
    {
        return $this->getDoctrine()->getManager()->getRepository('DictionaryBundle:DictionaryEntry');
    }
    
    private function showEntries($entries)
    {
        if($entries === null){
            throw $this->createNotFoundException("Entry not found.");
        }
        
        return $this->render('DictionaryBundle:Search:lookup.html.twig', ['entries' => $entries]);
    }
}
