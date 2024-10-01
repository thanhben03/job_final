<?php

namespace App\Repositories\CareerDetail;
use App\Models\CareerDetail;
use App\Repositories\EloquentRepositoryInterface;

interface CareerDetailRepositoryInterface extends EloquentRepositoryInterface
{
    public function searchAllLimit($value = '', $meta = [], $select = [], $limit = 10);
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');

    public function getAllUserByIds($ids);

    public function loadRelation(CareerDetail $careerDetail, array $relations = []);

    public function getQueryBuilderWithRelations($relations = []);
}
