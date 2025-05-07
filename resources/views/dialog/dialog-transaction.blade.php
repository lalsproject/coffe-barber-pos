<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="receiptModalLabel">Receipt</h5>
            <button onclick="reloadPage()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h3>Rapid Babershop</h3>
                    <p class="text-muted"> {{ $transaction->branch->branch }}</p>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                    <p><strong>Kasir:</strong> {{ $transaction->user->name }} </p>
                    <p><strong>Waktu:</strong> {{ $transaction->transaction_date_time }}</p>
                    </div>
                    <div class="col-6 text-end" >
                    <p class="d-flex justify-content-end"><strong>No. Struk:</strong>{{ $transaction->transaction_number }}</p>
                    <p class="d-flex justify-content-end"><strong>Jenis Pembayaran:</strong> {{ $transaction->payment_method }}</p>
                    </div>
                </div>
                <h5 class="text-center mb-3">### PAID ###</h5>
                @foreach($transaction_details as $transaction_detail)
                    <div class="d-flex justify-content-between">
                        <strong>{{ $transaction_detail->product->name }} </strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>{{ $transaction_detail->product->price }}  x {{ $transaction_detail->quantity }}</span>
                        <span>{{ $transaction_detail->product->price * $transaction_detail->quantity }}</span>
                    </div>
                @endforeach
                <div class="d-flex justify-content-between mt-2">
                    <span>Kembali</span>
                    <span>{{ $transaction->money_received - $transaction->total_transaction }}</span>
                </div>
                <div class="d-flex justify-content-between mt-2">
                 <a href="{{ route('transaction.export-pdf', $transaction->id) }}" type="button" class="btn btn-success col-12 print-btn">Print</a>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
             <p class="text-muted">Powered by Rapid BaberShop</p>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        function reloadPage() {
            console.log('ds');
            location.reload();
        }
    </script>
@endpush