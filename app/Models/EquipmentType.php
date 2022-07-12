<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    use HasFactory;

    protected $table = 'equipment_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'mask_sn',
    ];

    public const TYPE_MASK_1 = 1;
    public const TYPE_MASK_2 = 2;
    public const TYPE_MASK_3 = 3;

    public const TYPES_SN = [
        self::TYPE_MASK_1 => '/\A[A-Z0-9]{2}[A-Z]{5}[A-Z0-9]{1}[A-Z]{2}\Z/',
        self::TYPE_MASK_2 => '/\A[0-9]{1}[A-Z0-9]{2}[A-Z]{2}[A-Z0-9]{1}[-_@]{1}[A-Z0-9]{1}[a-z]{2}\Z/',
        self::TYPE_MASK_3 => '/\A[0-9]{1}[A-Z0-9]{2}[A-Z]{2}[A-Z0-9]{1}[-_@]{1}[A-Z0-9]{3}\Z/',
    ];
}
