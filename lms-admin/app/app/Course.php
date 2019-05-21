<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

/**
 * Class Course
 *
 * @package App
 * @property string $coursename
 * @property text $description
 * @property decimal $price
 * @property string $startdate
 * @property tinyInteger $published
*/
class Course extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = ['coursename', 'description', 'price', 'startdate', 'published'];
    protected $hidden = [];
    
    

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setPriceAttribute($input)
    {
        $this->attributes['price'] = $input ? $input : null;
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setStartdateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['startdate'] = Carbon::createFromFormat(config('app.date_format') . ' H:i:s', $input)->format('Y-m-d H:i:s');
        } else {
            $this->attributes['startdate'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getStartdateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format') . ' H:i:s');

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $input)->format(config('app.date_format') . ' H:i:s');
        } else {
            return '';
        }
    }
    
    public function teacher()
    {
        return $this->belongsToMany(User::class, 'course_user');
    }
    public function coursematerials(){
        return $this->hasMany(Coursematerial::class)->orderBy('position');
    }
    
}
