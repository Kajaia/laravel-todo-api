<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function getFilteredTasks(Request $request) 
    {
        return $this->when($request->search, function($query) use ($request) {
                $query->where('title', 'LIKE', "%$request->search%");
            })->when($request->status, function($query) use ($request) {
                if($request->status === 'active') {
                    $query->where('status', false);
                } elseif($request->status === 'completed') {
                    $query->where('status', true);
                }
            })->orderBy($request->sortBy ?? 'id', $request->sortDirection ?? 'desc')
            ->paginate($request->paginate ?? 10);
    }
}
