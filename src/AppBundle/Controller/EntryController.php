<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Entry;
use AppBundle\Entity\EntryTag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Form\EntryType;


class EntryController extends Controller
{
    private $session;

    public function __construct(){
        $this->session = new Session();
    }
    public function indexAction($page){
        $em = $this->getDoctrine()->getEntityManager();
        $entry_repo=$em->getRepository("AppBundle:Entry");
        $category_repo=$em->getRepository("AppBundle:Category");

        $categories=$category_repo->findAll();

        $pageSize = 5;
        $entries=$entry_repo->getPaginateEntries($pageSize,$page);

        $totalItems = count($entries);
        $pagesCount = ceil($totalItems/$pageSize);


        return $this->render("AppBundle:Entry:index.html.twig",array(
            "entries" => $entries,
            "categories" => $categories,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount,
            "page" => $page,
            "page_m" => $page
    ));
    }
    public function addAction(Request $request){
        $entry = new Entry();
        $form = $this->createForm(EntryType::class, $entry);

        $form->handleRequest($request);

        if($form->isSubmitted()){
             if($form->isValid()){

                 $em = $this->getDoctrine()->getEntityManager();
                 $category_repo=$em->getRepository("AppBundle:Category");
                 $entry_repo=$em->getRepository("AppBundle:Entry");
                 $entry = new Entry();
                 $entry->setTitle($form->get("title")->getData() );
                 $entry->setContent($form->get("content")->getData() );
                 $entry->setStatus($form->get("status")->getData() );

                 // Upload file
                 $file=$form["image"]->getData();
                 if(!empty($file) && $file != null){
                 $ext=$file->guessExtension();
                 $file_name=time().".".$ext;
                 $file->move("uploads",$file_name);
                 $entry->setImage($file_name);
                 }else{
                     $entry->setImage(null);
                 }
                 $category = $category_repo->find($form->get("category")->getData());
                 $entry->setCategory($category);
                 $user=$this->getUser();
                 $entry->setUser($user);

                 $em->persist($entry);
                 $flush = $em -> flush();
                 $entry_repo->saveEntryTags(
                     $form->get("tags")->getData(),
                     $form->get("title")->getData(),
                     $category,
                     $user
                 );
                 if($flush == null){
                     $status = "La entrada se ha creado correctamente";
                 }else{
                     $status = "Error al añadir la entrada!!!";
                 }

             }else{
            $status = "La entrada no se ha creado, porque el formulario no es valido";
            }
        $this->session->getFlashBag()->add("status",$status);
        return $this->redirectToRoute("blog_homepage");
        }
    return $this->render("AppBundle:Entry:add.html.twig",array(
        "form" => $form->CreateView()
    ));
    }
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entry_repo = $em->getRepository("AppBundle:Entry");
        $entry_tag_repo = $em->getRepository("AppBundle:EntryTag");

        $entry = $entry_repo->find($id);

        $entry_tags=$entry_tag_repo->findBy(array("entry"=>$entry));
        foreach ($entry_tags as $et) {
            $em->remove($et);
            $em->flush();
        }
        $em->remove($entry);
        $em->flush();
        return $this->redirectToRoute("blog_homepage");
    }
    public function editAction(Request $request,$id){
        $em = $this->getDoctrine()->getEntityManager();
        $entry_repo = $em->getRepository("AppBundle:Entry");
        $category_repo = $em->getRepository("AppBundle:Category");

        $entry=$entry_repo->find($id);
        $entry_image=$entry->getImage();
        $tags="";
        foreach ($entry->getEntryTag() as $entryTag){
            $tags.=$entryTag->getTag()->getName(). ", ";

        }
        $form = $this->createForm(EntryType::class,$entry);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $category_repo = $em->getRepository("AppBundle:Category");
                $entry_repo = $em->getRepository("AppBundle:Entry");

                $entry->setTitle($form->get("title")->getData());
                $entry->setContent($form->get("content")->getData());
                $entry->setStatus($form->get("status")->getData());

                // Upload file
                $file = $form["image"]->getData();
                if(!empty($file) && $file != null) {
                    $ext = $file->guessExtension();
                    $file_name = time() . "." . $ext;
                    $file->move("uploads", $file_name);
                    $entry->setImage($file_name);
                }else{
                        $entry->setImage($entry_image);
                }

                $category = $category_repo->find($form->get("category")->getData());
                $entry->setCategory($category);
                $user = $this->getUser();
                $entry->setUser($user);

                $em->persist($entry);
                $flush = $em->flush();

                $entry_tag_repo = $em->getRepository("AppBundle:EntryTag");
                $entry_tags=$entry_tag_repo->findBy(array("entry"=>$entry));
                foreach ($entry_tags as $et) {
                    $em->remove($et);
                    $em->flush();
                }
                $entry_repo->saveEntryTags(
                    $form->get("tags")->getData(),
                    $form->get("title")->getData(),
                    $category,
                    $user
                );
                if ($flush == null) {
                    $status = "La entrada se ha editado correctamente";
                } else {
                    $status = "Error al editar la entrada!!!";
                }
            }else {
                $status = "El formulario no es valido";
            }
            $this->session->getFlashBag()->add("status",$status);
            return $this->redirectToRoute("blog_homepage");
        }
        return $this->render("AppBundle:Entry:edit.html.twig",array(
            "form" => $form->CreateView(),
            "entry" => $entry,
            "tags" => $tags
        ));
    }
}

