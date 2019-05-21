<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

/**
 * Class Notice
 *
 * @package App
 * @property integer $posision
 * @property string $title
 * @property text $body
*/
class Notice extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = ['posision', 'title', 'body'];
    protected $hidden = [];
    
    

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setPosisionAttribute($input)
    {
        $this->attributes['posision'] = $input ? $input : null;
    }
    
}
