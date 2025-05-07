<x-mail::message>
# Pemberitahuan Stok Rendah

Berikut adalah produk-produk yang memiliki stok yang berada di bawah ambang batas yang ditentukan
({{ $threshold }} item):

<x-mail::table>
| Nama Produk  | Stok Tersisa  |
|:--------------:|:---------------:|
@foreach ($products as $product)
| {{ $product->name }} | @if($product->stock <= 2) **<span style="color: red;">{{ $product->stock }}</span>** @else {{ $product->stock }} @endif |
@endforeach
</x-mail::table>

Silakan segera melakukan pengecekan inventaris dan memastikan stok produk tersedia sesuai kebutuhan.

<x-mail::button :url="'/inventory'">
Lihat Inventaris
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
