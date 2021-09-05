<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\Lesson;


class LessonControllerTest extends TestCase
{
    // テスト実行時にデータベースを再構築
    use RefreshDatabase;

    public function testShow()
    {
        // テストデータ作成
        $lesson = factory(Lesson::class)->create(['name' => '楽しいヨガレッスン']);

        // postリクエストの時はpost()を指定
        $response = $this->get("/lessons/{$lesson->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee($lesson->name);
        $response->assertSee('空き状況: ×');
    }
}
