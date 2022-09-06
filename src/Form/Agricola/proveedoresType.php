<?php
namespace App\Form\Agricola;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;

class proveedoresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre',    TextType::class, array(
                  'label' => 'nombre', 
                  'attr' => array('placeholder' => 'Ingrese nombre',),
                  'required' => true))
            ->add('nit',       TextType::class, array(
                  'label' => 'nit', 
                  'attr' => array('placeholder' => 'Ingrese nit',), 
                  'required' => true))
            ->add('direccion', TextType::class, array(
                  'label' => 'direccion', 
                  'attr' => array('placeholder' => 'Ingrese direccion',), 
                  'required' => true))
            ->add('guardar',   SubmitType::class, [
                  'label' => '<i class="fa-solid fa-floppy-disk"></i> Guardar', 
                  'label_html' => true]);
    }
}
?>