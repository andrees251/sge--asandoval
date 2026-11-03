<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Service\EventoDisponibilidadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EventoRepository;
use Symfony\Component\HttpFoundation\Request;

final class EventoController extends AbstractBaseController
{


    
#[Route('/eventos', name: 'app_eventos')]
public function eventos(
    Request $request,
    EventoRepository $repository,
    EventoDisponibilidadService $disponibilidadService
): Response {

    // Cantidad de eventos que se mostrarán por página
    $limite = 6;

    // Obtenemos el número de página desde la URL
    $pagina = max(1, $request->query->getInt('page', 1));

    // Contamos todos los eventos
    $totalEventos = $repository->contarEventos();

    // Calculamos cuántas páginas necesitamos
    $totalPaginas = max(1, (int) ceil($totalEventos / $limite));

    // Evitamos que se solicite una página inexistente
    $pagina = min($pagina, $totalPaginas);

    // Obtenemos solamente los eventos de la página actual
    $eventos = $repository->findEventosAlfabeticamente($pagina, $limite);

    return $this->render('evento/eventos.html.twig', [
        'eventos' => $eventos,
        'disponibilidadService' => $disponibilidadService,
        'paginaActual' => $pagina,
        'totalPaginas' => $totalPaginas
    ]);
}


    #[Route('/evento/{slug}', name: 'app_evento_detalle')]
    public function evento(
    Request $request,
    EventoRepository $repository
    
    ): Response
    {
    $slug = $request->attributes->get('slug');
    $evento = $repository->findOneBy([
        'slug' => $slug
    ]);

    if (!$evento) {
        throw $this->createNotFoundException(
            'No existe el evento solicitado'
        );
    }

    $this->addInfoMessage(
    sprintf(
        "Has leído sobre el evento '%s' a las %s.",
        $evento->getTitulo(),
        date('H:i:s')
    )
    );

    return $this->render('evento/evento.html.twig', [
        'evento' => $evento
    ]);
    }

    #[Route('/evento/{id}/disponibilidad', name: 'evento_disponibilidad')]
    public function disponibilidad(
        Evento $evento,
        EventoDisponibilidadService $disponibilidadService
    ): Response {
        $mensaje = $disponibilidadService
        ->obtenerMensaje($evento);

        return $this->render(
            'evento/disponibilidad.html.twig',
            [
                'evento' => $evento,
                'mensaje' => $mensaje,
            ]
        );
    }

}
