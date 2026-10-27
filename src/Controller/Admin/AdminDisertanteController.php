<?php

namespace App\Controller\Admin;

use App\Entity\Disertante;
use App\Form\DisertanteType;
use App\Repository\DisertanteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/disertante')]
class AdminDisertanteController extends AbstractAdminBaseController
{

//LISTAR DISERTANTE
    #[Route(
        '/listar',
        name: 'admin_disertante_listar'
    )]

    public function listar(
        DisertanteRepository $disertanteRepository
    ): Response
    {
    $disertantes = $disertanteRepository->findDisertantesAlfabeticamente();

    
        return $this->render(
            'admin/disertante/listar.html.twig', 
            [
                'disertantes' => $disertantes
            ]

        );
    }

    //BORARR
/* 
    #[Route(
        '/borrar/{id}',
        name: 'admin_disertante_borrar',
        requirements: ['id' => '\d+']
    )]
    public function borrar(
        int $id,
        DisertanteRepository $disertanteRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $disertante = $disertanteRepository->find($id);

        if (!$disertante) {
            throw $this->createNotFoundException(
                'No existe el disertante solicitado.'
            );
        }

        $entityManager->remove($disertante);

        $entityManager->flush();

    $this->addSuccessMessage(
    sprintf(
        "El disertante '%s' se ha borrado correctamente.",
        $disertante->getNombreCompleto()
    )
    );

    
     return $this->redirectToAdmin();

    } */

    #[Route(
    '/detalle/{id}',
    name: 'admin_disertante_detalles'
    )]
    public function disertante(
        int $id,
        DisertanteRepository $repository
    ): Response
    {
    $disertante = $repository->find($id);

    if (!$disertante) {
        throw $this->createNotFoundException(
            'No existe el disertante solicitado'
        );
    }

    return $this->render(
        'admin/disertante/detalles.html.twig',
        [
            'disertante' => $disertante
        ]
    );
    }


}

/* 
    #[Route('/{id}/edit', name: 'app_admin_disertante_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Disertante $disertante, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DisertanteType::class, $disertante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_disertante_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_disertante/edit.html.twig', [
            'disertante' => $disertante,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_disertante_delete', methods: ['POST'])]
    public function delete(Request $request, Disertante $disertante, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$disertante->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($disertante);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_disertante_index', [], Response::HTTP_SEE_OTHER);
    }
}
 */