<?php
// Route PREVIEW lokal saja. Jangan gunakan untuk produksi tanpa backend.
if (app()->environment('local')) {
    \Illuminate\Support\Facades\Route::view('/preview-order/new', 'cs.public-order')->name('cs.public-order.preview');
    \Illuminate\Support\Facades\Route::view('/preview-order/check', 'cs.public-order-check')->name('cs.public-order.check.preview');
}
