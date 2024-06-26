<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Click extends Model
{
    use  HasFactory;


    public function get_redirect($id)
    {
        return DB::table('campaigns_links')
                ->where('link_token',$id)
                ->pluck('tagged_url');

    }

}
