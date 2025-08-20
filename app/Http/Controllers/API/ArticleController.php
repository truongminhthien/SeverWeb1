<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Article;

class ArticleController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/articles",
     *     tags={"Article"},
     *     summary="Get all articles",
     *     @OA\Response(
     *         response=200,
     *         description="List of all articles",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="articles",
     *                 type="array",
     *                 @OA\Items(type="object")
     *             )
     *         )
     *     )
     * )
     */
    public function getAllArticle()

    {
        $articles = Article::orderByDesc('created_at')
            ->where('status', '!=', 'deleted')
            ->get();

        return response()->json([
            'status' => 'success',
            'articles' => $articles->map(function ($article) {
                return [
                    'id_articles' => $article->id_articles,
                    'title' => $article->title,
                    'content' => $article->content,
                    'image' => $article->image ? url($article->image) : null,
                    'status' => $article->status,
                    'created_at' => $article->created_at,
                    'updated_at' => $article->updated_at,
                ];
            })
        ], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/articles",
     *     tags={"Article"},
     *     summary="Create a new article",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"title", "content", "status", "image", "id_user"},
     *                 @OA\Property(property="id_user", type="integer", example=1, description="User ID"),
     *                 @OA\Property(property="title", type="string", example="Bí quyết chăm sóc da"),
     *                 @OA\Property(property="content", type="string", example="Nội dung bài viết..."),
     *                 @OA\Property(property="status", type="string", example="draft"),
     *                 @OA\Property(property="image", type="string", format="binary", description="Article image"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Article created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="article", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function createArticle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|integer|exists:users,id_user',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|string|in:draft,published,deleted',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/articles'), $filename);
            $imagePath = 'uploads/articles/' . $filename;
        }

        $article = Article::create([
            'id_user' => $request->id_user,
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => 'success',
            'article' => [
                'id_articles' => $article->id_articles,
                'id_user' => $article->id_user,
                'title' => $article->title,
                'content' => $article->content,
                'image' => $article->image ? url($article->image) : null,
                'status' => $article->status,
                'created_at' => $article->created_at,
                'updated_at' => $article->updated_at,
            ]
        ], 201);
    }


    /**
     * @OA\Post(
     *     path="/api/articles/{id_articles}",
     *     tags={"Article"},
     *     summary="Update an article",
     *     @OA\Parameter(
     *         name="id_articles",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="title", type="string", example="Tiêu đề mới"),
     *                 @OA\Property(property="content", type="string", example="Nội dung mới..."),
     *                 @OA\Property(property="status", type="string", example="published"),
     *                 @OA\Property(property="image", type="string", format="binary", description="Article image")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="article", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function updateArticle(Request $request, $id_articles)
    {
        $article = Article::find($id_articles);
        if (!$article) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Article not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'status' => 'sometimes|string|in:draft,published,deleted',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        // Cập nhật các trường
        foreach ($validator->validated() as $key => $value) {
            if ($key !== 'image') {
                $article->$key = $value;
            }
        }

        // Xử lý upload hình ảnh mới nếu có
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/articles'), $filename);
            $imagePath = 'uploads/articles/' . $filename;

            // Xóa ảnh cũ nếu có
            if ($article->image && file_exists(public_path($article->image))) {
                @unlink(public_path($article->image));
            }
            $article->image = $imagePath;
        }

        $article->save();

        return response()->json([
            'status' => 'success',
            'article' => [
                'id_articles' => $article->id_articles,
                'id_user' => $article->id_user,
                'title' => $article->title,
                'content' => $article->content,
                'image' => $article->image ? url($article->image) : null,
                'status' => $article->status,
                'created_at' => $article->created_at,
                'updated_at' => $article->updated_at,
            ]
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/articles/{id_articles}",
     *     tags={"Article"},
     *     summary="Delete an article by ID",
     *     @OA\Parameter(
     *         name="id_articles",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Article deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found"
     *     )
     * )
     */
    public function deleteArticle($id_articles)
    {
        $article = Article::find($id_articles);
        if (!$article) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Article not found'
            ], 404);
        }

        $article->status = 'deleted';
        $article->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Article deleted successfully'
        ]);
    }
}
