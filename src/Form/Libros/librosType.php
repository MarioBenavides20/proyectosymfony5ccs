<?php
namespace App\Form\Libros;

use App\Entity\Libros\autores;
use App\Entity\Libros\editoriales;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; //Selector de entidad

use Symfony\Component\Form\FormBuilderInterface;

class librosType extends AbstractType
{
    // Construir formulario de ingreso de libros
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, array(
                'label'=>'nombre libro', 
                'attr'=>array(
                    'placeholder'=>'Ingrese libro',
                ),
                'required'=>true))

            ->add('autor', EntityType::class, [
                'class' => autores::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione autor',
                'required' => true,

                ])

            ->add('editorial', EntityType::class, [
                'class' => editoriales::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione editorial',
                'required' => true,

                ])
            ->add('guardar', SubmitType::class,['label'=>'<i class="fa-solid fa-floppy-disk"></i> Guardar', 'label_html' => true])
        ;
    }
}
?>