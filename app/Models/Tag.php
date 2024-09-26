<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;
class Tag extends Model
{
    use HasTags;

    public static function getTagClassName(): string
    {
        return YourTagModel::class;
    }
}
