<?php

namespace Modules\Course\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\CategoryCourse;
use App\Http\Controllers\Traits\Tools;

class CategoryCourseController extends Controller
{
    use Tools;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        try {
            $category = CategoryCourse::get()->toTree();

            return $this->response('success', 'success to get category', $category, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get category', $th->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->parent_id != NULL) {
                $node = CategoryCourse::create([
                    'name' => $request->name
                ]);

                $parent = CategoryCourse::find($request->parent_id);

                $parent->appendNode($node);

                DB::commit();

                return $this->response('success', 'success to create node', true, 200);
            }

                $category = CategoryCourse::create([
                    'name' => $request->name
                ]);

            DB::commit();

            return $this->response('success', 'success to create category course', $category, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->response('failed', 'failed to create category course', $th->getMessage(), 400);
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
            $node = CategoryCourse::descendantsOf($id)->toTree();

            return $this->response('success', 'success to get descendant', $node, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get descendant', $th->getMessage(), 400);
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
        try {
            DB::beginTransaction();

            $category = CategoryCourse::find($id);

            if ($request->parent_id != NULL) {
                $category->update([
                    'name' => ($request->name != NULL) ? $request->name : $category->name,
                    'parent_id' => $request->parent_id
                ]);

                DB::commit();

                return $this->response('success', 'success to update category', true, 200);
            }

            $category->update([
                'name' => $request->name
            ]);

            DB::commit();

            return $this->response('success', 'success to update data', true, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to update data', $th->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            CategoryCourse::where('id', $id)->delete();

            return $this->response('success', 'success to delete category', true, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to delete category', $th->getMessage(), 400);
        }
    }
}
