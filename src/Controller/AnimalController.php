<?php

namespace App\Controller;

use App\Entity\Animal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use Doctrine\ORM\EntityManagerInterface;

use App\Form\AnimalType;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Email;



class AnimalController extends AbstractController
{



    public function validarEmail($email){

       $validator = Validation::createValidator();
       $errores = $validator->validate($email,[
            new Email()
       ]);

       if(count($errores) != 0){

        echo "data no valid (email)";

        foreach($errores as $error )
        echo '<br>'.$error->getMessage().'<br>';

       }else{
        echo 'email is correct';
       }


        die();



    }

    public function crearAnimal(Request $request) {
        // Crear un nuevo objeto Animal
        $animal = new Animal();
    
        // Crear el formulario utilizando AnimalType y el objeto Animal
        $form = $this->createForm(AnimalType::class, $animal);
    
        // Manejar la solicitud HTTP
        $form->handleRequest($request);
    
        // Verificar si el formulario ha sido enviado y es válido
        if ($form->isSubmitted() && $form->isValid()) {
            // Persistir el objeto Animal en la base de datos
            $em = $this->getDoctrine()->getManager();
            $em->persist($animal);
            $em->flush();
    
            // Crear y mostrar un mensaje flash
            $this->addFlash('mensaje', 'Registro correcto');
    
            // Redirigir a la ruta 'crear_animal' (ajusta según tu configuración de rutas)
            return $this->redirectToRoute('crear_animal');
        }
    
        // Renderizar la plantilla de creación de animal con el formulario
        return $this->render('animal/crear-animal.html.twig', [
            'form' => $form->createView(),
        ]);
    }




    /**
     * @Route("/animal", name="app_animal")
     */
    public function index(): Response
    {

          //load repository

          $em = $this->getDoctrine()->getManager();

          

          $animal_repo = $this->getDoctrine()->getRepository(Animal::class);
          //cosulta
          $animales = $animal_repo->findAll();

          $animal = $animal_repo->findBy(
            //TODOSL REGISTROS QUE COINCIDAN  findBy    SOLO UN REGISTRO findOneBy
            ['tipo' => 'pollo2'], // Criterios de búsqueda
            ['id' => 'ASC']       // Opcional: Array de ordenación
        );

          // QUERY BUILDER CON SYMFONY
        $qb = $animal_repo->createQueryBuilder('a')
            ->andWhere('a.tipo = :tipo')
            ->setParameter('tipo', 'gato')
            ->orderBy('a.id','ASC')
            ->getQuery();
        $resultset = $qb->getResult();






        // Puedes utilizar var_dump para depurar (aunque no es recomendado en producción)
         


            //DQL
            $dql="select a from App\Entity\Animal a where a.tipo = 'gato' ";
            $query =$em->createQuery($dql);
            $resultset = $query->execute();
            //var_dump($resultset);


            //Consultas SQL

            $conn = $this->getDoctrine()->getConnection();
            $sql = 'SELECT * FROM animales ORDER BY  id DESC';
            $prepare = $conn->prepare($sql);
            $prepare->execute();
            $resultset = $prepare->fetchAll();
            var_dump($resultset);


        //repositorio

        $animals = $animal_repo->getAnimalsOrderId('DESC');
        var_dump($animals);



         
  
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


    public function save235(Request $request){

      // var_dump($request->get('form')); 
       



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

    public function update(int $id, EntityManagerInterface $em): Response
    {
        // Cargar el repositorio de Animal
        $animalRepo = $em->getRepository(Animal::class);

        // Buscar el animal por ID
        $animal = $animalRepo->find($id);

        // Verificar si el animal fue encontrado
        if (!$animal) {
            $mensaje = 'El animal no existe';
        } else {
            // Actualizar los valores del animal
            $animal->setTipo('Perro_ ' . $id);
            $animal->setColor('verde');
            $animal->setRaza('verde');
            $animal->setTamano('verde');

            // Persistir y guardar los cambios
            $em->flush();

            $mensaje = 'Dato actualizado: ' . $animal->getTipo() . ' con ID: ' . $animal->getId();
        }

        return new Response($mensaje);
    }

    /**
     * @Route("/animal/delete/{id}", name="animal_delete")
     */
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        // Cargar el repositorio de Animal
        $animalRepo = $em->getRepository(Animal::class);

        // Buscar el animal por ID
        $animal = $animalRepo->find($id);

        // Verificar si el animal fue encontrado
        if ($animal) {
            // Eliminar el animal
            $em->remove($animal);
            $em->flush();

            $mensaje = 'Animal borrado correctamente';
        } else {
            $mensaje = 'Animal no borrado, no se encontró el animal';
        }

        return new Response($mensaje);
    }

}