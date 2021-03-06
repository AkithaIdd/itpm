<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

/**
 * Class Library
 *
 * @package App
 * @property string $coursename
*/
class Library extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = ['coursename_id'];
    protected $hidden = [];
    
    

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCoursenameIdAttribute($input)
    {
        $this->attributes['coursename_id'] = $input ? $input : null;
    }
    
    public function coursename()
    {
        return $this->belongsTo(Course::class, 'coursename_id')->withTrashed();
    }
    
}
