<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class UserService implements UserServiceInterface
{

    protected $data;

    protected UserRepository $repository;

    public function __construct(
        UserRepository $repository
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

    public function getQueryBuilderWithRelationsUpdated($relations = [], $orderBy = 'desc')
    {
        return $this->repository->getQueryBuilderWithRelationsUpdated($relations, $orderBy);

    }

    public function getBySlug($slug)
    {
        return $this->repository->findByColumn('slug', $slug)->first();
    }

}
