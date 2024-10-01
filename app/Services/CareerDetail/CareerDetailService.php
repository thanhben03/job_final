<?php

namespace App\Services\CareerDetail;

use App\Repositories\CareerDetail\CareerDetailRepository;
use Illuminate\Http\Request;

class CareerDetailService implements CareerDetailServiceInterface
{

    protected $data;

    protected CareerDetailRepository $repository;

    public function __construct(
        CareerDetailRepository $repository
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
