<?php

namespace App\Repositories\Skill;
use App\Models\Career;
use App\Models\Skill;
use App\Repositories\EloquentRepository;

class SkillRepository extends EloquentRepository implements SkillRepositoryInterface
{

    protected $select = [];

    public function getModel(): string
    {
        return Skill::class;
    }
    public function searchAllLimit($keySearch = '', $meta = [], $select = ['id', 'fullname', 'phone'], $limit = 10){
        $this->instance = $this->model->select($select);
        $this->getQueryBuilderFindByKey($keySearch);

        foreach($meta as $key => $value){
            $this->instance = $this->instance->where($key, $value);
        }

        return $this->instance->limit($limit)->get();
    }

    protected function getQueryBuilderFindByKey($key){
        $this->instance = $this->instance->where(function($query) use ($key){
            return $query->where('username', 'LIKE', '%'.$key.'%')
                ->orWhere('phone', 'LIKE', '%'.$key.'%')
                ->orWhere('email', 'LIKE', '%'.$key.'%')
                ->orWhere('fullname', 'LIKE', '%'.$key.'%');
        });
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC'){
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function getAllUserByIds($ids)
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->whereIn('id', $ids);

        return $this->instance->get();
    }

    public function getQueryBuilderWithRelations($relations = []){
        $this->getQueryBuilderOrderBy();
        $this->instance = $this->instance->with($relations);
        return $this->instance;
    }

    public function loadRelation(Skill $skill, array $relations = [])
    {
        return $skill->load($relations);
    }
}
