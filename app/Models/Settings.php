<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';
    protected $fillable = [
        'background_color',
        'text_color',
        'button_color',
        'btn_primary',
        'login_button_color',
        'login_text_color',
    ];
}
