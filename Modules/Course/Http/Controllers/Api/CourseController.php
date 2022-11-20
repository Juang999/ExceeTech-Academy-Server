<?php

namespace Modules\Course\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\Tools;
use Illuminate\Http\{Response, Request};
use Illuminate\Support\Facades\Auth;
use Modules\Course\Http\Requests\CourseRequest;
use Modules\Course\Entities\{Course, DetailPriceCourse};
use Spatie\Permission\Models\Role;

class CourseController extends Controller
{
    use Tools;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        try {
            $course = Course::with('CategoryCourse')->get();

            return $this->response('success', 'success to get course', $course, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get coures', $th->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CourseRequest $request)
    {
        try {
            DB::beginTransaction();
                $course = Course::create([
                    'title' => $request->title,
                    'category_course_id' => $request->category_id,
                    'description' => $request->description,
                    'meet' => $request->meet,
                    'price' => $request->price
                ]);

                $sequence = (DetailPriceCourse::where('course_id', $course->id)->count() == 0)
                    ? 1 : DetailPriceCourse::where('course_id', $course->id)->count();

                DetailPriceCourse::create([
                    'course_id' => $course->id,
                    'sequence' => $sequence++,
                    'price' => $course->price
                ]);
            DB::commit();

            return $this->response('success', 'success to create course', $course, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->response('failed', 'failed to create course', $th->getMessage(), 400);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Course $course)
    {
        try {

            $roles = Auth::user()->roles;
            foreach ($roles as $role) {
                $can = Role::findByName($role->name, 'api');
                if ($can->hasPermissionTo('course.price_history')) {
                    $course = Course::where('id', $course->id)->with(['DetailPriceCourse', 'CategoryCourse', 'MentorCourse.User', 'RequirementCourse'])->first();

                    return $this->response('success', 'success to get detail course', $course, 200);
                }
            }

            $course = Course::where('id', $course->id)->with(['CategoryCourse', 'MentorCourse.User', 'RequirementCourse'])->first();

            return $this->response('success', 'success to get detail course', $course, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get detail data', $th->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CourseRequest $request, Course $course)
    {

        try {
            $course->update([
                'title' => $request->title,
                'category_course_id' => $request->category_id,
                'description' => $request->description,
                'meet' => $request->meet,
                'price' => ($request->price != $course->price) ? $request->price : $course->price
            ]);

            if (($request->price != $course->price) == false) {
                $sequence = DetailPriceCourse::where('course_id', $course->id)->count() + 1;

                DetailPriceCourse::create([
                    'course_id' => $course->id,
                    'sequence' => $sequence,
                    'price' => $request->price
                ]);
            }

            return $this->response('success', 'success to update course', true, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to update course', $th->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Course $course)
    {
        try {
            $course->delete();

            return $this->response('success', 'success to delete course', true, 400);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to delete course', $th->getMessage(), 400);
        }
    }
}
