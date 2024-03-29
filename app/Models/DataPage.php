<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPage extends Model
{
    use HasFactory;

    protected $table = 'data_pages';

     // Columns that are mass assignable
     protected $fillable = [
        'url',
        'url_code',
        'event_type',
        'title',
        'referrer',
        'device_type',
        'session_start',
        'project_code',
        'session_id',
        'hostname',
        'protocol',
        'pathname',
        'language',
        'bounce',
        'entrance',
        'exits',
        'meta_description',
        'cookie_enabled',
        'screen_width',
        'screen_height',
        'history_length',
        'word_count',
        'form_count',
        'inbound_links',
        'outbound_links',
        'analyzed',
        'analyzed_at',
        'owner_id'
    ];

     // For example, if 'owner_id' refers to a User model
     public function project() {
        return $this->belongsTo(Project::class, 'project_code', 'project_code');
    }
    public static function countIncomingLinks($urlCode,$projectCode)
    {
        $dataPage = self::where('url_code', $urlCode)
                        ->where('project_code', $projectCode)
                        ->first();

        if (!$dataPage || is_null($dataPage->inbound_links)) {
            return 0;
        }

        // Deserialize the inbound_links data
        $inboundLinks = unserialize($dataPage->inbound_links);

        return is_array($inboundLinks) ? count($inboundLinks) : 0;
    }
}
