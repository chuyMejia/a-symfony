<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Animal;

class AnimalController extends AbstractController
{
    /**
     * @Route("/animal", name="app_animal")
     */
    public function index(): Response
    {

          //load repository

          

          $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
          //cosulta
          $animales = $animal_repo->findAll();

          $animal = $animal_repo->findBy(
            //TODOSL REGISTROS QUE COINCIDAN  findBy    SOLO UN REGISTRO findOneBy
            ['tipo' => 'pollo2'], // Criterios de búsqueda
            ['id' => 'ASC']       // Opcional: Array de ordenación
        );

          var_dump($animal);

          //return new Response('data saved if:');
  
        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController','animales'=>$animales
        ]);
    }

    public function save(){
        //guardar en tabla

        $entityManager = $this->getDoctrine()->getManager();

        $animal = new Animal();
        $animal->setTipo('pollo');
        $animal->setColor('blanco');
        $animal->setRaza('pilgrims');
        $animal->setTamano('grande');
        


        //guardar objeto en doctrine

        $entityManager->persist($animal);

        //volcar datos en la tbla


        $entityManager->flush();

        echo "<h1>ghghgjj</h1>";
        return new Response('data saved if:'.$animal->getId());

    }


    //public function animal(Animal $animal){
        public function animal($id){

        //load repository

        $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
        //cosulta
        $animal = $animal_repo->find($id);

        //cpmprapbar result

        if(!$animal){
            $mensaje = 'not found';
        }else{
            $mensaje = 'animal:'.$animal->getTipo();
        }
   

        return new Response('hi from action animal:'.$mensaje);

    }

    public function update($id){
        //cargar doctrine
//66252846113

        //cargar entity manager 

    }

}
