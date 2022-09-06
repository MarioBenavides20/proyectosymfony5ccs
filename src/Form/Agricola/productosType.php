<?php
namespace App\Form\Agricola;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class productosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codigo',    TextType::class, array(
                  'label'=>'nombre', 
                  'attr'=>array('placeholder'=>'Ingrese nombre'), 
                  'required'=>true))
            ->add('nombre',    TextType::class, array(
                  'label'=>'nombre',
                  'attr'=>array('placeholder'=>'Ingrese nombre'),
                  'required'=>true))
            ->add('existencia')
            ->add('costo') 
            ->add('guardar', SubmitType::class,[
                  'label'=>'<i class="fa-solid fa-floppy-disk"></i> Guardar', 
                  'label_html' => true])
        ;
    }
}
?>