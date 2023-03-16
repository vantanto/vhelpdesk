<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    use HasFactory;

    public static $Priorities = [
        'low', 'medium', 'high'
    ];

    public static $Status = [
        'waiting', 'in_progress', 'done', 'cancelled'
    ];

    public static $FilePath = 'files/ticket/';

    protected $fillable = [
        'code',
        'title',
        'description',
        'priority',
        'status',
        'category_id',
        'due_date',
        'files',
        'user_id',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'files' => 'array',
    ];

    public function generateCode()
    {
        return strtoupper(
            substr($this->priority, 0, 1)
                . ($this->due_date ? 'D' : 'N')
                . str_pad($this->id, 5, '0', STR_PAD_LEFT)
        );
    }

    public function scopeUser(Builder $query): void
    {
        $query->where('tickets.user_id', Auth::user()->id);
    }

    public function scopeDetail(Builder $query): void
    {
        $query->where(
            fn ($query2) => $query2
                ->whereHas('departments', fn ($query3) => $query3->whereIn('id', Auth::user()->departments->pluck('id')->toArray()))
                ->orWhere('tickets.user_id', Auth::user()->id)
        );
    }

    public function assigneds()
    {
        return $this->belongsToMany(User::class, 'assigneds');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
