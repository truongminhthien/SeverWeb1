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
        $categories = Category::where('id_parent', 0)
            ->with(['subcategory' => function ($query) {
                $query->select('id_category', 'id_parent', 'category_name', 'slug', 'status', 'created_at', 'updated_at');
            }])
            ->select('id_category', 'category_name', 'slug', 'status', 'created_at', 'updated_at')
            ->get()
            ->map(function ($category) {
                return [
                    'id_category' => $category->id_category,
                    'category_name' => $category->category_name,
                    'slug' => $category->slug,
                    'status' => $category->status,
                    'created_at' => $category->created_at,
                    'updated_at' => $category->updated_at,
                    'subcategories' => $category->subcategory->map(function ($sub) {
                        return [
                            'id_subcategory' => $sub->id_category,
                            'id_category' => $sub->id_parent,
                            'category_name' => $sub->category_name,
                            'slug' => $sub->slug,
                            'status' => $sub->status,
                            'created_at' => $sub->created_at,
                            'updated_at' => $sub->updated_at,
                        ];
                    }),
                ];
            });

        return response()->json($categories, 200);
    }


    /**
     * @OA\Post(
     *     path="/api/categories",
     *     tags={"Category"},
     *     summary="Create a new category (auto slug)",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"category_name"},
     *             @OA\Property(property="category_name", type="string", example="Nước Hoa"),
     *             @OA\Property(property="status", type="string", example="active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function createCategory(Request $request)
    {

        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $existingCategory = Category::where('category_name', $validated['category_name'])->first();
        if ($existingCategory) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category already exists'
            ], 400);
        } else {
            $category = Category::create([
                'category_name' => $validated['category_name'],
                'status' => $validated['status'] ?? 'inactive',
            ]);
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id_category' => $category->id_category,
                    'category_name' => $category->category_name,
                    'slug' => $category->slug,
                    'status' => $category->status,
                    'created_at' => $category->created_at,
                    'updated_at' => $category->updated_at,
                ]
            ], 201);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/subcategories",
     *     tags={"Category"},
     *     summary="Create a new subcategory",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"category_name", "id_category"},
     *             @OA\Property(property="category_name", type="string", example="Nước hoa nữ Chanel"),
     *             @OA\Property(property="id_category", type="integer", example=2),
     *             @OA\Property(property="status", type="string", example="active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Subcategory created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function createSubCategory(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'id_category' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validated['id_category'] == 0) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Cannot create a subcategory with id_category = 0 (root category cannot be a subcategory)'
            ], 400);
        }


        $existingCategory = Category::where('id_category', $validated['id_category'])
            ->where('id_parent', 0)
            ->where('status', 'active')
            ->first();
        if (!$existingCategory) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Parent category does not exist or is not active',
            ], 400);
        } else {
            $existingSubcategory = Category::where('category_name', $validated['category_name'])
                ->where('id_parent', $validated['id_category'])
                ->first();
            if ($existingSubcategory) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Subcategory already exists',
                ], 400);
            } else {
                $subcategory = Category::create([
                    'category_name' => $validated['category_name'],
                    'id_parent' => $validated['id_category'],
                    'status' => $validated['status'] ?? 'inactive',
                ]);
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'id_subcategory' => $subcategory->id_category,
                        'category_name' => $subcategory->category_name,
                        'slug' => $subcategory->slug,
                        'status' => $subcategory->status,
                        'created_at' => $subcategory->created_at,
                        'updated_at' => $subcategory->updated_at,
                    ]
                ], 201);
            }
        }
    }
}
