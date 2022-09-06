<?php

namespace App\Controller\Libros;

use App\Entity\Libros\paises;
use App\Entity\Libros\autores;
use App\Entity\Libros\editoriales;
use App\Entity\Libros\libros;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\Libros\autoresRepository;
use App\Repository\Libros\editorialesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; //Boton submit
use Symfony\Bridge\Doctrine\Form\Type\EntityType; //Selector de entidad
use Knp\Component\Pager\PaginatorInterface; //KNP Paginator


class librosController extends AbstractController
{
    private $bd; //Construccion de variables de clase
    public function __construct(EntityManagerInterface $em)
    {
        $this->bd = $em; //Para llamar una variable de clase utilizo $this->nombreVar;
    }

    // Creacion del formulario de busqueda o la cabecera
    public function formBusqLib(Request $request, $tipoFrm = 0)
    {

        // obtiene de la base de datos informacion, 
        // *si identifica el id del formulario y pais para tratarlo 
        $bd = $this->bd; //Variables de metodo (funcion)
        if (!empty($request->request->get('form')['pais'])) {
            $idPais = $request->request->get('form')['pais'];
            $paisObject = $bd->getRepository(paises::class)->find($idPais);
        } else {
            // manda el objeto vacio
            $idPais = null;
            $paisObject = null;
        }

        // Creacion estructura selector pais 
        // *Crea un selector como clase llamado pais
        $form = $this->createFormBuilder(null, array('method' => 'GET' , 'action'=>$this->generateUrl('libros_frame_lib')))
            ->add('pais', EntityType::class, array(
                'class' => paises::class,
                'choice_value' => 'id',
                'choice_label' => 'pais',
                'placeholder' => 'Seleccione pais',
                'label' => 'pais',
                'required' => false,
                // obtiene el dato o id de cada pais
                'data' => $paisObject
            ))

            // Creacion estructura selector autores
            // *Crea un selector como clase llamado autor
            ->add('autor', EntityType::class, array(
                'class' => autores::class,
                'choice_value' => 'id',
                // Funcion de escoger autor con el nombre y apellido
                'choice_label' => function (autores $entity) {
                    return $entity ? $entity->getNombre() . " " . $entity->getApellido() : '';
                },
                'placeholder' => 'Seleccione Autor',
                'label' => 'Autor',
                'required' => false,
                'query_builder' => function (autoresRepository $er) use ($idPais) {
                    return $er->createQueryBuilder('autor')
                        ->Join('autor.pais', 'autores')
                        ->Where('autores.id = :vrBuscado')
                        ->setParameter(':vrBuscado', $idPais)
                        ->orderBy('autor.nombre', 'ASC');
                },
            ))

            // Creacion estructura selector editoriale
            // *Crea un selector como clase llamado editorial
            ->add('editorial', EntityType::class, array(
                'class' => editoriales::class,
                'choice_value' => 'id',
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione Editorial',
                'label' => 'Editorial',
                'required' => false,
                // relacion que hace entre las entidades
                'query_builder' => function (editorialesRepository $er) use ($idPais) {
                    return $er->createQueryBuilder('editorial')
                        // join es una relacion desde las restrinciones que se hicieron
                        ->Join('editorial.pais', 'editoriales')
                        ->Where('editoriales.id = :vrBuscado')
                        ->setParameter(':vrBuscado', $idPais)
                        ->orderBy('editorial.nombre', 'ASC');
                },
            ))

            // Creacion estructura selector editoriale
            // *Crea un boton como clase llamado buscar
            ->add('Buscar', SubmitType::class, ['label'=>'<i class="fa-solid fa-magnifying-glass"></i> Buscar', 'label_html' => true]);

        if ($tipoFrm == 1) {
            // genera el formulario normal
            return $form->getForm();
        } else {
            // si es diferente envia el nuevo formulario
            return $this->renderForm('Libros\Libros\formBusqLibros.html.twig', array('form' => $form->getForm()));
        }
    }

    // Creacion del formulario de listar libros en el frame de turbo-funciona con turbo y stimulus
    public function listarLibros(Request $request, PaginatorInterface $paginator)
    {

        if(!empty($request->query->get('form')['pais'])){  // vairables que trae el reques siempre es form y hay lo que queremos
            $idPais=$request->query->get('form')['pais'];
        }
        else{
            $idPais=null;
        }
        if(!empty($request->query->get('form')['autor'])){
            $idAutor=$request->query->get('form')['autor'];
        }
        else{
            $idAutor=null;
        }
        if(!empty($request->query->get('form')['editorial'])){
            $idEditorial=$request->query->get('form')['editorial'];
        }
        else{
            $idEditorial=null;
        }
        $ListaLib=$this->bd->getRepository(libros::class)->findLib($idPais,$idAutor,$idEditorial);
        $pagination = $paginator->paginate($ListaLib, $request->query->getInt('page', 1), 10);        
        //return $this->render('Libros\Libros\framelistaLib.html.twig',['libros'=>$ListaLib]);
        return $this->render('Libros\Libros\framelistaLib.html.twig',['libros'=>$pagination]);
        // $ListaLib = $this->bd->getRepository(libros::class)->findAll();
        // return $this->render('Libros\Libros\framelistaLib.html.twig', ['libros' => $ListaLib]);
    }

    //Creacion del metodo guardar estudiante 
    public function guardarLib(Request $request, $idLibro = 0){ //// se crea la bandera para crear el editar
        
        if($idLibro!=0){
            $libros = $this->bd->getRepository(libros::class)->find($idLibro);
        }
        else{
            $libros = new libros();
        }
        $FORMA = $this->createForm(\App\Form\Libros\librosType::class, 
        $libros, array('method' => 'POST',
        'action' => $this->generateUrl('libros_guardar_lib',['idLibro'=>$idLibro])));
        $FORMA->handleRequest($request);
        if($FORMA->isValid()){
            if($idLibro==0){
            $this->bd->persist($libros);
            $this->bd->flush(); //esto va de ultimo para poder hacer los cambios
            return $this->redirectToRoute('libros_frame_lib');
            }
            else{
                $this->bd->flush();
                return $this->redirectToRoute('libros_ver_lib',['id'=>$idLibro]);
            }

        }
    }


    // Retornar el formulario a la vista
    public function bienvenida(Request $request)
    {
        $formLibros = $this->formBusqLib($request, 1);
        $libros = new libros();

        $FORMA = $this->createForm(\App\Form\Libros\librosType::class, 
        $libros, array('method' => 'POST',
        'action' => $this->generateUrl('libros_guardar_lib',['idLibro'=>0]))); //// hay que enviarle in valor a la variable de la ruta

        return $this->render('Libros\Libros\ListaLibros.html.twig', 
        array('form' => $formLibros->createView(), 'nuevoLib'=>$FORMA->createView()));
    }


    /// Creacion de la vista de un libro mediante seting el ver
    public function verLibro($id){
        $libro= $this->bd->getRepository(libros::class)->find($id);
        $librov= $this->bd->getRepository(libros::class)->findediLib($id);
        // $promedioEstud = $this->bd->getRepository(estudiantes::class)->promedioEstud($id);

        $FORMA = $this->createForm(\App\Form\Libros\librosType::class,  
        $libro, array('method' => 'POST',
        'action' => $this->generateUrl('libros_guardar_lib',['idLibro'=>$id] )));

        return $this->render('Libros\Libros\verLibro.html.twig', 
        array('libro'=>$librov,
        'nuevoLib'=>$FORMA->createView() 
        ));

            // array('estudiante'=>$estudiante, 'promedio'=>$promedioEstud, 
            // 'nuevoEstud'=>$FORMA->createView() ));

}

public function eliminarLibro($id){
    try {
        $libro = $this->bd->getRepository(libros::class)->find($id);
        $this->bd->remove($libro);
        $this->bd->flush();
        $this->addFlash('mensaje', 'Registro eliminado correctamente!');
    } catch (\Doctrine\DBAL\Exception\ConstraintViolationException $e) {
        $this->addFlash('error', 'El registro no ha podido eliminarse!');
        return $this->redirectToRoute('libros_ver_lib',['id'=>$id]);
    }            
    return $this->redirectToRoute('libros_bienvenida');
}

public function validarlibro (Request $request){
    $bd = $this->bd;
    $nombreLibro = $request->request->get('libros')['nombre'];
    $libro = $bd->getRepository(libros::class)->findOneBy(['nombre'=>$nombreLibro]);
    $existeLibro = !empty($libro)?1:0;

    return new Response(json_encode(['result' => $existeLibro]));
}

}
