<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Storage;

class Book extends Model
{
    protected $fillable = ['user_id', 'title', 'author', 'publication_date', 'image', 'order'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user_id', function (Builder $builder) {
            $builder->where('user_id', auth()->user()->id);
        });
    }

    public function storeBookImage($file)
    {
        $filename = time().'-'.preg_replace('/[^A-Za-z0-9_.-]/', '', str_replace(' ', '-', $file->getClientOriginalName()));
        Storage::put('public/'.$filename, file_get_contents($file));

        return $filename;
    }
}
