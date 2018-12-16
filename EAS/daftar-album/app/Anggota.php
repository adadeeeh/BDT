<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'album_list';

    protected $fillable = [
        'band', 'anggota'
    ];
}
