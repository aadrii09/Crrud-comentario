<?php

namespace App\Controller;

use App\Entity\Comentario;
use App\Form\EntityFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ComentarioController extends AbstractController
{
//listar
    #[Route('/list', name: 'listar')]
    public function listarComentario(EntityManagerInterface $entityManagerInterface ): Response
    {

        $listaComentario=$entityManagerInterface->getRepository(Comentario::class)->findAll();
        
        $cuenta=count($listaComentario);

        return $this->render('comentario/index.html.twig', [
            'listaComentario'=>$listaComentario,
            'cuenta'=>$cuenta,
        ]);
    }
// crear
    #[Route('/comentario/crear', name: 'crear_comentario')]
    public function crear(Request $request , EntityManagerInterface $entityManagerInterface): Response
    {
        $crearComentario=new Comentario;
        $form=$this->createForm(EntityFormType::class, $crearComentario);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $entityManagerInterface->persist($crearComentario);
            $entityManagerInterface->flush();
            return $this->redirectToRoute("listar");
        }
        return $this->render('comentario/form.html.twig', [
            "form"=>$form->createView(),
        ]);
    }
//like
    #[Route('/review/upvote/{id}', name: 'like')]
public function like(Comentario $review, EntityManagerInterface $entityManager): Response
{
    $review->setNumPositivas($review->getNumPositivas() + 1);
    $entityManager->flush();

    return $this->redirectToRoute('listar');
}
//dislike
#[Route('/review/downvote/{id}', name: 'dislike')]
public function dislike(Comentario $review, EntityManagerInterface $entityManager): Response
{
    $review->setNumNegativas($review->getNumNegativas() + 1);
    $entityManager->flush();

    return $this->redirectToRoute('listar');
}


#[Route('/comentarios', name: 'comentarios_list')]
public function list(Request $request, EntityManagerInterface $em): Response
{
    $searchTerm = $request->query->get('busqueda');
    $queryBuilder = $em->getRepository(Comentario::class)->createQueryBuilder('c');

    if ($searchTerm) {
        $queryBuilder
            ->where('LOWER(c.nombreAutor) LIKE LOWER(:term)')
            ->orWhere('LOWER(c.texto) LIKE LOWER(:term)')
            ->setParameter('term', '%' . $searchTerm . '%');
    }

    $comentarios = $queryBuilder->getQuery()->getResult();

    return $this->render('comentario/list.html.twig', [
        'comentarios' => $comentarios,
        'searchTerm' => $searchTerm
    ]);
}
}
