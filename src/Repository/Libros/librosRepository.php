<?php

namespace App\Repository\Libros;

use App\Entity\Libros\editoriales;
use App\Entity\Libros\libros;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<libros>
 *
 * @method libros|null find($id, $lockMode = null, $lockVersion = null)
 * @method libros|null findOneBy(array $criteria, array $orderBy = null)
 * @method libros[]    findAll()
 * @method libros[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class librosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, libros::class);
    }

    public function add(libros $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(libros $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return libros[] Returns an array of libros objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
// CUANDO SE QUIERE REALIZAR UNA LOGICA SE LO HACE EN LOS REPOSITORIOS Y SE RETORNA RESULTADOS
// filtra la informacion
public function findLib($idPais,$idAutor,$idEditorial)
{
    $parameters = array();
    if(!empty($idPais)){
        $cond1="pais.id = :idPais";
        $parameters[':idPais'] =  $idPais;
    }else{$cond1="1 = 1";}
    if(!empty($idAutor)){
        $cond2="autor.id = :idAutor";
        $parameters[':idAutor'] = $idAutor;
    }else{$cond2="1 = 1";}
    if(!empty($idEditorial)){
        $cond3="editorial.id = :idEditorial";
        $parameters[':idEditorial']  = $idEditorial;
    }else{$cond3="1 = 1";}

//        !empty($idDocente) ? $cond1="docente.id = :idDocente"; array_push($parameters,':idDocente' => $idDocente) : $cond1="";
    return $this->createQueryBuilder('libros')
    
        ->select("libros.id, libros.nombre, editorial.nombre as editorial_name, autor.nombre as autor_nombre, autor.apellido as autor_apellido")
        ->Join('libros.autor','autor')
        ->Join('libros.editorial','editorial')
        ->Join('autor.pais','pais')
        ->Where($cond1)
        ->andWhere($cond2)
        ->andWhere($cond3)
        ->orderBy('libros.id', 'DESC')
        ->setParameters($parameters)
        ->getQuery()
        ->getResult()
    ;
}
 // esta funcion se la realiza para enviar los datos a la vista del libro a editar, ver o eliminar
public function findediLib($id){
    $dato=$this->createQueryBuilder('librosv')
    
        ->select("librosv.id, librosv.nombre, editorial.nombre as editorial_name, 
        autor.nombre as autor_nombre, autor.apellido as autor_apellido, pais.pais as pais_nombre, autor.fechaNacimiento as fecha_nacimiento")
        ->Join('librosv.autor','autor')
        ->Join('librosv.editorial','editorial')
        ->Join('autor.pais','pais')
        ->Where('librosv.id=:idLibro')
        ->setParameters([':idLibro'=>$id])
        ->getQuery()
        ->getResult();
foreach($dato as $datosV){
    return $datosV;
    }
}
}