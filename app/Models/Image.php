<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    public function user() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function getUrl() {
        $domain = $this->user()->firstOrFail()->defaultDomain();

        return 'https://' . $domain->sub . '.' . $domain->domain . '/' . $this->slug;
    }

    //public function domain() {
    //    return $this->belongsTo('')
    //}
}
