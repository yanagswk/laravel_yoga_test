<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\Lesson;
use App\Models\Reservation;
use App\Models\User;


class LessonControllerTest extends TestCase
{
    // テスト実行時にデータベースを再構築
    use RefreshDatabase;

    /**
     * @param int $capacity lessonモデルの募集人数
     * @param int $reservationCount 予約回数
     * @param string $expectedVacancyLevelMark 記号
     * @dataProvider dataShow
     */
    public function testShow(
        int $capacity,
        int $reservationCount,
        string $expectedVacancyLevelMark
    ) {
        // テストデータ作成
        $lesson = factory(Lesson::class)->create([
            'name' => '楽しいヨガレッスン',
            'capacity' => $capacity
        ]);

        // 予約回数分、userのfactoryを作る
        for ($i = 0; $i < $reservationCount; $i++) {
            $user = factory(User::class)->create();
            factory(Reservation::class)->create([
                'lesson_id' => $lesson->id,
                'user_id' => $user->id
            ]);
        }

        // postリクエストの時はpost()を指定
        $response = $this->get("/lessons/{$lesson->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee($lesson->name);
        $response->assertSee("空き状況: {$expectedVacancyLevelMark}");
    }

    public function dataShow()
    {
        return [
            '空き十分' => [
                'capacity' => 6,
                'reservationCount' => 1,
                'expectedVacancyLevelMark' => '◎',
            ],
            '空きわずか' => [
                'capacity' => 6,
                'reservationCount' => 2,
                'expectedVacancyLevelMark' => '△',
            ],
            '空きなし' => [
                'capacity' => 1,
                'reservationCount' => 1,
                'expectedVacancyLevelMark' => '×',
            ],
        ];
    }
}
