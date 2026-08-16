<?php

namespace Tests\Feature;

use App\Models\Absen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaceRecognitionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_detects_a_matching_face_signature(): void
    {
        Absen::create([
            'image' => 'absen/2026/08/16/sample.png',
            'face_signature' => 'a1b2c3d4e5f6a7b8',
        ]);

        $match = Absen::findMatchingFace('a1b2c3d4e5f6a7b8');

        $this->assertNotNull($match);
        $this->assertEquals('a1b2c3d4e5f6a7b8', $match->face_signature);
    }

    public function test_it_does_not_match_a_different_face_signature(): void
    {
        Absen::create([
            'image' => 'absen/2026/08/16/sample.png',
            'face_signature' => 'a1b2c3d4e5f6a7b8',
        ]);

        $match = Absen::findMatchingFace('ffff0000eeee1111');

        $this->assertNull($match);
    }
}
