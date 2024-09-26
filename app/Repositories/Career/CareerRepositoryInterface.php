<?php

namespace App\Repositories\Career;
use App\Models\Career;
use App\Repositories\EloquentRepositoryInterface;

interface CareerRepositoryInterface extends EloquentRepositoryInterface
{
    public function searchAllLimit($value = '', $meta = [], $select = [], $limit = 10);
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');

    public function getAllUserByIds($ids);

    public function loadRelation(Career $career, array $relations = []);

    public function getQueryBuilderWithRelations($relations = []);
}
