<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    protected $fillable = ['kode_rekening', 'nama_rekening', 'kelompok', 'tahun'];

    public function up(){
        Schema::create('accounts', function (Blueprint $table) {
                $table->id();
                $table->string('kode_rekening')->unique(); // Contoh: 5.1.02.01.0026
                $table->string('nama_rekening');           // Contoh: Belanja Bahan Cetak
                $table->enum('kelompok', ['sub-kegiatan', 'non sub-kegiatan']); // Contoh: sub-kegiatan untuk DPA, non sub-kegiatan untuk kas/panjar/pajak
                $table->year('tahun');
                $table->timestamps();
        });
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

   
    public function transactionsAsDebit()
    {
        return $this->hasMany(Transaction::class, 'account_debit');
    }

    public function transactionsAsKredit()
    {
        return $this->hasMany(Transaction::class, 'account_kredit');
    }

   public function getTotalTransactionsCountAttribute()
    {
        return $this->transactions_as_debit_count + $this->transactions_as_kredit_count;
        
    
    }
}
