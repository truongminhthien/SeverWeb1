<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     @OA\Property(property="id_product", type="integer", example=1),
 *     @OA\Property(property="id_category", type="integer", example=2),
 *     @OA\Property(property="name", type="string", example="Nước Hoa Chanel"),
 *     @OA\Property(property="image", type="string", example="chanel.jpg"),
 *     @OA\Property(property="price", type="integer", example=1000000),
 *     @OA\Property(property="rating", type="integer", example=4),
 *     @OA\Property(property="gender", type="string", example="female"),
 *     @OA\Property(property="volume", type="integer", example=50),
 *     @OA\Property(property="type", type="string", example="Eau de Parfum"),
 *     @OA\Property(property="quantity", type="integer", example=10),
 *     @OA\Property(property="views", type="integer", example=100),
 *     @OA\Property(property="discount", type="number", format="float", example=10.50),
 *     @OA\Property(property="description", type="string", example="Hương thơm quyến rũ..."),
 *     @OA\Property(property="note", type="string", example="Lưu ý khi sử dụng..."),
 *     @OA\Property(property="status", type="string", enum={"active", "inactive"}, example="active"),
 * )
 */

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/featured-products",
     *     operationId="getFeaturedProducts",
     *     tags={"Product"},
     *     summary="Get list of featured products (rating >= 4)",
     *     description="Returns a list of featured products with a rating greater than or equal to 4 and active status.",
     *     @OA\Response(
     *         response=200,
     *         description="List of featured products",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Product")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No featured products found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="No featured products found")
     *         )
     *     )
     * )
     */
    public function featuredProduct()
    {
        $products = Product::where('rating', '>=', 4)
            ->where('status', 'active')
            ->limit(20)
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No featured products found'
            ], 404);
        } else {
            $products->transform(function ($product) {
                if ($product->image) {
                    $product->image = url('images/' . $product->image);
                }
                return $product;
            });
            return response()->json([
                'status' => 'success',
                'data' => $products
            ], 200);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/new-products",
     *     tags={"Product"},
     *     summary="Get newest products (order by created_at desc)",
     *     @OA\Response(
     *         response=200,
     *         description="List of newest products",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Product"))
     *     )
     * )
     */
    public function newProduct()
    {
        $products = Product::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        if ($products->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No new products found'
            ], 404);
        } else {
            $products->transform(function ($product) {
                if ($product->image) {
                    $product->image = url('images/' . $product->image);
                }
                return $product;
            });
            return response()->json([
                'status' => 'success',
                'data' => $products
            ], 200);
        }
    }



    /**
     * @OA\Get(
     *     path="/api/products-by-subcategory/{id_subcategory}",
     *     tags={"Product"},
     *     summary="Get products by category id_subcategory",
     *     @OA\Parameter(
     *         name="id_subcategory",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of products by category",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Product")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No products found"
     *     )
     * )
     */
    public function productsBySubCategory($id_subcategory)
    {
        $products = Product::where('id_category', $id_subcategory)->with('category')
            ->where('status', 'active')
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No products found'
            ], 404);
        } else {
            $products->transform(function ($product) {
                if ($product->image) {
                    $product->image = url('images/' . $product->image);
                }
                return $product;
            });

            return response()->json([
                'status' => 'success',
                'data' => $products
            ], 200);
        }
    }



    /**
     * @OA\Get(
     *     path="/api/products-by-category/{id_category}",
     *     tags={"Product"},
     *     summary="Get all products of category (all child categories included)",
     *     @OA\Parameter(
     *         name="id_category",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of products by category",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Product")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No products found"
     *     )
     * )
     */
    public function getProductsByCategory($id_category)
    {

        $categoryIds = Category::where('id_parent', $id_category)->pluck('id_category');
        $products = Product::whereIn('id_category', $categoryIds)->with('category')
            ->where('status', 'active')
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No products found'
            ], 404);
        } else {
            $products->transform(function ($product) {
                if ($product->image) {
                    $product->image = url('images/' . $product->image);
                }
                return $product;
            });
            return response()->json([
                'status' => 'success',
                'data' => $products

            ], 200);
        }
    }
}
