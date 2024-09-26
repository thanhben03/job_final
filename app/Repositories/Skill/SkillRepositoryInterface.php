<?php

namespace App\Repositories\Skill;
use App\Models\Skill;
use App\Repositories\EloquentRepositoryInterface;

interface SkillRepositoryInterface extends EloquentRepositoryInterface
{
    public function searchAllLimit($value = '', $meta = [], $select = [], $limit = 10);
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');

    public function getAllUserByIds($ids);

    public function loadRelation(Skill $career, array $relations = []);

    public function getQueryBuilderWithRelations($relations = []);
}
