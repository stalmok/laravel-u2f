<?php

namespace Certly\U2f\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OtpKey.
 *
 * @author  LAHAXE Arnaud
 */
class U2fKey extends Model
{
    public $table = 'u2f_key';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'user_id',
        'keyHandle',
        'publicKey',
        'certificate',
        'counter',
    ];

    /**
     * @author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\App\User');
    }
}
