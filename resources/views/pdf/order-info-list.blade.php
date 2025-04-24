<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta charset="UTF-8">
        <style>
            @media print {
                body {
                    font-family: '微軟正黑體', arial;
                    -webkit-print-color-adjust: exact;
                }
                .print-content {
                    height:100%;
                    page-break-after: always;
                }
                @page {
                    size: A4 portrait;
                }
            }
            .print-content {
                margin-bottom: 50px;
            }
        </style>
    </head>
    <body>
        {{-- 發票內容 --}}
        @include('noah-cms::pages.partials.order-info-area', [
            'models' => $models,
        ])
    </body>
</html>
