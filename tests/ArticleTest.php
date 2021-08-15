<?php


use App\Models\Article;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ArticleTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_create_article()
    {
        $data = $this->simulateData();
        $this->post('/api/articles', $data);
        $this->assertSame(Article::find(1)->title, $data['title']);
    }

    private function simulateData(): array
    {
        $faker = \Faker\Factory::create();
        return [
            'title' => ucfirst($faker->unique()->paragraph(1)),
            'description' => ucfirst($faker->paragraph(20)),
        ];
    }

    /**
     * @test
     */
    public function can_delete_article()
    {
        $article = Article::factory()->create();
        $this->delete('/api/articles/' . $article->id)
            ->assertResponseStatus(Response::HTTP_NO_CONTENT);
        $this->assertNull(Article::find(1));

    }

}
