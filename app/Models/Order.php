<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'export_date',
        'user_id',
        'source_area_id',
        'category_id',
        'product_name',
        'count',
        'weight',
        'net_weight',
        'unit_id',
        'price',
        'total',
        'status',
        'remark',
        'shop_id',
        'gate_id',
        'weightfee'
    ];
    protected $with = ['user', 'category', 'sourceArea', 'unit', 'shop', 'gate'];
    public function getCategoryNameAttribute()
    {
        return $this->category['name'] ?? 'N/A';
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function sourceArea()
    {
        return $this->belongsTo(SourceArea::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function gate()
    {
        return $this->belongsTo(Gate::class);
    }
    public function scopeFilter($query, $filter)
    {
        $query->when($filter['status'] ?? false, function ($query, $status) {
            $query->where('status', $status);
        });
        $query->when($filter['shop']?? false, function ($query, $shop){
            if($shop == "all"){
                $query->whereNotNull('shop_id');
            }
            else{
                $query->whereHas('shop', function ($q) use($shop){
                    $q->where('name', $shop);
                });
            }
        });
        $query->when($filter['from_date'] ?? false, function ($query, $from_date) {
            $query->whereDate('export_date', '>=', $from_date);
        });
        $query->when($filter['to_date'] ?? false, function ($query, $to_date) {
            $query->whereDate('export_date', '<=', $to_date);
        });
        $query->when($filter['nameunit'] ?? false, function ($query, $nameunit) {
            $query->where(function ($q) use ($nameunit) {
                $q->where('product_name', 'like', "%{$nameunit}%")
                    ->orWhereHas('unit', function ($q) use ($nameunit){
                        $q->where('name', $nameunit);
                    });
            });
        });
    }
}
