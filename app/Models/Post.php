<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Post",
 *     description="Post model",
 *     @OA\Xml(
 *         name="Post"
 *     )
 * )
 */
class Post extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *      property="id",
     *      title="ID",
     *      description="ID wrapper",
     *      type="integer",
     *      example=1
     * )
     *
     * @var integer
     */
    protected $fillable = [
        "title",
        "content",
        "image"
    ];

    protected $casts = [
        "created_at" => "datetime:Y-m-d H:m:s",
        "updated_at" => "datetime:Y-m-d H:m:s",
    ];

    /**
     * @OA\Property(
     *      property="title",
     *      title="Title",
     *      description="Title wrapper",
     *      type="string",
     *      example="Lorem ipsum dolor sit amet"
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @OA\Property(
     *      property="content",
     *      title="Content",
     *      description="Content wrapper",
     *      type="string",
     *      example="Lorem ipsum dolor sit amet"
     * )
     *
     * @var string
     */
    private $content;

    /**
     * @OA\Property(
     *      property="image",
     *      title="Image",
     *      description="Image wrapper",
     *      type="string",
     *      example="https://via.placeholder.com/150"
     * )
     *
     * @var string
     */
    private $image;
}
