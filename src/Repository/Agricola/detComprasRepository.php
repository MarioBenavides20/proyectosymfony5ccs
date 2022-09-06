<?php

namespace App\Repository\Agricola;

use App\Entity\Agricola\detCompras;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<detCompras>
 *
 * @method detCompras|null find($id, $lockMode = null, $lockVersion = null)
 * @method detCompras|null findOneBy(array $criteria, array $orderBy = null)
 * @method detCompras[]    findAll()
 * @method detCompras[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class detComprasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, detCompras::class);
    }

    public function add(detCompras $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(detCompras $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return detCompras[] Returns an array of detCompras objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function finddet($idCompra)
    {
        $parameters = array();
        if(!empty($idCompra)){
            $cond1="compra.id = :idCompra";
            $parameters[':idCompra'] = $idCompra;
        } else{$cond1="1 = 1";}

        return $this->createQueryBuilder('compradet')
            ->select("compradet.id, compradet.cant, compradet.vrunidad, compradet.subtotal, compradet.iva, compradet.vriva, compradet.total, producto.nombre as producto_nombre")
            ->Join('compradet.producto','producto')
            ->join("compradet.compra", 'compra')
            ->Where($cond1)
            ->orderBy('compradet.id', 'DESC')
            ->setParameters($parameters)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllCant($id)
    {
        return $this->createQueryBuilder('dt')
        ->select('sum(dt.cant) as cantidad') 
        ->where('dt.producto = :idProducto')
        ->setParameter('idProducto', $id)
        ->getQuery()
        ->getResult();
    }
}
