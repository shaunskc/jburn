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
    public function searchPosAction(Request $request)
    {
        // This route is reached when searching via the search form.
        // The request is redirected so that the search appears in the url.
        $form = $this->createForm(\DictionaryBundle\Form\SearchFormType::class,
                null, ['router'=>$this->get('router')]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->redirectToRoute('dictionary_search', ['query'=>$data['query']]);   
        }
        throw $this->createNotFoundException("No search query given.");
    }
    
    /**
     * @Route("/dictionary/search/{query}", name="dictionary_search")
     */
    public function searchAction($query)
    {
        $entries = $this->repo()->findBySearchQuery($query, 20);
        return $this->showEntries($entries, $query);
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
        return $this->showEntries([$entry], $kanji);
    }
    
    private function repo()
    {
        return $this->getDoctrine()->getManager()->getRepository('DictionaryBundle:DictionaryEntry');
    }
    
    private function showEntries($entries, $query="")
    {
        if($entries === null){
            throw $this->createNotFoundException("Entry not found.");
        }
        
        $form = $this->createForm(\DictionaryBundle\Form\SearchFormType::class,
                null,
                ['router'=>$this->get('router')]);
        
        return $this->render('DictionaryBundle:Search:lookup.html.twig', [
            'entries' => $entries, 
            'dictionarySearchForm'=>$form->createView(), 
            'currentQuery'=>$query]);
    }
}
