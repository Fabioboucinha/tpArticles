<?php

namespace App\Controller;

use App\Form\AdType;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'AdController',
        ]);
    }



    /**
     * @Route("/ads", name="ads_index")
     */
    public function ads(ArticleRepository $repo)
    {
        $ads = $repo->findAll();
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }

    /**
     * @Route("/admin", name="ads_admin")
     */
    public function admin(ArticleRepository $repo)
    {
        $ads = $repo->findAll();
        return $this->render('ad/administration.html.twig', [
            'ads' => $ads,
        ]);
    }

    /**
     * Undocumented function
     *
     *@Route("/delete/{id}", name="ads_delete")
     * 
     * @param ObjectManager $manager
     * @param Article $article
     * @return void
     */
    public function DeleteArticle(ObjectManager $manager,Article $article){

        $manager->remove($article);
        $manager->flush();
        $this->addFlash(
            'success',"l'annonce {$article->getLibelle()} a bien été supprimé"
        );

        return $this->redirect('/admin');

       }

       /**
     * Permet de créer une annonce
     *
     * @Route("/ads/new", name="ads_create")
     * 
     * @return void
     */

    public function create(Request $request,ObjectManager $manager)
    {
        $ad= new Article();
        $form = $this->createForm(AdType::class,$ad);
        $form->handleRequest($request);

      
        
        
        if($form->isSubmitted() && $form->isValid())
        {
           
            $manager->persist($ad);
            $manager->flush();
            $this->addFlash(
                'success',"l'annonce {$ad->getLibelle()} a bien été crée"
            );
            return $this->redirectToRoute('ads_show',[
                'id' => $ad->getId()
                
            ]);
        }
        return $this->render('ad/create.html.twig',
                ['form'=> $form->createView()]);
    }


    /**
     * Permet d'afficher une seule annonce
     *
     * @Route("/ads/{id}", name="ads_show")
     * 
     * @return Response
     */
    public function show(Article $ad){
        return $this->render('ad/show.html.twig',[
        'ad' => $ad]);
    }

 /**
     * Permet d'editer une annonce
     *
     * @Route("/admin/{id}/edit", name="admin_edit")
     * 
     * @return response
     */
    public function edit(Article $ad, Request $request, ObjectManager $manager){
        $form = $this->createForm(AdType::class,$ad);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
           
            $manager->persist($ad);
            $manager->flush();
            $this->addFlash(
                'success',"l'annonce {$ad->getLibelle()} a bien été modifié"
            );
            return $this->redirectToRoute('ads_show',[
                'id' => $ad->getId()
                
            ]);
        }
        return $this->render("ad/edit.html.twig",[
            'form'=>$form->createView(),
            'ad' => $ad
            ]);
    }
    
}
