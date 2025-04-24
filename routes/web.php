<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Sharenjoy\NoahCms\Models\Order;

// Route::get('/download-order-info-lists', function () {
//     $models = Order::with(['user', 'items', 'invoice.prices', 'transaction', 'shipment'])
//         ->whereIn('id', request()->get('ids'))
//         ->get();

//     // 設置 DomPDF 選項
//     // $options = new Options();
//     // $options->set('isRemoteEnabled', true);

//     // 將選項應用到 PDF
//     $pdf = Pdf::loadView('noah-cms::pdf.order-info-list', ['models' => $models]);
//     // $pdf->getDomPDF()->setOptions($options);

//     return $pdf->download('invoice-' . date('YmdHis') . '.pdf');
// })->name('noah-cms.pdf-download-order-info-lists');
