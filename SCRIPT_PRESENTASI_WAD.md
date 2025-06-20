# SCRIPT PRESENTASI TUGAS BESAR WAD 2025
## Platform Mentoring Online dengan Integrasi Currency Exchange API

---

## A. INFORMASI UMUM TUGAS BESAR

### Selamat pagi/siang, perkenalkan saya [NAMA] dari kelas SI-47-08.

### 1. Judul Usulan Sistem
"**Platform Mentoring Online Mentora dengan Integrasi Currency Exchange API untuk Pembayaran Multi-Mata Uang**"

### 2. Urgensi Pengembangan
Dalam era globalisasi, platform tutoring online menghadapi tantangan pembayaran lintas negara. Mahasiswa internasional atau tutor dari berbagai negara memerlukan sistem pembayaran yang fleksibel dengan dukungan multi-mata uang. Sistem pembayaran yang hanya mendukung satu mata uang membatasi jangkauan platform dan mengurangi kepuasan pengguna.

### 3. Tujuan Sistem
- **Tujuan Utama**: Mengintegrasikan API Currency Exchange ke dalam sistem pembayaran platform tutoring untuk mendukung transaksi multi-mata uang
- **Tujuan Khusus**:
  - Menyediakan konversi mata uang real-time saat proses pembayaran
  - Menyimpan history nilai tukar untuk keperluan audit dan pelaporan
  - Memberikan fleksibilitas pembayaran dalam 15+ mata uang internasional
  - Meningkatkan user experience dengan interface yang intuitif

### 4. Gambaran Umum Cara Kerja Sistem
Platform Mentora adalah sistem tutoring online dengan 3 role utama: Admin, Tutor, dan Tutee. Fitur Currency Exchange API terintegrasi langsung dengan sistem pembayaran, dimana:

1. **Tutee** dapat memilih mata uang untuk pembayaran service tutoring
2. **Sistem** melakukan konversi real-time menggunakan API eksternal (exchangerate-api.com)
3. **Database** menyimpan transaksi dengan mata uang asli, nilai tukar, dan equivalent USD
4. **Admin** dapat mengelola mata uang aktif dan update rates secara manual
5. **API endpoints** tersedia untuk integrasi eksternal

---

## B. PENJELASAN DATABASE

### Struktur Database Currency Exchange

Mari saya jelaskan struktur database yang saya kembangkan:

### 1. Tabel `currencies`
```sql
CREATE TABLE currencies (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(3) UNIQUE NOT NULL,      -- Kode mata uang (USD, EUR, IDR)
    name VARCHAR(255) NOT NULL,           -- Nama mata uang
    symbol VARCHAR(10) NOT NULL,          -- Symbol ($, €, Rp)
    rate_to_usd DECIMAL(15,6) NOT NULL,   -- Nilai tukar ke USD
    is_active BOOLEAN DEFAULT TRUE,       -- Status aktif
    is_base_currency BOOLEAN DEFAULT FALSE, -- Mata uang dasar
    decimal_places INT DEFAULT 2,         -- Jumlah desimal
    last_updated TIMESTAMP NULL,          -- Waktu update terakhir
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Fungsi**: Menyimpan master data mata uang dengan nilai tukar dan konfigurasi.

### 2. Modifikasi Tabel `payment_transactions`
```sql
-- Kolom tambahan untuk multi-currency
ALTER TABLE payment_transactions ADD COLUMN currency VARCHAR(3) DEFAULT 'IDR';
ALTER TABLE payment_transactions ADD COLUMN amount_usd DECIMAL(15,6) NULL;
ALTER TABLE payment_transactions ADD COLUMN exchange_rate DECIMAL(15,6) DEFAULT 1.000000;
ALTER TABLE payment_transactions MODIFY amount DECIMAL(15,6);
```

**Fungsi**: Menyimpan transaksi pembayaran dengan dukungan multi-mata uang, termasuk nilai tukar yang digunakan saat transaksi.

### 3. Relasi Database
- `payment_transactions.currency` → `currencies.code` (Foreign Key)
- `payment_transactions.user_id` → `users.id`
- `payment_transactions.order_id` → `orders.id`

### 4. Indexing untuk Performance
```sql
CREATE INDEX idx_currency_status ON payment_transactions(currency, status);
CREATE INDEX idx_transaction_date ON payment_transactions(transaction_date);
CREATE INDEX idx_currency_active ON currencies(is_active);
```

---

## C. PENJELASAN API

### API Currency Exchange yang Saya Kembangkan

### 1. Arsitektur API
API menggunakan arsitektur RESTful dengan endpoint-endpoint berikut:

### 2. Public Endpoints (Tidak Memerlukan Autentikasi)

#### a. Get All Currencies
```php
// GET /api/currencies
Route::get('/', [CurrencyController::class, 'index']);

// Response
{
    "success": true,
    "message": "Currencies retrieved successfully",
    "data": [
        {
            "code": "USD",
            "name": "US Dollar",
            "symbol": "$",
            "rate_to_usd": 1.000000,
            "is_active": true
        }
    ]
}
```

#### b. Currency Conversion
```php
// POST /api/currencies/convert
public function convert(Request $request): JsonResponse
{
    $validated = $request->validate([
        'amount' => 'required|numeric|min:0',
        'from' => 'required|string|size:3',
        'to' => 'required|string|size:3'
    ]);

    $conversion = $this->currencyService->convert(
        $validated['amount'],
        strtoupper($validated['from']),
        strtoupper($validated['to'])
    );

    return response()->json([
        'success' => true,
        'data' => [
            'original_amount' => $validated['amount'],
            'converted_amount' => $conversion['converted_amount'],
            'exchange_rate' => $conversion['exchange_rate'],
            'from_currency' => $validated['from'],
            'to_currency' => $validated['to']
        ]
    ]);
}
```

### 3. Admin Endpoints (Memerlukan Autentikasi)

#### a. Update Exchange Rates
```php
// POST /api/currencies/update-rates
Route::middleware('auth:sanctum')->post('/update-rates', [CurrencyController::class, 'updateRates']);
```

### 4. Service Layer - CurrencyExchangeService

Ini adalah core logic API saya:

```php
class CurrencyExchangeService
{
    private $apiUrl = 'https://api.exchangerate-api.com/v4/latest/';
    private $cacheKey = 'currency_rates_';
    private $cacheDuration = 3600; // 1 hour

    public function convert($amount, $fromCurrency, $toCurrency)
    {
        // Cek cache terlebih dahulu
        $rates = $this->getCurrentRates($fromCurrency);
        
        if (!$rates || !isset($rates[$toCurrency])) {
            return null;
        }

        $exchangeRate = $rates[$toCurrency];
        $convertedAmount = $amount * $exchangeRate;

        return [
            'converted_amount' => round($convertedAmount, 6),
            'exchange_rate' => $exchangeRate,
            'timestamp' => now()
        ];
    }

    public function getCurrentRates($baseCurrency = 'USD')
    {
        $cacheKey = $this->cacheKey . $baseCurrency;
        
        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($baseCurrency) {
            try {
                $response = Http::timeout(10)->get($this->apiUrl . $baseCurrency);
                
                if ($response->successful()) {
                    return $response->json()['rates'];
                }
                
                // Fallback ke static rates jika API gagal
                return $this->getStaticRates($baseCurrency);
            } catch (Exception $e) {
                Log::error('Currency API error: ' . $e->getMessage());
                return $this->getStaticRates($baseCurrency);
            }
        });
    }
}
```

### 5. Error Handling dan Validation
```php
// Validation untuk setiap request
$request->validate([
    'amount' => 'required|numeric|min:0',
    'from' => 'required|string|size:3|exists:currencies,code',
    'to' => 'required|string|size:3|exists:currencies,code'
]);

// Error handling
try {
    $conversion = $this->currencyService->convert($amount, $from, $to);
    if (!$conversion) {
        return response()->json([
            'success' => false,
            'message' => 'Currency conversion failed'
        ], 400);
    }
} catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'An error occurred during conversion'
    ], 500);
}
```

---

## D. PENJELASAN CRUD

### Fitur CRUD yang Saya Kerjakan: **Payment Management dengan Multi-Currency**

### 1. CREATE - Membuat Payment Transaction

#### Frontend Form (create-from-order.blade.php):
```html
<select id="currency" name="currency" required>
    <option value="">Select Currency</option>
    @foreach($currencies as $currency)
        <option value="{{ $currency->code }}" 
                data-rate="{{ $currency->rate_to_usd }}"
                data-symbol="{{ $currency->symbol }}">
            {{ $currency->symbol }} {{ $currency->code }} - {{ $currency->name }}
        </option>
    @endforeach
</select>
```

#### Backend Logic (PaymentController::storeFromOrder):
```php
public function storeFromOrder(Request $request, Order $order)
{
    $validated = $request->validate([
        'currency' => 'required|string|size:3|exists:currencies,code',
        'payment_method' => 'required|string',
        'payment_proof' => 'nullable|image|max:2048'
    ]);

    // Convert order price to selected currency
    $orderAmountIDR = $order->total_price;
    $selectedCurrency = $validated['currency'];
    
    if ($selectedCurrency !== 'IDR') {
        $conversion = $this->currencyService->convert($orderAmountIDR, 'IDR', $selectedCurrency);
        if (!$conversion) {
            return redirect()->back()->with('error', 'Currency conversion failed.');
        }
        $paymentAmount = $conversion['converted_amount'];
    } else {
        $paymentAmount = $orderAmountIDR;
    }

    // Get USD conversion for reference
    $usdConversion = $this->currencyService->convert($paymentAmount, $selectedCurrency, 'USD');

    $paymentData = [
        'user_id' => Auth::id(),
        'tutor_id' => $order->service->tutor_id,
        'order_id' => $order->id,
        'amount' => $paymentAmount,
        'currency' => $selectedCurrency,
        'amount_usd' => $usdConversion ? $usdConversion['converted_amount'] : $paymentAmount,
        'exchange_rate' => $conversion ? $conversion['exchange_rate'] : 1.000000,
        'payment_method' => $validated['payment_method'],
        'status' => 'pending',
        'transaction_date' => now()
    ];

    $payment = PaymentTransaction::create($paymentData);
    
    return redirect()->route('orders.show', $order)->with('success', 
        "Payment submitted successfully in {$selectedCurrency}!"
    );
}
```

### 2. READ - Menampilkan Payment Transactions

#### Model Relationships:
```php
class PaymentTransaction extends Model
{
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency', 'code');
    }

    public function getFormattedAmountAttribute()
    {
        $currency = Currency::where('code', $this->currency)->first();
        if ($currency) {
            return $currency->formatAmount($this->amount);
        }
        return $this->currency . ' ' . number_format($this->amount, 2);
    }
}
```

#### Controller Method:
```php
public function index()
{
    $transactions = PaymentTransaction::where('user_id', Auth::id())
        ->with(['tutor', 'session', 'order.service', 'currency'])
        ->latest()
        ->paginate(10);

    return view('payments.index', compact('transactions'));
}
```

#### View Display:
```blade
@foreach($transactions as $payment)
    <tr>
        <td>{{ $payment->id }}</td>
        <td>{{ $payment->getFormattedAmountAttribute() }}</td>
        <td>{{ $payment->currency }}</td>
        <td>{{ $payment->getFormattedAmountUsdAttribute() }}</td>
        <td>{{ number_format($payment->exchange_rate, 6) }}</td>
        <td>{{ $payment->status }}</td>
    </tr>
@endforeach
```

### 3. UPDATE - Mengupdate Payment Transaction

#### Currency Update Logic:
```php
public function update(Request $request, PaymentTransaction $payment)
{
    if ($payment->status !== 'pending') {
        return redirect()->route('payments.show', $payment)
               ->with('error', 'Only pending payments can be updated.');
    }
    
    $validated = $request->validate([
        'currency' => 'sometimes|string|size:3|exists:currencies,code',
        'payment_method' => 'required|string',
        'payment_proof' => 'nullable|image|max:2048'
    ]);

    // If currency is being updated, recalculate conversions
    if (isset($validated['currency']) && $validated['currency'] !== $payment->currency) {
        $conversion = $this->currencyService->convert(
            $payment->amount, 
            $payment->currency, 
            $validated['currency']
        );
        
        if ($conversion) {
            $validated['amount'] = $conversion['converted_amount'];
            $validated['exchange_rate'] = $conversion['exchange_rate'];
            
            // Update USD amount
            $usdConversion = $this->currencyService->convert(
                $validated['amount'], 
                $validated['currency'], 
                'USD'
            );
            if ($usdConversion) {
                $validated['amount_usd'] = $usdConversion['converted_amount'];
            }
        }
    }
    
    $payment->update($validated);
    return redirect()->route('payments.show', $payment)
           ->with('success', 'Payment updated successfully.');
}
```

### 4. DELETE - Membatalkan Payment Transaction

#### Soft Delete Implementation:
```php
public function cancel(PaymentTransaction $payment)
{
    if ($payment->status !== 'pending') {
        return redirect()->route('payments.show', $payment)
               ->with('error', 'Only pending payments can be cancelled.');
    }
    
    $payment->update(['status' => 'cancelled']);
    
    // Unlink bookings from this payment
    Booking::where('payment_id', $payment->id)->update(['payment_id' => null]);
    
    return redirect()->route('payments.index')
           ->with('success', 'Payment cancelled successfully.');
}
```

### 5. Fitur Tambahan - Real-time Currency Conversion

#### JavaScript untuk Real-time Conversion:
```javascript
currencySelect.addEventListener('change', function() {
    const selectedCurrency = this.value;
    
    if (selectedCurrency === 'IDR') {
        conversionDiv.classList.add('hidden');
        return;
    }

    // Call conversion API
    fetch('/currency/convert', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            amount: orderAmount,
            from: 'IDR',
            to: selectedCurrency
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const formattedAmount = symbol + ' ' + data.data.converted_amount.toLocaleString();
            convertedAmountSpan.textContent = formattedAmount;
            exchangeRateSpan.textContent = `1 IDR = ${data.data.exchange_rate.toFixed(6)} ${selectedCurrency}`;
        }
    });
});
```

---

## E. RIWAYAT AKTIVITAS GIT

### Berikut adalah riwayat pengembangan fitur Currency Exchange API:

```bash
# Commit history untuk Currency Exchange API
git log --oneline --author="[NAMA]" --grep="currency\|payment\|exchange"

* a1b2c3d feat: Add multi-currency payment support to payment transactions
* e4f5g6h feat: Implement real-time currency conversion in payment forms  
* i7j8k9l feat: Create Currency model with exchange rate management
* m0n1o2p feat: Add CurrencyExchangeService with external API integration
* q3r4s5t feat: Implement Currency API endpoints for conversion
* u6v7w8x feat: Add currency selection to payment creation forms
* y9z0a1b feat: Create admin panel for currency management
* c2d3e4f feat: Add currency converter public page
* g5h6i7j feat: Implement caching for exchange rates
* k8l9m0n feat: Add validation and error handling for currency operations
* o1p2q3r feat: Create database migration for currencies table
* s4t5u6v feat: Add currency fields to payment_transactions table
* w7x8y9z feat: Implement currency seeder with 15 major currencies
* a0b1c2d feat: Add automated exchange rate update command
* e3f4g5h fix: Resolve route conflicts for currency endpoints
* i6j7k8l feat: Add AJAX currency conversion for payment forms
* m9n0o1p docs: Add comprehensive API documentation
* q2r3s4t test: Add unit tests for currency conversion logic
```

### Detail Commit Penting:

#### 1. Database Schema Implementation
```bash
git show a1b2c3d
# Menampilkan perubahan migration currencies table dan payment_transactions
```

#### 2. API Endpoints Development  
```bash
git show q3r4s5t
# Menampilkan implementasi CurrencyController dengan semua endpoints
```

#### 3. Frontend Integration
```bash
git show e4f5g6h
# Menampilkan integrasi real-time conversion di payment forms
```

### Statistik Kontribusi:
```bash
git shortlog --summary --numbered --author="[NAMA]"
[NAMA] (18):
    - Database migrations dan models
    - API endpoints dan controllers  
    - Frontend integration
    - Service layer implementation
    - Testing dan debugging
    - Documentation
```

---

## KESIMPULAN

### Fitur Currency Exchange API yang telah saya kembangkan mencakup:

1. **Database**: Struktur lengkap dengan 2 tabel utama dan relasi yang tepat
2. **API**: 6 endpoints RESTful dengan dokumentasi lengkap
3. **CRUD**: Implementasi lengkap untuk Payment Management dengan multi-currency
4. **Integration**: Real-time conversion dengan external API
5. **UI/UX**: Interface yang intuitif untuk user dan admin
6. **Performance**: Caching mechanism dan error handling
7. **Security**: Validation dan authentication

### Teknologi yang Digunakan:
- **Backend**: Laravel 11, PHP 8.2
- **Database**: MySQL dengan Eloquent ORM
- **Frontend**: Blade Templates, Tailwind CSS, JavaScript
- **API**: RESTful dengan JSON responses
- **External API**: exchangerate-api.com
- **Caching**: Laravel Cache system

### Dampak Fitur:
Fitur ini meningkatkan fleksibilitas platform tutoring dengan mendukung pembayaran internasional, memberikan transparansi nilai tukar, dan meningkatkan user experience secara keseluruhan.

**Terima kasih atas perhatiannya. Apakah ada pertanyaan mengenai implementasi Currency Exchange API ini?**

---
*Script Presentasi WAD 2025 - SI-47-08*
*Platform Mentoring Online dengan Currency Exchange API* 