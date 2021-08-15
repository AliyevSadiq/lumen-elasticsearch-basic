<?php


namespace App\Models;


use App\Services\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'articles';

    protected $guarded = [];


    public static function insertRules(): array
    {
        return [
            'title' => 'required|unique:articles',
            'description' => 'nullable'
        ];
    }

    public static function updateRules(): array
    {
        return [
            'title' => 'required',
            'description' => 'nullable'
        ];
    }

    public static function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.unique' => 'Title is used',
        ];
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucfirst($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ucfirst(strip_tags($value));
    }
}
