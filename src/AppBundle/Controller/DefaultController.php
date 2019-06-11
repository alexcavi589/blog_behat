<?php

namespace AppBundle\Controller;

//use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function old() {

        
          $em = $this->getDoctrine()->getEntityManager();
          $entry_repo = $em->getRepository("AppBundle:Entry");
          $entries = $entry_repo->findAll();

          foreach ($entries as $entry) {
          echo $entry->getTitle() . "<br/>";
          echo $entry->getCategory()->getName() . "<br/>";
          echo $entry->getUser()->getName() . "<br/>";

          $tags = $entry->getEntryTag();
          foreach ($tags as $tag) {
          echo $tag->getTag()->getName().", ";
          }
          echo "<hr>";
          }
          
          $em = $this->getDoctrine()->getEntityManager();
          $category_repo = $em->getRepository("AppBundle:Category");
          $categories = $category_repo->findAll();

          foreach ($categories as $category) {
          echo $category->getName() . "<br/>";


          $entries = $category->getEntries();
          foreach ($entries as $entry) {
          echo $entry->getTitle();
          }
          echo "<hr>";
          }

          $em = $this->getDoctrine()->getEntityManager();
          $tag_repo = $em->getRepository("AppBundle:Tag");
          $tags = $tag_repo->findAll();

          foreach ($tags as $tag) {
          echo $tag->getName(). "<br/>";


          $entryTag = $tag->getEntryTag();

          foreach ($entryTag as $entry) {
          echo $entry->getEntry()->getTitle().", ";
          }
          echo "<hr/>";
          }
          die();
         
        return $this->render('AppBundle:Default:index.html.twig');
    }

    public function indexAction() {

        
        return $this->render('AppBundle:Default:index.html.twig');
    }
    public function langAction(Request $request){
        return $this->redirectToRoute("blog_homepage");
    }
}
