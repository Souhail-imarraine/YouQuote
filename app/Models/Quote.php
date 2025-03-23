<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


class Quote extends Model
{
    use HasFactory;
    use HasRoles;


    /**
     * Les champs qui peuvent être remplis massivement.
     *
     * @var array<string>
     */
    protected $fillable = [
        'content',
        'author',
        'popularity',
        'role',
        'user_id',
    ];

    /**
     * Les champs qui doivent être cachés lors de la sérialisation.
     *
     * @var array<string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relation avec le modèle User.
     * Une citation appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'quote_tag');
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'quote_user')->withTimestamps();
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

}
