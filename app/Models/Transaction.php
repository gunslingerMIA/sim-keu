<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['pkjur', 'tanggal', 'nobukti', 'keterangan', 'account_debit', 'account_kredit', 'sub_activity_id', 'jumlah'];
    //
    // app/Models/Transaction.php

    public function debitAccount()
    {
        // account_debit adalah foreign key di tabel transactions
        return $this->belongsTo(Account::class, 'account_debit');
    }

    public function kreditAccount()
    {
        // account_kredit adalah foreign key di tabel transactions
        return $this->belongsTo(Account::class, 'account_kredit');
    }

    public function subActivity()
    {
        return $this->belongsTo(SubActivity::class);
    }

    
}
