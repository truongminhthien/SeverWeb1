<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     tags={"Category"},
     *     summary="Get all categories",
     *     @OA\Response(
     *         response=200,
     *         description="List all categories",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id_category", type="integer", example=1),
     *                 @OA\Property(property="category_name", type="string", example="Nước Hoa"),
     *                 @OA\Property(property="status", type="string", example="active"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function allCategory()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }
}
