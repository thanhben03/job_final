<?php

namespace App\Services\Career;

use App\Repositories\Career\CareerRepository;
use App\Repositories\CareerDetail\CareerDetailRepository;
use App\Repositories\CareerSkill\CareerSkillRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CareerService implements CareerServiceInterface
{

    protected $data;

    protected CareerRepository $repository;
    protected CareerSkillRepository $careerSkillRepository;
    protected CareerDetailRepository $careerDetailRepository;

    public function __construct(
        CareerRepository $repository,
        CareerDetailRepository $careerDetailRepository,
        CareerSkillRepository $careerSkillRepository
    ){
        $this->repository = $repository;
        $this->careerDetailRepository = $careerDetailRepository;
        $this->careerSkillRepository = $careerSkillRepository;
    }



    public function store(Request $request){
        try {
            DB::beginTransaction();
            $this->data = $request->validated();
            $career = Arr::except($this->data, ['skill_ids', 'desc', 'require', 'benefit', 'key_responsibilities']);
            $career['company_id'] = auth()->user()->company->id;
            $career['slug'] = Str::slug($career['title']);
            $result = $this->repository->create($career);

            $careerDetailData = Arr::only($this->data, ['desc', 'require', 'benefit', 'key_responsibilities']);
            $careerDetailData['career_id'] = $result->id;
            $this->careerDetailRepository->create($careerDetailData);

            $skillIds = $this->data['skill_ids'];

            $result->skills()->attach($skillIds);
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();

            dd($exception->getMessage());
        }

    }

    public function update($id, Request $request){
        try {
            DB::beginTransaction();
            $this->data = $request->validated();
            $careerData = Arr::except($this->data, ['skill_ids', 'desc', 'require', 'benefit', 'key_responsibilities']);
            $careerData['slug'] = Str::slug($careerData['title']);
            $career = $this->repository->update($id, $careerData);

            // Cập nhật thông tin chi tiết career_detail
            $careerDetailData = Arr::only($this->data, ['desc', 'require', 'benefit', 'key_responsibilities']);
            $this->careerDetailRepository->update($career->detail->id, $careerDetailData);

            // Lấy mảng skill_ids
            $skillIds = $this->data['skill_ids'];

            $career->skills()->sync($skillIds);
            DB::commit();

            return $career;
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
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


    public function getAllById($company_id)
    {
        $instance = $this->repository->getQueryBuilder();
        return $instance->where('company_id', $company_id)->get();
    }

    public function getBySlug($slug)
    {
        $instance = $this->repository->getQueryBuilder();
        return $instance->where('slug', $slug)->first();
    }
}
