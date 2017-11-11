<?php

namespace DictionaryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/dictionary/id/{id}", name="dictionary_lookup_id", requirements={"id":"\d+"})
     */
    public function idLookupAction($id)
    {
        return $this->render('DictionaryBundle:Search:lookup.html.twig', ['id' => $id]);
    }
}
