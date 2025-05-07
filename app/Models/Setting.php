<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'navbar_background',
        'sidebar_background',
        'button_color',
        'input_color',
        'text_color',
        'icon_color',
        'background_color'
    ];


    public function getImage()
    {
        return asset($this->logo);
    }
}
