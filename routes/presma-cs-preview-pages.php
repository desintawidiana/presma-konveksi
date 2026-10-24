<?php
// Tambahkan: require __DIR__.'/presma-cs-preview-pages.php';
// di routes/web.php (sekali saja), pada lingkungan local.
if (app()->environment('local')) {
    \Illuminate\Support\Facades\Route::view('/preview-order/payment', 'cs.order-payment')->name('cs.order.payment.preview');
    \Illuminate\Support\Facades\Route::view('/preview-order/tracking', 'cs.order-tracking')->name('cs.order.tracking.preview');
}
