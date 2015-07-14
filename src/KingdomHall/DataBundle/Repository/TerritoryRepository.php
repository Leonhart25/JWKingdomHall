<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/14/15
 * Time: 9:37 AM
 */

namespace KingdomHall\DataBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class TerritoryRepository extends EntityRepository {

    public function searchTerritories($congregation, $type, $pagination, $sort, $search)
    {
        // Map date sorting
        if ($sort['sort'] == 'formatted_borrow_date') {
            $sort['sort'] = 'borrowDate';
        }
        if ($sort['sort'] == 'formatted_return_date') {
            $sort['sort'] = 'returnDate';
        }

        $builder = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('KingdomHallDataBundle:Territory', 't')
            ->leftJoin('t.publisher', 'p')
            ->where('t.type = :type')
            ->andWhere('t.congregation = :congregation')
            ->setParameter('type', $type)
            ->setParameter('congregation', $congregation);

        // Set order
        $builder
            ->orderBy('t.'.$sort['sort'], $sort['order']);

        // Set pagination
        $builder->setMaxResults($pagination['limit'])
            ->setFirstResult($pagination['offset']);

        // Set search
        if ($search) {
            $where = $builder->expr()->orX();
            $where->add($builder->expr()->like('t.number', $builder->expr()->literal('%' . $search . '%')));
            $where->add($builder->expr()->like('t.name', $builder->expr()->literal('%' . $search . '%')));
            $where->add($builder->expr()->like('t.area', $builder->expr()->literal('%' . $search . '%')));
            $where->add($builder->expr()->like('p.firstName', $builder->expr()->literal('%' . $search . '%')));
            $where->add($builder->expr()->like('p.lastName', $builder->expr()->literal('%' . $search . '%')));

            $builder->andWhere($where);
        }
        $query = $builder->getQuery();

        $paginator = new Paginator($query);

        $territories = $query->getResult();
        $response  = array (
            'total' => count($paginator),
            'rows' => $territories,
        );
        return $response;
    }
}