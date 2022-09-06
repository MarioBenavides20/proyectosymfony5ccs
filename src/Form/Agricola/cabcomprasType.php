<?php
namespace App\Form\Agricola;

use App\Entity\Agricola\proveedores;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; //Boton
use Symfony\Bridge\Doctrine\Form\Type\EntityType; //Selector de entidad
use Symfony\Component\Form\FormBuilderInterface;


class cabcomprasType extends AbstractType
{
    // Construir formulario de ingreso de libros
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('fecha', DateType::class, array(
              'widget' => 'single_text', 
              'placeholder' => 'Seleccionar fecha'))

        ->add('proveedor', EntityType::class, array(
              'class' => proveedores::class,
              'choice_value' => 'id',
              'choice_label' => 'nombre',
              'placeholder' => 'Seleccione proveedor',
              'label' => 'Proveedor',
              'required' => true,

        ))
        ->add('guardar', SubmitType::class, [
              'label' => '<i class="fa-solid fa-floppy-disk"></i> Guardad registro', 
              'label_html' => true]);
    }
}
?>