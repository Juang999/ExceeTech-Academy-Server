<?php

namespace Modules\Sertification\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\Traits\Tools;
use Modules\Sertification\Entities\CategoryCertification;
use Modules\Sertification\Http\Requests\CreateCategorySertificationRequest;

class CategorySertificationController extends Controller
{
    use Tools;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        try {
            $category = CategoryCertification::get();

            return $this->response('success', 'success to get data category', $category, 200);
        } catch (Exception $e) {
            return $this->resopnse('failed', 'failed to get data category', $e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CreateCategorySertificationRequest $request)
    {
        try {
            $category = CategoryCertification::create([
                'category_name' => $request->category_name,
                'is_active' => 'Y'
            ]);

            return $this->response('success', 'success to create new category', $category,  200);
        } catch (Exception $e) {
            return $this->response('failed', 'failed to create new category', $e->getMessage(), 400);
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
    public function destroy($id)
    {
        //
    }
}
