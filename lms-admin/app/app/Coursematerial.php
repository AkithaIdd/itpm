<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

/**
 * Class Coursematerial
 *
 * @package App
 * @property string $coursename
 * @property string $title
 * @property string $slug
 * @property text $description
 * @property integer $position
 * @property tinyInteger $freelessons
 * @property tinyInteger $published
*/
class Coursematerial extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = ['title', 'slug', 'description', 'position', 'freelessons', 'published', 'coursename_id'];
    protected $hidden = [];
    
    

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCoursenameIdAttribute($input)
    {
        $this->attributes['coursename_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setPositionAttribute($input)
    {
        $this->attributes['position'] = $input ? $input : null;
    }
    
    public function coursename()
    {
        return $this->belongsTo(Course::class, 'coursename_id')->withTrashed();
    }
    
}
