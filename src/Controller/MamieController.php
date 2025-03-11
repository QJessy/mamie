<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\AjoutCafeType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cafe;
use Doctrine\ORM\EntityManagerInterface;

final class MamieController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('mamie/index.html.twig', [
        ]);
    }

    #[Route('/ajout_cafe', name: 'app_ajout_cafe')]
    public function ajoutCafe(Request $request, EntityManagerInterface $em): Response
    {
        $cafe = new Cafe();
        $form = $this->createForm(ajoutCafeType::class, $cafe);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em->persist($cafe);
                $em->flush();
                $this->addFlash('notice','Café ajouté avec succés');
                return $this->redirectToRoute('app_ajout_cafe');
            }
        }

        return $this->render('mamie/ajout_cafe.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
