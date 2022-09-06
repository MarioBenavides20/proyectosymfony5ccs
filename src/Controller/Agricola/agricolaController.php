<?php
namespace App\Controller\Agricola;

use App\Entity\Agricola\cabCompras;
use App\Entity\Agricola\detCompras;
use App\Entity\Agricola\nocompra;
use App\Entity\Agricola\productos;
use App\Entity\Agricola\proveedores;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; //Boton submit
use Symfony\Component\Form\Extension\Core\Type\DateType; //Fecha
use Knp\Component\Pager\PaginatorInterface; //KNP Paginator
use App\Form\Agricola\proveedoresType; //Controlador de proveedor
use App\Form\Agricola\productosType; //Controlador de prductos
use App\Form\Agricola\cabcomprasType; //Controlador de prductos
use App\Form\Agricola\detcomprasType; //Controlador de detalle


class agricolaController extends AbstractController
{
////Contructor para obtener base de datos y utilizarla de manera global en toda la clase/////////////////////////////////////////////////////////////////////////////////
    private $bd; 
    public function __construct(EntityManagerInterface $em)
    {
        //para llamar una variable de clase utilizo $this->nombreVar;
        $this->bd = $em; 
    }

////Creacion de la cabecera de busqueda o filtro/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    public function formBusqComp(Request $request, $tipoFrm = 0)
    {
        $bd = $this->bd; 
        if (!empty($request->request->get('form')['proveedor'])) {
            $idProveedor = $request->request->get('form')['proveedor'];
            $proveedorObject = $bd->getRepository(proveedores::class)->find($idProveedor);
        } else {
            // manda el objeto vacio
            $idProveedor = null;
            $proveedorObject = null;
        }
        if (!empty($request->request->get('form')['fecha'])) {
            $idFecha = $request->request->get('form')['fecha'];
        } else {
            // manda el objeto vacio
            $idFecha = null;
        }

        $form = $this->createFormBuilder(null, array('method' => 'GET', 'action' => $this->generateUrl('agricola_frame_compr')))
            ->add('proveedor', EntityType::class, array(
                'class' => proveedores::class,
                'choice_value' => 'id',
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione proveedor',
                'label' => 'Proveedor',
                'required' => false,
                'data' => $proveedorObject

            ))
            ->add('fecha', DateType::class, array(
                'widget' => 'single_text',
                'placeholder' => 'Seleccionar fecha',
                'required' => false,
                'data' => $proveedorObject
            ))
            ->add('Buscar', SubmitType::class, ['label' => '<i class="fa-solid fa-magnifying-glass"></i> Buscar', 'label_html' => true]);

        if ($tipoFrm == 1) {
            // genera el formulario normal
            return $form->getForm();
        } else {
            // si es diferente envia el nuevo formulario
            return $this->renderForm('Agricola\compras\formBusqCompras.html.twig', array('form' => $form->getForm()));
        }
    }

////Creacion listar compras primera interfaz ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function listarcompras(Request $request, PaginatorInterface $paginator)
    {
        if (!empty($request->query->get('form')['proveedor'])) {  // vairables que trae el reques siempre es form y hay lo que queremos
            $idProveedor = $request->query->get('form')['proveedor'];
        } else {
            $idProveedor = null;
        }
        if (!empty($request->query->get('form')['fecha'])) {  // vairables que trae el reques siempre es form y hay lo que queremos
            $idFecha = $request->query->get('form')['fecha'];
        } else {
            $idFecha = null;
        }
        $Listacompras = $this->bd->getRepository(cabCompras::class)->findcompr($idProveedor, $idFecha);
        $pagination = $paginator->paginate($Listacompras, $request->query->getInt('page', 1), 10);
        return $this->render('Agricola\compras\framelistaCompr.html.twig', ['compras' => $pagination]);
    }

////Creacion de la vista primera interfaz ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function bienvenida(Request $request)
    {
        $formProveedores = $this->formBusqComp($request, 1);
        // $compras = new compras();
        return $this->render(
            'Agricola\compras\listaCompras.html.twig',
            array('form' => $formProveedores->createView())
        );
    }

////PARTE DE SESION 2/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////Metodo del modal agregar proveedor///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   public function guardarproveedor(Request $request)
   {
         $proveedor = new proveedores();
        $formnuevprov = $this->createForm(proveedoresType::class, 
        $proveedor, array('method' => 'POST',
        'action' => $this->generateUrl('agricola_nuevo_prov')));
        $formnuevprov->handleRequest($request);
        if($formnuevprov->isSubmitted() && $formnuevprov->isValid() ){
            $this->bd->persist($proveedor);
            $this->bd->flush();
            return $this->redirectToRoute('agricola_bienvenida');
        }
   }

///Metodo del modal agregar producto/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   public function guardarproducto(Request $request)
   {
        $producto = new productos();
        $formnuevprod = $this->createForm(productosType::class, 
        $producto, array('method' => 'POST',
        'action' => $this->generateUrl('agricola_nuevo_prod')));
        $formnuevprod->handleRequest($request);
        if($formnuevprod->isSubmitted() && $formnuevprod->isValid() ){
            $this->bd->persist($producto);
            $this->bd->flush();
            return $this->redirectToRoute('agricola_bienvenida');
        }
    }

///Validaciones de proveedor y producto para ver si se encuentra en la base de datos/////////////////////////////////////////////////////////////////////////////////////
    public function validarProveedor (Request $request){
        $bd = $this->bd;
        $nombreProveedor = $request->request->get('proveedores')['nombre'];
        $proveedor = $bd->getRepository(proveedores::class)->findOneBy(['nombre' => $nombreProveedor]);
        $existeProveedor = !empty($proveedor)?1:0;

        return new Response(json_encode(['resultprovee' => $existeProveedor]));
    }

    public function validarProducto (Request $request){
        $bd = $this->bd;
        $codigoProducto = $request->request->get('productos')['codigo'];
        $producto = $bd->getRepository(productos::class)->findOneBy(['codigo' => $codigoProducto]);
        $existeProducto = !empty($producto)?1:0;

        return new Response(json_encode(['resultproduc' => $existeProducto]));
    }

///Metodo de la cabecera (Fecha y Proveedores)///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function guardarcabcompras(Request $request, $idCompra)
   {

        $cabcompras = $this->bd->getRepository(cabCompras::class)->find($idCompra);
         $nocompra = new nocompra();
        
        $formnuevcabcomp = $this->createForm(cabcomprasType::class, 
        $cabcompras, array('method' => 'POST',
        'action' => $this->generateUrl('agricola_nueva_cabc', ['idCompra'=>$idCompra])));
        $formnuevcabcomp->handleRequest($request);
        if($formnuevcabcomp->isSubmitted() && $formnuevcabcomp->isValid() ){
            //Incrementacion del numero 
            
            $ultimodato = $this->bd->getRepository(nocompra::class)->findBy([], ['id' => 'DESC']);
            $Numcompra = $ultimodato[0]->getNoActual();
            $incremensuma = $Numcompra + 1;
            $rangocons = substr("0000",1,4-strlen($incremensuma)).$incremensuma;
            $nocompra->setNoActual($rangocons);
            $cabcompras->setNumero($rangocons);
            $cabcompras->setEstado(1);
            $this->bd->persist($nocompra);
            $this->bd->flush();

            foreach($cabcompras->getDetCompras() as $c){
                $cantidadesProd = $this->bd->getRepository(detCompras::class)->findAllCant($c->getProducto()->getId());
                $producto = $c->getProducto();
                $producto->setExistencia($cantidadesProd[0]['cantidad']);
                $this->bd->persist($producto);
            }
            $this->bd->flush();
            return $this->redirectToRoute('agricola_bienvenida');
        }
    }

////Metodo para traer variables de los modales, la cabecera y retornar para la vista ////////////////////////////////////////////////////////////////////////////////////
    public function nuevascompras(Request $request, $id): Response
    {
        //Crear proveedores
        $proveedor = new proveedores();
        $formnuevprov = $this->createForm( proveedoresType::class,
        $proveedor, array('method' => 'POST',
        'action' => $this->generateUrl('agricola_nuevo_prov')));
        
       //Crear productos
        $producto = new productos();
        $formnuevprod= $this->createForm(productosType::class, 
        $producto, array('method' => 'POST',
        'action' => $this->generateUrl('agricola_nuevo_prod')));

       //Crear cab compra
       $nuevaCabecera = new cabCompras();
       $nuevaCabecera->setEstado(0);
       $nuevaCabecera->setFecha(new \DateTime('now'));
       $this->bd->persist($nuevaCabecera);
       $idNuevaCompra = $nuevaCabecera->getId();
       $this->bd->flush();

       $ultimodato = $this->bd->getRepository(nocompra::class)->findBy([], ['id' => 'DESC']);
       $Numcompra = $ultimodato[0]->getNoActual()+1;
       $rangocons = substr("0000",1,4-strlen($Numcompra)).$Numcompra;

        $formnuevcabcomp= $this->createForm(cabcomprasType::class, 
        $nuevaCabecera, array('method' => 'POST',
        'action' => $this->generateUrl('agricola_nueva_cabc', ['idCompra' => $idNuevaCompra])));

       
        return $this->render('Agricola\compras\viewnuevCompr.html.twig',
        array('form_proveedor'=> $formnuevprov->createView(),
              'form_producto'=> $formnuevprod->createView(),
              'form_cabcompras'=> $formnuevcabcomp->createView(),
              'nocompra' =>$rangocons,
              'idCompra'=>$idNuevaCompra
                 
            ));
     }

////Ingreso del producto /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     public function guardardetcompras(Request $request, $id, $idCompra):Response
   {
        if($id!=0){
            $detcompras = $this->bd->getRepository(detCompras::class)->find($id);
        }
        else{
            $detcompras = new detCompras();
        }
        $formnuevdetcomp = $this->createForm(detcomprasType::class, 
        $detcompras, array('method' => 'POST',
        'action' => $this->generateUrl('agricola_nueva_det', ['id'=>$id,'idCompra' => $idCompra])));
        $formnuevdetcomp->handleRequest($request);
        if($formnuevdetcomp->isSubmitted() && $formnuevdetcomp->isValid() ){
            if ($id==0) {
                $cabcompras = $this->bd->getRepository(cabCompras::class)->find($idCompra);
                $detcompras->setCompra($cabcompras);
                $this->bd->persist($detcompras);
                $this->bd->flush();
                return $this->redirectToRoute('agricola_lista', ['idCompra'=>$idCompra]);
            } else {
                $this->bd->flush();
                return $this->redirectToRoute('agricola_lista', ['idCompra'=>$idCompra]);
            }
        }
    }

    public function ingdet(Request $request, PaginatorInterface $paginator, $idCompra):Response
     {
         //Crear det compra
         $detcompras = new detCompras();
         $formnuevdetcomp= $this->createForm(detcomprasType::class, 
         $detcompras, array('method' => 'POST',
         'action' => $this->generateUrl('agricola_nueva_det', ['idCompra' => $idCompra])));

        return $this->render('Agricola\compras\ingdet.html.twig', array('form_det' => $formnuevdetcomp->createView()));
    }
     
     public function listadet(Request $request, PaginatorInterface $paginator, $idCompra)
    {
        $detcompras = new detCompras();
        $formnuevdetcomp= $this->createForm(detcomprasType::class, 
        $detcompras, array('method' => 'POST',
        'action' => $this->generateUrl('agricola_nueva_det', ['idCompra' => $idCompra])));

        $Listdetacompras=$this->bd->getRepository(detCompras::class)->finddet($idCompra);
        $pagination = $paginator->paginate($Listdetacompras, $request->query->getInt('page', 1), 10);        
        return $this->render('Agricola\compras\frameinglistCompras.html.twig', [
            'compradet'=>$pagination, 
            'form_det' => $formnuevdetcomp->createView(), 
            'idCompra'=> $idCompra,
        ]);
   }

////Eliminar detalle de la compra/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function eliminardetprod($id, $idCompra){
        try {
            $detcompras = $this->bd->getRepository(detCompras::class)->find($id);
            
            $this->bd->remove($detcompras);
            $this->bd->flush();
            $this->addFlash('mensaje', 'Registro eliminado correctamente!');
        } catch (\Doctrine\DBAL\Exception\ConstraintViolationException $e) {
            $this->addFlash('error', 'El registro no ha podido eliminarse!');
            // return $this->redirectToRoute('agricola_lista',['id'=>$id]);
        }            
        return $this->redirectToRoute('agricola_lista', ['idCompra' => $idCompra]);
    }

////Calcular totales de la compra/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        public function calculartotales(){
        // Crear operaciones para realizar el total
        $subtotal=0;
        $iva=0;
        $Total=0;
        $ultimo = $this->bd->getRepository(cabCompras::class)->findBy([], ['id' => 'DESC']);
        $ultimodetcompra = $ultimo[0]->getId();
        
        $totalcompra = $this->bd->getRepository(cabCompras::class)->sumaproduc($ultimodetcompra);
        foreach ($totalcompra as $total) {
            $subtotal = intval($total['subtotal']);
            $iva = intval($total['vriva']);
        }
        $Total = $subtotal + $iva;
        
        //json
        // return new Response(json_encode(['subtotal' => $subtotal, 'iva' => $iva, 'total' => $Total]));

        //return render
        return $this->render('Agricola\compras\viewTotales.html.twig', array ('subtotal' => $subtotal,'iva' => $iva,'total' => $Total));
    }

    //Este solo esta creado para renderizar la vista ya que esta creado con un turbo frame pero se utiliza con 
    // y al utilizarlo en viewnuevcompr en el path y renderice lo que se realizo en turbo frame.
    // public function calcularframetotales(){
        ///return $this->render('Agricola\compras\viewTotales.html.twig', ['subtotal' => 0,'iva' => 0,'total' => 0]);
    // }

////Editar producto///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function editardetprod($id, $idCompra){
        
            $editcompra = $this->bd->getRepository(detCompras::class)->find($id);
            $formedit = $this->createForm(\App\Form\Agricola\detcomprasType::class,
            $editcompra, array('method' => 'POST',
            'action' => $this->generateUrl('agricola_nueva_det',['id' => $id,'idCompra'=>$idCompra]))); 

            return $this->render('Agricola\compras\ingdet.html.twig', array('form_det'=>$formedit->createView()));
    }

////Cancelar registro/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function cancelarCompra($id){
        $cancelcompra = $this->bd->getRepository(detCompras::class)->findBy(array("compra" => $id));

        foreach ($cancelcompra as $total){
            $iddetcompra = $total->getId();
            $detcompra = $this->bd->getRepository(detCompras::class)->find($iddetcompra);
            $this->bd->remove($detcompra);
        }

        $idcabcompra = $this->bd->getRepository(cabCompras::class)->find($id);
        $this->bd->remove($idcabcompra);
        $this->bd->flush();
        $this->addFlash('mensaje', 'Registro eliminado correctamente !');
        return $this->redirectToRoute('agricola_bienvenida');
    }
}



