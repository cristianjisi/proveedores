<?php

namespace App\Controller;

use App\Entity\Proveedores;
use App\Form\ProveedoresType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ProveedoresController extends AbstractController
{
    #[Route('/', name: 'app_proveedores')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $data = $this->$doctrine->getRepository(Proveedores::class)->findAll();
        return $this->render('proveedores/index.html.twig', [
            'lista' => '$data',
        ]);
    }
    /**
     * @Route("create", name="create")
     */
    public function create(Request $request, ManagerRegistry $doctrine)
    {
        $prov = new Proveedores();
        $form = $this->createForm(ProveedoresType::class, $prov);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($prov);
            $em->flush();

            $this->addFlash('notice','Enviado!');

            return $this->redirectToRoute('app_proveedores');
        }
        return $this->render('proveedores/create.html.twig', [
                'form' => $form->createView()
        ]);
    }
}
