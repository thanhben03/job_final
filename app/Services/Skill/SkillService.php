<?php

namespace App\Services\Skill;

use App\Repositories\Skill\SkillRepository;
use Illuminate\Http\Request;

class SkillService implements SkillServiceInterface
{

    protected $data;

    protected SkillRepository $repository;

    public function __construct(
        SkillRepository $repository
    ){
        $this->repository = $repository;
    }



    public function store(Request $request){
        $this->data = $request->validated();
        return $this->repository->create($this->data);
    }

    public function update(Request $request){
        $this->data = $request->validated();
        return $this->repository->update($this->data['id'], $this->data);
    }

    public function delete($id){
        return $this->repository->delete($id);

    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getQueryBuilderWithRelations($relations = [])
    {
        return $this->repository->getQueryBuilderWithRelations($relations);
    }

}
