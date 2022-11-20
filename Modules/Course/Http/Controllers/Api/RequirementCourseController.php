<?php

namespace Modules\Course\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\RequirementCourse;
use Modules\Course\Http\Requests\RequirementCourseRequest;
use App\Http\Controllers\Traits\Tools;

class RequirementCourseController extends Controller
{
    use Tools;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(RequirementCourseRequest $request)
    {
        try {
            $sequence = (RequirementCourse::where('course_id', $request->course_id)->first('sequence') == NULL)
            ? 1 : RequirementCourse::where('course_id', $request->course_id)->latest()->first('sequence')['sequence'] + 1;

            $requirement = RequirementCourse::create([
                'course_id' => $request->course_id,
                'sequence' => $sequence,
                'detail_requirement' => $request->detail_requirement
            ]);

            return $this->response('success', 'success to create requirement', $requirement, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to create requirement', $th->getMessage(), 400);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
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
    public function destroy(RequirementCourse $requirementCourse)
    {
        try {
            $requirementCourse->delete();

            return $this->response('success', 'success to delete requirement', true, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to delete requirement', $th->getMessage(), 400);
        }
    }
}
