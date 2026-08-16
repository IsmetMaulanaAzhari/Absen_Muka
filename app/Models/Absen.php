<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'face_signature'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function findMatchingFace(string $faceSignature, int $threshold = 8): ?self
    {
        $candidate = trim($faceSignature);

        if ($candidate === '') {
            return null;
        }

        return static::whereNotNull('face_signature')
            ->get()
            ->first(function ($absen) use ($candidate, $threshold) {
                $distance = static::calculateDistance($candidate, $absen->face_signature);

                return $distance <= $threshold;
            });
    }

    protected static function calculateDistance(string $leftSignature, ?string $rightSignature): int
    {
        if (blank($rightSignature)) {
            return PHP_INT_MAX;
        }

        $leftBits = static::hexToBinary($leftSignature);
        $rightBits = static::hexToBinary($rightSignature);
        $length = max(strlen($leftBits), strlen($rightBits));

        $leftBits = str_pad($leftBits, $length, '0', STR_PAD_RIGHT);
        $rightBits = str_pad($rightBits, $length, '0', STR_PAD_RIGHT);

        $distance = 0;

        for ($i = 0; $i < $length; $i++) {
            if ($leftBits[$i] !== $rightBits[$i]) {
                $distance++;
            }
        }

        return $distance;
    }

    protected static function hexToBinary(string $signature): string
    {
        $signature = strtoupper(trim($signature));
        $binary = '';

        foreach (str_split($signature) as $char) {
            $value = hexdec($char);
            $binary .= str_pad(decbin($value), 4, '0', STR_PAD_LEFT);
        }

        return $binary;
    }
}