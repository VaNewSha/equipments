<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    use HasFactory;

    protected $table = 'equipment_types';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'mask_sn',
    ];

    public const MASK_N = '[0-9]{1}';
    public const MASK_A = '[A-Z]{1}';
    public const MASK_a = '[a-z]{1}';
    public const MASK_X = '[A-Z0-9]{1}';
    public const MASK_Z = '[-_@]{1}';

    public const TYPES_SN = [
        'N' => self::MASK_N,
        'A' => self::MASK_A,
        'a' => self::MASK_a,
        'X' => self::MASK_X,
        'Z' => self::MASK_Z,
    ];
}
