<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;
    protected $with = ['rentedBy', 'voucher', 'userInfo'];
    protected $guarded = [];
    public function getFormattedStatusAttribute()
    {
        $status = $this->attributes['status'];
        if ($status == 'pending') {
            return 'Menunggu Konfirmasi Admin';
        } elseif ($status == 'accept') {
            return 'Pembayaran Diterima';
        } elseif ($status == 'failed') {
            return 'Pembayaran Ditolak';
        } elseif ($status == 'canceled') {
            return 'Pesanan Dibatalkan';
        }
    }
    public function getFormattedOrderDateAttribute()
    {
        return Carbon::parse($this->attributes['order_date'])->format('d F Y');
    }
    public function getTotalPriceAttribute()
    {
        $total_price = $this->listBooking->sum(function ($listBooking) {
            return $listBooking->field->price;
        });
        return $total_price;
    }
    public function getTotalPriceAfterDiscountAttribute()
    {
        $totalPrice = $this->getTotalPriceAttribute();
        $discountAmount = 0;
        if ($this->voucher) {
            if ($this->voucher->discount_percentage > 0) {
                // Hitung diskon persentase
                $discountAmount = $totalPrice * ($this->voucher->discount_percentage / 100);

                // Batasi maksimal diskon jika ada max_discount
                if ($this->voucher->max_discount > 0) {
                    $discountAmount = min($discountAmount, $this->voucher->max_discount);
                }
            } elseif ($this->voucher->discount_price > 0) {
                // Diskon dalam nominal fix
                $discountAmount = $this->voucher->discount_price;
            }
        }

        // Pastikan diskon tidak melebihi total harga
        $discountAmount = min($discountAmount, $totalPrice);
        $total_price_after_discount = $totalPrice - $discountAmount;
        return $this->formatRupiah($total_price_after_discount);
    }
    public function rentedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rented_by');
    }
    public function listBooking(): HasMany
    {
        return $this->hasMany(ListBooking::class, 'id_booking', 'id');
    }
    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class, 'id_voucher');
    }
    public function userInfo(): BelongsTo
    {
        return $this->belongsTo(UserInfo::class, 'user_info');
    }
    public function review(): HasOne
    {
        return $this->hasOne(Review::class, 'id_booking');
    }
    function formatRupiah($angka)
    {
        $hasil_rupiah = 'Rp ' . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
}
