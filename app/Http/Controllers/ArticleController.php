<?php


namespace App\Http\Controllers;


use App\Contract\ArticleRepository;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;


class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/articles",
     *      tags={"Article"},
     *      summary="Get list of article",
     *      description="Returns list of article",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *     )
     */
    public function index(): AnonymousResourceCollection
    {

        $articles = Article::paginate(10);
        if (Cache::get('articles')) {
            $articles = Cache::get('articles');
        }

        return ArticleResource::collection($articles);
    }

    /**
     * @OA\Get(
     *      path="/api/articles/search",
     *     tags={"Article"},
     *      summary="Get article information by search query",
     *      description="Returns article data",
     *      @OA\Parameter(
     *          name="query",
     *          description="Searching query",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     * )
     */
    public function search(ArticleRepository $repository): AnonymousResourceCollection
    {
        $results = $repository->search(\request()->input('query'));
        return ArticleResource::collection($results);
    }

    /**
     * @OA\Get(
     *      path="/api/articles/{id}",
     *     tags={"Article"},
     *      summary="Get article information",
     *      description="Returns article data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Article id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     * )
     */

    public function edit($id)
    {
        $article = Article::find($id);
        if ($article) {
            return new ArticleResource($article);
        }
        return response()->json(['success' => false, 'message' => 'not found'])->setStatusCode(Response::HTTP_NOT_FOUND);

    }

    /**
     * @OA\Post(
     *      path="/api/articles",
     *       tags={"Article"},
     *      summary="Store new article",
     *      description="Returns article data",
     *      @OA\RequestBody(
     *          required=true,
     *     @OA\JsonContent(ref="#/components/schemas/ArticleStoreRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *     )
     */
    public function store(Request $request): ArticleResource
    {
        $this->validate($request, Article::insertRules(), Article::messages());
        $article = Article::create([
            'title' => $request->input('title'),
            'description' => $request->input('description')
        ]);

        return new ArticleResource($article);
    }

    /**
     * @OA\Delete(
     *      tags={"Article"},
     *      path="/api/articles/{id}",
     *      summary="Delete existing article",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Article id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation"
     *       )
     * )
     */

    public function delete($id): JsonResponse
    {
        $article = Article::find($id);
        if ($article) {
            $article->delete();
            return response()->json(['success' => true, 'message' => 'deleted'])->setStatusCode(Response::HTTP_NO_CONTENT);
        }
        return response()->json(['success' => false, 'message' => 'not found'])->setStatusCode(Response::HTTP_NOT_FOUND);
    }

}
