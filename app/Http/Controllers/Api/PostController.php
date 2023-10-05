<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="My API", version="0.1")
 */
class PostController extends ApiController
{
    /**
     * @OA\Get(
     *    path="/posts",
     *    operationId="getPostsList",
     *    tags={"Posts"},
     *    summary="Get list of posts",
     *    description="Returns list of posts",
     *    @OA\Response(
     *       response=200,
     *       description="Successful operation",
     *       @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/PostResource")
     *      )
     *    ),
     *    @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * )
     */
    public function index()
    {
        $keyword = request()->query("keyword");

        if ($keyword) {
            $posts = Post::where("title", "LIKE", "%{$keyword}%")
                ->orWhere("content", "LIKE", "%{$keyword}%")
                ->get();
        } else {
            $posts = Post::all();
        }

        return response()->json([
            "status" => "success",
            "message" => "Data post berhasil ditampilkan",
            "data" => $posts,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/posts",
     *     operationId="storePost",
     *     tags={"Posts"},
     *     summary="Store new post",
     *     description="Returns post data",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Pass post data",
     *          @OA\JsonContent(
     *              required={"title","content","image"},
     *              @OA\Property(property="title", type="string", format="text", example="Post Title"),
     *              @OA\Property(property="content", type="string", format="text", example="Post Content"),
     *              @OA\Property(property="image", type="string", format="image", example="Post Image"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PostResource")
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     *  )
     */
    public function store(Request $request)
    {
        $validate = validator(
            $request->only("title", "content", "image"),
            [
                "title" => ["required", "max:255"],
                "content" => ["required"],
                "image" => ["required", "max:255"],
            ]
        );

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $post = Post::create($request->all());
        return response()->json([
            "status" => "success",
            "message" => "Data post berhasil ditambahkan",
            "data" => $post,
        ], 201);
    }

    /**
     * @OA\Get(
     *    path="/posts/{id}",
     *    operationId="getPostById",
     *    tags={"Posts"},
     *    summary="Get post information",
     *    description="Returns post data",
     *    @OA\Parameter(
     *      name="id",
     *      description="Post id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *          format="int64"
     *      )
     *    ),
     *    @OA\Response(
     *       response=200,
     *       description="Successful operation",
     *       @OA\JsonContent(ref="#/components/schemas/PostResource")
     *    ),
     *    @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * )
     */
    public function show(Post $post)
    {
        return response()->json([
            "status" => "success",
            "message" => "Data post berhasil ditampilkan",
            "data" => $post,
        ]);
    }

    /**
     * @OA\Put(
     *     path="/posts/{id}",
     *     operationId="updatePost",
     *     tags={"Posts"},
     *     summary="Update existing post",
     *     description="Returns updated post data",
     *     @OA\Parameter(
     *         description="Post id",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Pass post data",
     *          @OA\JsonContent(
     *              required={"title","content","image"},
     *              @OA\Property(property="title", type="string", format="text", example="Post Title"),
     *              @OA\Property(property="content", type="string", format="text", example="Post Content"),
     *              @OA\Property(property="image", type="string", format="image", example="Post Image"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PostResource")
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     *  )
     */
    public function update(Request $request, Post $post)
    {
        $validate = validator(
            $request->only("title", "content", "image"),
            [
                "title" => ["required", "max:255"],
                "content" => ["required"],
                "image" => ["required", "max:255"],
            ]
        );

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $post->update($request->all());
        return response()->json([
            "status" => "success",
            "message" => "Data post berhasil diupdate",
            "data" => $post,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/posts/{id}",
     *     operationId="deletePost",
     *     tags={"Posts"},
     *     summary="Delete existing post",
     *     description="Deletes a record and returns no content",
     *     @OA\Parameter(
     *         description="Post id",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PostResource")
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     *  )
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(null, 204);
    }

    /**
     * @OA\Post(
     *     path="/posts/image",
     *     operationId="uploadImage",
     *     tags={"Posts"},
     *     summary="Upload image",
     *     description="Returns image URL",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Pass image data",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"image"},
     *                  @OA\Property(property="image", type="file", format="image", example="Post Image"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              required={"url"},
     *              @OA\Property(property="url", type="string", example="https://example.com/storage/images/1234567890.jpg"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     *  )
     */
    public function uploadImage(Request $request)
    {
        $validate = validator(
            $request->only("image"),
            [
                "image" => ["required", "image", "max:2048"],
            ]
        );

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $image = $request->file("image");
        $image->storeAs("public/images", $image->hashName());

        return response()->json(["url" => asset("storage/images/" . $image->hashName())]);
    }
}
