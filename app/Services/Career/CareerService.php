<?php

namespace App\Services\Career;

use App\Enums\GenderEnum;
use App\Enums\JobExpEnum;
use App\Enums\LevelEnum;
use App\Enums\QualificationEnum;
use App\Http\Resources\CandidateSingleResource;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserCareer;
use App\Repositories\Career\CareerRepository;
use App\Repositories\CareerDetail\CareerDetailRepository;
use App\Repositories\CareerSkill\CareerSkillRepository;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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
            $career = Arr::except($this->data, ['skill_ids', 'description', 'requirement', 'benefit', 'key_responsibilities']);
            $career['company_id'] = auth()->guard('company')->user()->id;
            $career['slug'] = Str::slug($career['title']);
            $result = $this->repository->create($career);

            $careerDetailData = Arr::only($this->data, ['description', 'requirement', 'benefit', 'key_responsibilities']);
            $careerDetailData['career_id'] = $result->id;
            $this->careerDetailRepository->create($careerDetailData);

            $skillIds = $this->data['skill_ids'];

            $result->skills()->attach($skillIds);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();

            dd($exception->getMessage());
        }

    }

    public function matchWithCandidate($extractInfo, $careerId = null)
    {
        $skills = implode(' ', $extractInfo['skills']); // Nối các kỹ năng bằng khoảng trắng thay vì dấu phẩy

        $conditions = [
            'skill' => [
                'column' => 'user_profiles.skill',
                'value' => $skills,
                'type' => 'fulltext',
                'match_string' => 'Skill Match: ' . $skills,
            ],
            'gender' => [
                'column' => 'users.gender',
                'value' => $extractInfo['gender'],
                'type' => 'equals',
                'match_string' => 'Gender Match: ' . GenderEnum::getDescription($extractInfo['gender']),
            ],

        ];

        $selects = [];
        $selectValues = [];
        $matchCountExpression = [];
        $candidates = [];
        // Tạo các điều kiện SELECT và COUNT
        foreach ($conditions as $key => $condition) {
            if ($condition['type'] === 'fulltext') {
                $selects[] = DB::raw("CASE WHEN MATCH({$condition['column']}) AGAINST(? IN NATURAL LANGUAGE MODE) THEN '{$condition['match_string']}' ELSE NULL END as {$key}_match");
                $matchCountExpression[] = "CASE WHEN MATCH({$condition['column']}) AGAINST(? IN NATURAL LANGUAGE MODE) THEN 1 ELSE 0 END";
            } elseif ($condition['type'] === 'equals') {
                $selects[] = DB::raw("CASE WHEN {$condition['column']} = ? THEN '{$condition['match_string']}' ELSE NULL END as {$key}_match");
                $matchCountExpression[] = "CASE WHEN {$condition['column']} = ? THEN 1 ELSE 0 END";
            }
        }

        foreach ($selects as $select) {
            $selectValues[] = $select->getValue(DB::connection()->getQueryGrammar());
        }

        if ($careerId > 0) {
            $candidates = UserCareer::query()
                ->join('curriculum_vitaes', 'curriculum_vitaes.id', '=', 'user_careers.cv_id')
                ->join('users', 'users.id', '=', 'curriculum_vitaes.user_id')
                ->leftJoin('user_profiles', 'user_profiles.cv_id', '=', 'curriculum_vitaes.id')
                ->select('users.*', 'user_profiles.skill')
                ->selectRaw(implode(', ', $selectValues)) // Chuyển đổi mảng thành chuỗi cho selectRaw
                ->selectRaw('(' . implode(' + ', $matchCountExpression) . ') as match_count') // Đếm số lượng khớp
                ->setBindings(array_merge(
                // Lấy giá trị từ mảng conditions
                    array_column($conditions, 'value'),
                    array_column($conditions, 'value')
                ))
                ->where('user_careers.career_id', $careerId)
                ->having('match_count', '>', 0) // Chỉ lấy những ứng viên có match_count > 0
                ->orderBy('match_count', 'desc')
                ->get();
        } else {
            // Bắt đầu truy vấn
            $candidates = User::query()
                ->leftJoin('curriculum_vitaes', 'curriculum_vitaes.user_id', '=', 'users.id')
                ->leftJoin('user_profiles', 'user_profiles.cv_id', '=', 'curriculum_vitaes.id')
                ->select('users.*', 'user_profiles.skill')
                ->selectRaw(implode(', ', $selectValues)) // Chuyển đổi mảng thành chuỗi cho selectRaw
                ->selectRaw('(' . implode(' + ', $matchCountExpression) . ') as match_count') // Đếm số lượng khớp
                ->setBindings(array_merge(
                // Lấy giá trị từ mảng conditions
                    array_column($conditions, 'value'),
                    array_column($conditions, 'value')
                ))
                ->having('match_count', '>', 0) // Chỉ lấy những ứng viên có match_count > 0
                ->orderBy('match_count', 'desc')
                ->get();
        }



        $candidates = collect($candidates)->unique('id');
        $matchedCandidates = $candidates->map(function ($candidate) {
            $matches = [];

            // Kiểm tra và thêm các tiêu chí đã khớp vào mảng
            if (!empty($candidate->skill_match)) {
                $matches['skill_match'] = $candidate->skill_match;
            }
            if (!empty($candidate->gender_match)) {
                $matches['gender_match'] = $candidate->gender_match;
            }
            // Bạn có thể thêm các tiêu chí khác vào đây nếu có
            return [
                'candidate' => CandidateSingleResource::make($candidate)->resolve(),
                'matches' => $matches,
            ];
        });

        return $matchedCandidates;
    }

    public function extractInfoRequire($data)
    {
        $extract = [];
        //        $gender = GenderEnum::getDescription($data['gender']);
        $level = LevelEnum::getDescription($data['level']);
        $experience = JobExpEnum::getDescription($data['experience']);
        $qualification = QualificationEnum::getDescription($data['qualification']);

        $skills = [];



        foreach ($data['skills'] as $instance) {
            $skillId = $instance['id'];
            $skills[] = Skill::query()->find($skillId)->name;
        }


        $extract = [
            'gender' => $data['gender'],
            'level' => $level,
            'experience' => $experience,
            'qualification' => $qualification,
            'skills' => $skills,
        ];

        return $extract;
    }

    public function update($id, Request $request){
        try {
            DB::beginTransaction();
            $this->data = $request->validated();
            $career = Arr::except($this->data, ['skill_ids', 'description', 'requirement', 'benefit', 'key_responsibilities']);
            $career['slug'] = Str::slug($career['title']);

            $career = $this->repository->update($id, $career);

            // Cập nhật thông tin chi tiết career_detail
            $careerDetailData = Arr::only($this->data, ['description', 'requirement', 'benefit', 'key_responsibilities']);
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
        return $instance->where([
            'company_id' => $company_id,
            'status' => 1
        ])->get();
    }

    public function getBySlug($slug)
    {
        $instance = $this->repository->getQueryBuilder();
        return $instance->where('slug', $slug)->first();
    }
}
