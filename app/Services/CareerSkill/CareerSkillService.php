<?php

namespace App\Services\CareerSkill;

use App\Repositories\CareerSkill\CareerSkillRepository;
use Illuminate\Http\Request;

class CareerSkillService implements CareerSkillServiceInterface
{

    protected $data;

    protected CareerSkillRepository $repository;

    public function __construct(
        CareerSkillRepository $repository
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
