<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'publication_date', 'image', 'order'];

    public function storeBookImage($file)
    {
        $filename = time().'-'.preg_replace('/[^A-Za-z0-9_.-]/', '', str_replace(' ', '-', $file->getClientOriginalName()));
        Storage::put('public/'.$filename, file_get_contents($file));

        return $filename;
    }
}
