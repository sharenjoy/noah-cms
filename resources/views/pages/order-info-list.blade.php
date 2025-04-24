<x-filament-panels::page>

    @push('styles')
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

        body {
            font-family: '微軟正黑體', arial;
            -webkit-print-color-adjust: exact;
        }
        .print-content {
            margin-bottom: 50px;
        }
    </style>
    @endpush

    {{-- 列印按鈕 --}}
    <div class="max-w-4xl mx-auto mb-4 text-right print:hidden">
        <x-filament::button
            icon="heroicon-o-printer"
            href="javascript:void(0)"
            onclick="printInvoice()"
        >列印發票</x-filament::button>
        <x-filament::button
            icon="heroicon-o-arrow-down-tray"
            href="{{ route('noah-cms.pdf-download-order-info-lists', ['ids' => $ids]) }}"
            tag="a"
        >下載發票(PDF)</x-filament::button>
    </div>

    {{-- 發票內容 --}}
    @include('noah-cms::pages.partials.order-info-area', [
        'models' => $models
    ])

    {{-- 列印功能 --}}
    <script>
        function printInvoice() {
            const content = document.getElementById('order-info-area').innerHTML;
            const original = document.body.innerHTML;

            document.body.innerHTML = content;

            // 等待所有圖片加載完成後再列印
            const images = document.images;
            let loaded = 0;

            for (let i = 0; i < images.length; i++) {
                images[i].onload = () => {
                    loaded++;
                    if (loaded === images.length) {
                        window.print();
                        document.body.innerHTML = original;
                    }
                };
                images[i].onerror = () => {
                    loaded++;
                    if (loaded === images.length) {
                        window.print();
                        document.body.innerHTML = original;
                    }
                };
            }
        }
    </script>

</x-filament-panels::page>
