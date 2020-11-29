<?php

namespace App\Controller;

use App\Entity\Ordinateur;
use App\Repository\OrdinateurRepository;
use JMS\Serializer\SerializerBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrdinateurController extends AbstractController
{

 /**
  * @Route("/ordinateurs/new", name="new", methods="POST")
  *
  */
 public function create(Request $request): Response
 {
  $data = json_decode($request->getContent(), true);
  $ordi = new Ordinateur();
  $ordi->setName($data['name']);
  $doctrine = $this->getDoctrine()->getManager();
  $doctrine->persist($ordi);
  $doctrine->flush();

  if ($doctrine) {
   return $this->json($ordi);
  } else {
   return $this->json('error');
  }

 }

 /**
  * @Route("/ordinateurs/get", name="ordi", methods={"POST"})
  */
 function list(OrdinateurRepository $ordinateurRepos, PaginatorInterface $paginator, Request $request): Response {
  $page = json_decode($request->getContent(), true);

  $ordi = $ordinateurRepos->findAll();

  $serializer = SerializerBuilder::create()->build();

  $ordinateurs = $paginator->paginate(
   $ordi, // Requête contenant les données à paginer (ici nos articles)
   $request->query->getInt('page', $page['page']), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
   3// Nombre de résultats par page
  );

  $jsonObject = $serializer->serialize($ordi, 'json');
  return new Response($jsonObject);
 }

 /**
  * @Route("/ordinateurs/{id}/delete", name="computer.delete", methods={"DELETE"})
  *
  * @throws JSendSpecificationViolation
  */
 public function delete(Request $request, OrdinateurRepository $ordinateurRepos)
 {
  $ordiID = $request->attributes->get('id');
  $ordi = $ordinateurRepos->findBy([
   'id' => $ordiID,
  ]);

  $entityManager = $this->getDoctrine()->getManager();

  if (isset($entityManager)) {
   $entityManager->remove($ordi[0]);
  }
  $entityManager->flush();

  $data = [$ordiID];
  return $this->json($data);
 }

}
