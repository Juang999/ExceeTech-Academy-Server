<?php

namespace Modules\Course\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\Traits\Tools;
use Modules\Course\Entities\MentorCourse;
use Modules\Course\Http\Requests\MentorCourseRequest;

class MentorCourseController extends Controller
{
    use Tools;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($course_id)
    {
        try {
            $mentor = User::whereIn('id', function ($query) use ($course_id) {
                $query->select('user_id')
                    ->from('mentor_courses')
                    ->where('course_id', $course_id)
                    ->get();
            })->orderBy('sequence')->get();

            return $this->response('success', 'success to get mentor from course', $mentor, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get mentor from course', $th->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(MentorCourseRequest $request)
    {
        try {
            $sequence = (MentorCourse::where('course_id', $request->course_id)->first() != NULL)
                ? MentorCourse::where('course_id', $request->course_id)->latest()->first('sequence')['sequence'] + 1
                : 1;

            $mentor = MentorCourse::create([
                'user_id' => $request->mentor_id,
                'course_id' => $request->course_id,
                'sequence' => $sequence
            ]);

            return $this->response('success', 'success to create mentor', $mentor, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to create mentor', $th->getMessage(), 400);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $mentor = User::where('id', function ($query) use ($id) {
                $query->select('model_id')
                    ->from('model_has_roles')
                    ->where([
                        ['model_id', '=', $id],
                        ['model_type', '=', 'App\Models\User'],
                        ['role_id', '=', function ($query) {
                            $query->select('id')
                                ->from('roles')
                                ->where([
                                    ['name', '=', 'mentor'],
                                    ['guard_name', '=', 'api']
                                ])->first();
                        }]
                    ])->first();
            })->first();

            return $this->response('success', 'success to get detail mentor', $mentor, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get detail mentor', $th->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(MentorCourse $mentorCourse)
    {
        try {
            $mentorCourse->delete();

            return $this->response('success', 'success to delete mentor', true, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to delete mentor', $th->getMessage(), 400);
        }
    }
}
