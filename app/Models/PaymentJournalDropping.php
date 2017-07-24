<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentJournalDropping extends Model
{
    protected $connection = 'sqlsrv2';
    
    protected $table = 'PIL_PAYMENTJOURNALDROPPING';
}
