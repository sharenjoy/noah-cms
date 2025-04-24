<div id="order-info-area">
    @foreach ($models as $order)
    <div class="print-content">
        <div style="background-color: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 24px; max-width: 1000px; margin: 0 auto;">
            <!-- Header -->
            <table style="width: 100%; border-bottom: 1px solid #e5e7eb; padding-bottom: 16px;">
                <tr>
                    <td>
                        <h1 style="font-size: 24px; font-weight: bold; color: #4a5568; margin-bottom: 5px;">訂單明細</h1>
                        <p style="color: #5f6b7d;"># {{ $order->sn }}</p>
                        <p style="color: #5f6b7d; margin-bottom: 5px;">{{ $order->created_at }}</p>
                    </td>
                    <td style="text-align: right; vertical-align: top;">
                        <img src="{{ url('vendor/noah-cms/images/logo-placeholder.png') }}" style="margin-left: auto; height: 64px;">
                        <p style="color: #5f6b7d;">豪聲樂器木業股份有限公司</p>
                        <p style="color: #5f6b7d; margin-bottom: 10px;">music@hausheng.com</p>
                    </td>
                </tr>
            </table>

            <!-- Billing Information -->
            <table style="width: 100%; margin-top: 24px;">
                <tr>
                    <td>
                        <h2 style="font-weight: bold; color: #4a5568;">收件人資訊</h2>
                        <p style="color: #718096; font-size: 14px;">{{ $order->shipment?->name }}</p>
                        <p style="color: #718096; font-size: 14px; margin-bottom: 3px;">{{ $order->shipment?->call }}</p>
                        <p style="color: #718096; font-size: 14px;">{{ $order->shipment->delivery_method }}</p>
                        <p style="color: #718096; font-size: 14px;">{!! \Sharenjoy\NoahCms\Actions\Shop\DisplayOrderShipmentDetail::run($order->shipment) !!}</p>
                    </td>
                    <td style="text-align: right;">
                        <h2 style="font-weight: bold; color: #4a5568;">訂購人資訊</h2>
                        <p style="color: #718096; font-size: 14px;">{{ $order->user?->name }}</p>
                        <p style="color: #718096; font-size: 14px;">{{ $order->user?->call }}</p>
                        <p style="color: #718096; font-size: 14px;">{{ $order->user?->email }}</p>
                    </td>
                </tr>
            </table>

            <!-- Invoice Items -->
            <table style="width: 100%; margin-top: 24px; border-collapse: collapse; border: 1px solid #e2e8f0;">
                <thead>
                    <tr style="background-color: #f7fafc;">
                        <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: left; color: #4a5568;">Description</th>
                        <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">Quantity</th>
                        <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">Unit Price</th>
                        <th style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td style="border: 1px solid #e2e8f0; padding: 8px; color: #718096;">{{ $item->product->name }}</td>
                        <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #718096;">{{ $item->quantity }}</td>
                        <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #718096;">{{ format_currency($item->price_discounted) }}</td>
                        <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #718096;">{{ $item->subtotal }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background-color: #f7fafc;">
                        <td colspan="3" style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; font-weight: bold; color: #4a5568;">Subtotal</td>
                        <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">${{ $order->invoice->total_price }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; font-weight: bold; color: #4a5568;">Discount</td>
                        <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">${{ $order->invoice->discount }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; font-weight: bold; color: #4a5568;">Total</td>
                        <td style="border: 1px solid #e2e8f0; padding: 8px; text-align: right; color: #4a5568;">${{ $order->invoice->price + $order->invoice->discount }}</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Footer -->
            <div style="margin-top: 24px; text-align: center; color: #a0aec0;">
                <p>Thank you for your business!</p>
                <p>If you have any questions about this invoice, please contact us at info@company.com.</p>
            </div>
        </div>
    </div>
    @endforeach
</div>
