<?php
namespace App\Form\Agricola;

use App\Entity\Agricola\productos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; //Boton
use Symfony\Bridge\Doctrine\Form\Type\EntityType; //Selector de entidad
use Symfony\Component\Form\FormBuilderInterface;


class detcomprasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('producto', EntityType::class, array(
                'class' => productos::class,
                'choice_value' => 'id',
                'choice_label' => function (productos $entity){
                    return $entity ? $entity->getCodigo()." - ".$entity->getNombre():'';
                },
                'placeholder' => 'Seleccione Productos',
                'label' => 'Producto',
                'required' => true,
            ))
            ->add('cant')
            ->add('vrunidad') 
            ->add('subtotal')
            ->add('iva') 
            ->add('vriva')
            ->add('total') 
            ->add('guardar', SubmitType::class,[
                  'label'=>'<i class="fa-solid fa-floppy-disk"></i>', 
                  'label_html' => true]);
    }
}
?>