<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *     title="PostResource",
 *     description="Post resource",
 *     @OA\Xml(
 *         name="PostResource"
 *     )
 * )
 */
class PostResource extends ResourceCollection
{
    /**
     * @OA\Property(
     *      property="data",
     *      title="Data",
     *      description="Data wrapper",
     *      type="array",
     *      @OA\Items(
     *          ref="#/components/schemas/Post"
     *      )
     * )
     *
     * @var \App\Models\Post[]
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
