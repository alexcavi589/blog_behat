<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Form\CategoryType;


class CategoryController extends Controller
{
    private $session;

    public function __construct(){
        $this->session = new Session();
    }
    public function indexAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $category_repo = $em->getRepository("AppBundle:Category");
        $categories = $category_repo->findAll();

        return $this->render("AppBundle:Category:index.html.twig",array(
            "categories" => $categories
        ));
    }
    public function addAction(Request $request){
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted()){
             if($form->isValid()){

                 $em = $this->getDoctrine()->getEntityManager();

                 $category = new Category();
                 $category->setName($form->get("name")->getData());
                 $category->setDescription($form->get("description")->getData());
                 $em->persist($category);
                 $flush = $em->flush();

                 if($flush==null){
                     $status = "La categoria se ha creado correctamente";
                 }else{
                     $status = "Error al añadir categoria!!!";
                 }
             }else{
            $status = "La categoria no se ha creado, porque el formulario no es valido";
            }
        $this->session->getFlashBag()->add("status",$status);
        return $this->redirectToRoute("blog_index_category");
        }
    return $this->render("AppBundle:Category:add.html.twig",array(
        "form" => $form->CreateView()
    ));
    }
    public function deleteAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $category_repo = $em->getRepository("AppBundle:Category");
        $category = $category_repo->find($id);
        if (count($category->getEntries()) == 0) {
        $em->remove($category);
        $em->flush();
        }
        return $this->redirectToRoute("blog_index_category");
    }

    public function editAction(Request $request,$id){
        $em = $this->getDoctrine()->getEntityManager();
        $category_repo = $em->getRepository("AppBundle:Category");
        $category = $category_repo->find($id);

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if($form->isValid()){

                $category->setName($form->get("name")->getData());
                $category->setDescription($form->get("description")->getData());
                $em->persist($category);
                $flush = $em->flush();

                if($flush==null){
                    $status = "La categoria se ha editado correctamente";
                }else{
                    $status = "Error al editar la categoria!!!";
                }
            }else{
                $status = "La categoria no se ha editado correctamente, porque el formulario no es valido";
            }
            $this->session->getFlashBag()->add("status",$status);
            return $this->redirectToRoute("blog_index_category");
        }

        return $this->render("AppBundle:Category:edit.html.twig",array(
            "form" => $form->CreateView()
        ));
    }
    public function categoryAction($id,$page){
        $em = $this->getDoctrine()->getEntityManager();
        $category_repo = $em->getRepository("AppBundle:Category");
        $category = $category_repo->find($id);

        $entry_repo = $em->getRepository("AppBundle:Entry");
        $entries=$entry_repo->getCategoryEntries($category,5,$page);
        $totalItems = count($entries);
        $pagesCount = ceil($totalItems/5);

        return $this->render("AppBundle:Category:category.html.twig",array(
            "category" => $category,
            "categories" => $category_repo->findAll(),
            "entries" => $entries,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount,
            "page"=>$page,
            "page_m"=>$page,
        ));
    }
}