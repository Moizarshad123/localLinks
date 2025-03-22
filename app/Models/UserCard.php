<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserCard extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'card_holder',
        'customer_stripe_id',
        'card_id',
        'is_default',
    ];

    public static function createCard($cardHolder, $customerId, $cardId, $isDefault=0){
        return UserCard::create([
            'user_id'            => Auth::id(),
            'card_holder'        => $cardHolder,
            'customer_stripe_id' => $customerId,
            'card_id'            => $cardId,
            'is_default'         => $isDefault,
        ]);
    }

    public static function checkUserCardExistsAny(){
        return UserCard::where('user_id', Auth::id())->count();
    }

    public static function getUserCards($userId){
        return UserCard::where('user_id', $userId)->get();
    }
}
