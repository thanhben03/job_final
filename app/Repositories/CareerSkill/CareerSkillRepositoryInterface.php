<?php

namespace App\Repositories\CareerSkill;
use App\Models\CareerSkill;
use App\Repositories\EloquentRepositoryInterface;

interface CareerSkillRepositoryInterface extends EloquentRepositoryInterface
{
    public function searchAllLimit($value = '', $meta = [], $select = [], $limit = 10);
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');

    public function getAllUserByIds($ids);

    public function loadRelation(CareerSkill $careerSkill, array $relations = []);

    public function getQueryBuilderWithRelations($relations = []);
}
