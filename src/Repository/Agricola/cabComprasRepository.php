<?php

namespace App\Repository\Agricola;

use App\Entity\Agricola\cabCompras;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<cabCompras>
 *
 * @method cabCompras|null find($id, $lockMode = null, $lockVersion = null)
 * @method cabCompras|null findOneBy(array $criteria, array $orderBy = null)
 * @method cabCompras[]    findAll()
 * @method cabCompras[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class cabComprasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, cabCompras::class);
    }

    public function add(cabCompras $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(cabCompras $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return cabCompras[] Returns an array of cabCompras objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findcompr($idProveedor, $idFecha)
    {
        $parameters = array();
        if(!empty($idProveedor)){
                $cond1="proveedor.id = :idProveedor";
                $parameters[':idProveedor'] = $idProveedor;
        } else{$cond1="1 = 1";}

            if(!empty($idFecha)){
                $cond2="compras.fecha = :idFecha";
                $parameters[':idFecha'] = $idFecha;
        } else{$cond2="1 = 1";}
        
        return $this->createQueryBuilder('compras')
            ->select("compras.id, compras.numero, compras.fecha,  proveedor.nombre as proveedor_nombre")
            ->Join('compras.proveedor','proveedor')
            ->addSelect("(SELECT coalesce(sum(dt.subtotal),0) FROM App\Entity\Agricola\detCompras dt WHERE dt.compra = compras.id) as subtotalcompra")
            ->addSelect("(SELECT coalesce(sum(di.vriva),0) FROM App\Entity\Agricola\detCompras di WHERE di.compra = compras.id) as ivatotalcompra")
            ->addSelect("(SELECT coalesce(sum(dtt.total),0) FROM App\Entity\Agricola\detCompras dtt WHERE dtt.compra = compras.id) as totalcompra")
            ->Where($cond1)
            ->andWhere($cond2)
                ->orderBy('compras.id', 'DESC')
            ->setParameters($parameters)
            ->getQuery()
            ->getResult()
        ;
    }

////Crear metodo para sumatoria de del total/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function sumaproduc($id)
    {
        return $this->createQueryBuilder('cabcompras')
            ->select("cabcompras.id, coalesce(sum(compra.total),0) as total, coalesce(sum(compra.subtotal),0) as subtotal, coalesce(sum(compra.vriva),0) as vriva")
            ->leftjoin('cabcompras.detCompras', 'compra')
            ->Where('cabcompras.id = :id')
            ->setParameter('id', $id)
            ->groupBy('cabcompras.id')
            ->orderBy('cabcompras.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
