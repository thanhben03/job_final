<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Skill;
use App\Models\UserExperience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $dataUser = Arr::except($data, ['from_date', 'to_date', 'title', 'position', 'description', 'skill_ids']);
        $skill_ids = $data['skill_ids'] ?? [];
        $data_experience = Arr::only($data, ['from_date', 'to_date', 'title', 'position', 'description']);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        try {
            DB::beginTransaction();
            UserExperience::query()->where('user_id', $request->user()->id)->delete();

            $insertDataExperience = [];
            for ($i = 0; $i < count($data_experience['title']); $i++) {
                $insertDataExperience[] = [
                    'from_date' => $data_experience['from_date'][$i],
                    'to_date' => $data_experience['to_date'][$i],
                    'title' => $data_experience['title'][$i],
                    'position' => $data_experience['position'][$i],
                    'description' => $data_experience['description'][$i],
                    'user_id' => Auth::id(),
                ];
            }

            // Bước 3: Chèn dữ liệu mới vào bảng experiences
//            DB::table('user_experiences')->insert($insertDataExperience);


            $skill_ids = Skill::query()->whereIn('name', $skill_ids)->get()->pluck('id')->toArray();
            $request->user()->skills()->sync($skill_ids);
            UserExperience::query()->insert($insertDataExperience);

            $request->user()->fill($dataUser);
            $request->user()->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

        return redirect()->back()->with('msg', 'Saved successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
