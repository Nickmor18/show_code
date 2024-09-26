<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'customers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'gender', 'date_of_birth', 'email', 'notes', 'phone', 'password'
    ];

    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'customer_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     *
     * @param $phone
     * @return User
     */
    public static function createUserByPhone($phone) : User
    {
        $newUser = new User;
        $newUser->phone = $phone;
        $newUser->save();

        $userCart = Cart::createNewCart($newUser->id);
        $newUser->cart = $userCart;

        return $newUser;
    }

    public static function createEmptyUserByDeviceId($deviceId) : User
    {
        $newUser = new User;
        $newUser->device_id = $deviceId;
        $newUser->save();

        $userCart = Cart::createNewCart($newUser->id);
        $newUser->cart = $userCart;

        return $newUser;
    }
}
