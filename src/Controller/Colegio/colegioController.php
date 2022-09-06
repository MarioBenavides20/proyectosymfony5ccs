<?php
namespace App\Controller\Colegio;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Colegio\docentes;
use App\Entity\Colegio\materias;
use App\Repository\Colegio\materiasRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; //Boton submit
use Symfony\Component\Form\Extension\Core\Type\TextType; //Campo de texto
use Symfony\Bridge\Doctrine\Form\Type\EntityType; //Selector de entidad
class colegioController extends AbstractController
{
    public function formBusqEst(Request $request, $tipoFrm = 0){
        $bd=$this->getDoctrine()->getManager();
        if(!empty($request->request->get('form')['docente'])){
            $idDocente=$request->request->get('form')['docente'];
            $docenteObject=$bd->getRepository(docentes::class)->find($idDocente);
        }
        else{
            $idDocente=null;$docenteObject=null;
        }
        
        $form = $this->createFormBuilder(null,array('method'=>'GET'))
        ->add('docente', EntityType::class, array(
            'class' => docentes::class,
            'choice_value' => 'id',
            'choice_label' => function(docentes $entity ){
                return $entity ? $entity->getNombres() . " " . $entity->getApellidos() : '';
        },
            'placeholder'=>'Seleccione docente',
            'label' => 'Docente',
            'required'=>false,
            'data'=>$docenteObject
        ))
        ->add('materia', EntityType::class, array(
            'class' => materias::class,
            'choice_value' => 'id',
            'choice_label' => 'nombre',
            'placeholder'=>'Seleccione materia',
            'label' => 'Materia',
            'required'=>false,
            'query_builder' => function(materiasRepository $er ) use ($idDocente)  {
                return $er->createQueryBuilder('materia')
                    ->Join('materia.docente','docentes')
                    ->Where('docentes.id = :vrBuscado')
                    ->setParameter(':vrBuscado',$idDocente)
                    ->orderBy('materia.nombre', 'ASC');
        },            
        ))
        ->add('estudiante', TextType::class, ['required'=>false])
        ->add('Buscar', SubmitType::class, ['label' => 'Buscar']);
        if($tipoFrm==1){
            return $form->getForm();  
        }
        else{
            return $this->renderForm('Colegio\estudiantes\formBusqEstudiantes.html.twig',array('form'=>$form->getForm()));
        }
          
    }
   
    public function bienvenida(Request $request)
    {
        $formEstudiantes=$this->formBusqEst($request,1);
        return $this->render('Colegio\estudiantes\listaEstudiantes.html.twig', 
            array('form'=>$formEstudiantes->createView()));
    }
}