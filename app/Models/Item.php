<?php

namespace App\Models;

use App\DataTables\ItemTable;
use App\Traits\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLaTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Item extends Model
{

    use HasFactory;

    public const STATE_PUBLISHED = 'published';
    const STATE_DRAFT = 'draft';

    protected $hidden = [
        "created_at",
        'updated_at',
        //"company_id",
        "category_id", "user_id", "unit_id",
    ];

    protected $fillable = [
        'name',
        'image',
        'category_id',
        'unit_id',
        'company_id',
        'description',
        'price'

    ];



    public function product()
    {
        return $this->hasOne(Product::class);
    }

    public function book()
    {
        return $this->hasOne(Book::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class)->with('currency');
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }



    public function getCurrencySymbol()
    {
        return $this->currency->symbol;
    }

    public function getCurrencyName()
    {
        return $this->currency->name;
    }

    public function getCurrencyCode()
    {
        return $this->currency->code;
    }

    // currency relation
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }



    public function status()
    {
        return $this->state();
    }

    public function visits()
    {
        return visits($this)->count();
    }

    public function image()
    {
        if (!empty($this->image)) {
            $file = 'storage/companies/' . $this->company_id . '/items/' . $this->image;
            if (file_exists($file)) {
                return asset($file);
            }
        }
        return $this->company->logo();
    }


    public function imageSmall()
    {
        return $this->image_small();
    }

    public function title()
    {
        return  $this->name . ' - ' . $this->selling_price . ' ' . $this->company->currency->symbol . ' | ' . $this->company->name;
    }


    public function image_small()
    {
        if (!empty($this->image)) {
            $original = 'storage/companies/' . $this->company_id . '/items/' . $this->image;
            $small = 'storage/companies/' . $this->company_id . '/items/small/' . $this->image;

            if (file_exists($small)) {
                return asset($small);
            }

            if (file_exists($original)) {
                //Create thumbnail

                $thumbnail = Image::make($original);
                $thumbnail->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $thumbnail->stream();
                //store thumbnail
                $created = Storage::put('public/companies/' . $this->company_id . '/items/small/' . $this->image, $thumbnail);
                if ($created) {
                    return $this->image_small();
                }
            }
        }
        return $this->company->logo();
        // return null;
    }

    public function delete_image()
    {
        if (!empty($this->image)) {

            $file1 = 'public/companies/' . $this->company_id . '/items/small/' . $this->image;
            $file2 = 'public/companies/' . $this->company_id . '/items/' . $this->image;

            return Storage::delete([$file1, $file2]);
        }
    }

    public function delete(): ?bool
    {
        $this->delete_image();
        return parent::delete();
    }
}
