<?php


namespace App\Virtual;

/**
 * @OA\Schema(
 *     title="Article Store",
 *     description="Article model",
 *     @OA\Xml(
 *         name="Article Store"
 *     )
 * )
 */
class ArticleStoreRequest
{

    /**
     * @OA\Property(
     *      title="Title",
     *      description="Title of the new claim",
     *      type="String",
     *      example="testing"
     * )
     */
    public string $title;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description of the new claim",
     *      type="String",
     *      example="testings[oidh asdy pasiugdp gapsiufgapsiudg paisudgpaiusgdp iaugdpaisugd"
     * )
     */
    public string $description;


}
