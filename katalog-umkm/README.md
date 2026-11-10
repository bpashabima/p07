
##  Fitur Utama
- **Tampilan Grid Responsif**: Menampilkan produk dalam bentuk kartu yang rapi.
- **Filter Kategori**: Pengguna dapat memfilter produk berdasarkan kategori (Makanan, Minuman, Fashion, Kerajinan).
- **Status Stok Dinamis**: Badge warna-warni yang otomatis menunjukkan ketersediaan stok produk (Aman, Menipis, Habis).
- **Ringkasan Bisnis**: Kalkulasi dan tampilan otomatis untuk total produk, jumlah produk yang kehabisan stok, serta estimasi total nilai aset/stok.

## Struktur File
- `index.php`: Halaman utama yang memuat antarmuka pengguna, navigasi filter, dan kartu produk.
- `data.php`: File tempat penyimpanan data (array) produk UMKM beserta konfigurasinya.
- `functions.php`: Kumpulan fungsi *helper*, berisi:
  - Pemformatan angka menjadi mata uang Rupiah.
  - Penentuan label dan warna status stok.
  - Perhitungan nilai total stok.
  - Logika pemfilteran kategori produk.
- `style.css`: File penataan gaya (stylesheet) yang mengatur tipografi, warna, jarak

## Cara Menjalankan

**Opsi 1: Menggunakan Web Server (XAMPP / Laragon)**
1. Letakkan seluruh file (`index.php`, `data.php`, `functions.php`, `style.css`) ke dalam sebuah folder (misal: `katalog-umkm`) atau download langsung zip p07.
2. Pindahkan folder tersebut ke dalam folder `www` (untuk Laragon).
3. klik menu "profil" untuk membuka index.php dan menu "daftar menu" lalu klik p07 / katalog-umkm (loading dan akan menampilkan output)
