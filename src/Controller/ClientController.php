<?php

namespace App\Controller;

use App\Entity\Attribution;
use App\Entity\Client;
use App\Entity\Ordinateur;
use App\Repository\AttributionRepository;
use App\Repository\ClientRepository;
use App\Repository\OrdinateurRepository;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
 /**
  * @Route("/clients/search", name="client", methods="GET")
  */
 public function index(ClientRepository $clientRepository)
 {
  $client = $clientRepository->findAll();
  $serializer = SerializerBuilder::create()->build();
  $jsonObject = $serializer->serialize($client, 'json');
  return new Response($jsonObject);

 }

 /**
  * @Route("/attributions/add", name="attribution", methods="POST")
  */
 public function add(OrdinateurRepository $ordinateurRepository, Request $request): Response
 {
  $data = json_decode($request->getContent(), true);
  $client = $this->getDoctrine()->getRepository(Client::class)->findOneBy(['name' => $data['id_client']]);
  $ordi = $this->getDoctrine()->getRepository(Ordinateur::class)->findOneBy(['id' => $data['id_ordinateur']]);

  $attribution = new Attribution();
  $attribution->setDate($data['date']);
  $attribution->setHour($data['horaire']);
  $attribution->setClient($client);
  $attribution->setOrdinateur($ordi);
  $doctrine = $this->getDoctrine()->getManager();
  $doctrine->persist($attribution);
  $doctrine->flush();
  $serializer = SerializerBuilder::create()->build();
  $jsonObject = $serializer->serialize($attribution, 'json');

  return new Response($jsonObject);

 }

 /**
  * @Route("/attributions/delete/{id}", name="del", methods="DELETE")
  * @throws JSendSpecificationViolation
  */
 public function delete(AttributionRepository $attributionRepository, Request $request): Response
 {
  $attributionID = $request->attributes->get('id');
  $attribution = $attributionRepository->findBy(['id' => $attributionID]);
  $entityManager = $this->getDoctrine()->getManager();

  if (isset($entityManager)) {
   $entityManager->remove($attribution[0]);
  }
  $entityManager->flush();

  $data = [$attributionID];
  return $this->json($data);

 }
}
