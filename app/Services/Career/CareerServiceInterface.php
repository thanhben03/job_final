<?php

namespace App\Services\Career;
use Illuminate\Http\Request;

interface CareerServiceInterface
{
     /**
     * Tạo mới
     *
     * @var Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request);
    /**
     * Cập nhật
     *
     * @var Illuminate\Http\Request $request
     *
     * @return boolean
     */
    public function update($id, Request $request);
    /**
     * Xóa
     *
     * @param int $id
     *
     * @return boolean
     */
    public function delete($id);

    public function getAll();
    public function getQueryBuilderWithRelations($relations);
    public function getQueryBuilderWithRelationsUpdated($relations, $orderBy = 'DESC');

    public function getAllById($company_id);

    public function getBySlug($slug);

    public function extractInfoRequire($data);

    public function matchWithCandidate($extractInfo);

}
