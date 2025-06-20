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
                    $product->image = url($product->image);
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
                    $product->image = url($product->image);
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
                    $product->image = url($product->image);
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
                    $product->image = url($product->image);
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
     *     path="/api/products/{id_product}",
     *     tags={"Product"},
     *     summary="Get product detail by product ID",
     *     @OA\Parameter(
     *         name="id_product",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product detail",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function getProductDetail($id_product)
    {
        $product = Product::find($id_product);

        if (!$product) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Product not found'
            ], 404);
        } else {
            $product->increment('views');

            if ($product->image) {
                $product->image = url($product->image);
            }
            return response()->json([
                'status' => 'success',
                'data' => $product
            ], 200);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/products",
     *     tags={"Product"},
     *     summary="Create a new product with image upload",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "id_category", "price", "image"},
     *                 @OA\Property(property="name", type="string", example="Chanel J12"),
     *                 @OA\Property(property="id_category", type="integer", example=1),
     *                 @OA\Property(property="price", type="number", example=1000000),
     *                 @OA\Property(property="image", type="string", format="binary"),
     *                 @OA\Property(property="rating", type="integer", example=5),
     *                 @OA\Property(property="gender", type="string", example="Nữ"),
     *                 @OA\Property(property="volume", type="integer", example=100),
     *                 @OA\Property(property="type", type="string", example="Quartz"),
     *                 @OA\Property(property="quantity", type="integer", example=10),
     *                 @OA\Property(property="views", type="integer", example=0),
     *                 @OA\Property(property="discount", type="number", example=0),
     *                 @OA\Property(property="description", type="string", example="Mô tả sản phẩm"),
     *                 @OA\Property(property="note", type="string", example="Ghi chú"),
     *                 @OA\Property(property="status", type="string", example="active"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
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
    public function createProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_category' => 'required|integer|exists:categories,id_category',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
            'rating' => 'nullable|integer|min:0|max:5',
            'gender' => 'nullable|string',
            'volume' => 'nullable|integer',
            'type' => 'nullable|string',
            'quantity' => 'nullable|integer',
            'views' => 'nullable|integer',
            'discount' => 'nullable|numeric',
            'description' => 'nullable|string',
            'note' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ]);
        // kiểm tra tất cả các trường bắt buộc đã được cung cấp của validated
        if (empty($validated['name']) || empty($validated['id_category']) || empty($validated['price']) || empty($validated['image'])) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Missing required fields'
            ], 400);
        }
        $category = Category::find($validated['id_category']);
        if (!$category) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category not found'
            ], 404);
        } else {
            // Khởi tạo đường dẫn hình ảnh
            $path = null;
            // Xử lý upload hình ảnh
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $folder = 'images/products/' . date('Y/m/d');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($folder), $filename);
                $path = $folder . '/' . $filename;
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Image upload failed'
                ], 400);
            }
            // Tạo sản phẩm mới
            $product = Product::create([
                'name' => $validated['name'],
                'id_category' => $validated['id_category'],
                'price' => $validated['price'],
                'image' => $path,
                'rating' => $validated['rating'] ?? 0,
                'gender' => $validated['gender'] ?? null,
                'volume' => $validated['volume'] ?? null,
                'type' => $validated['type'] ?? null,
                'quantity' => $validated['quantity'] ?? null,
                'views' => $validated['views'] ?? 0,
                'discount' => $validated['discount'] ?? null,
                'description' => $validated['description'] ?? null,
                'note' => $validated['note'] ?? null,
                'status' => $validated['status'] ?? 'inactive',
            ]);
            if (!$product) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product creation failed'
                ], 500);
            } else {
                $product->image = url($product->image); // Chuyển đổi đường dẫn hình ảnh sang URL đầy đủ
                return response()->json([
                    'status' => 'success',
                    'data' => $product
                ], 201);
            }
        }
    }
}
