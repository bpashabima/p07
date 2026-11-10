<?php
declare(strict_types=1);
// =====================================================================
// 09_validator_krs.php - Studi Kasus 2: Validator KRS sederhana
// Aturan batas SKS = contoh; sesuaikan dengan Pedoman Akademik
// =====================================================================

function batasSks(float $ipk): int
{
    return match (true) {
        $ipk >= 3.00 => 24,
        $ipk >= 2.50 => 21,
        $ipk >= 2.00 => 18,
        default => 15,
    };
}

function cariKodeGanda(array $krs): array
{
    $hitung = array_count_values(array_column($krs, "kode"));
    $ganda = array_filter($hitung, fn(int $n): bool => $n > 1);
    return array_keys($ganda);
}

function totalSks(array $krs): int
{
    return array_sum(array_column($krs, "sks"));
}

// Tambahan: Aturan ketiga (Mata kuliah minimal 2 SKS)
function cariSksTidakValid(array $krs): array
{
    $tidakValid = array_filter($krs, fn(array $mk): bool => $mk["sks"] < 2);
    return array_column($tidakValid, "kode");
}

// Mengembalikan daftar pesan kesalahan; array kosong = KRS valid
function validasiKrs(array $krs, float $ipk): array
{
    $kesalahan = [];
    $kodeGanda = cariKodeGanda($krs);
    
    if (count($kodeGanda) > 0) {
        $kesalahan[] = "Mata kuliah ganda: " . implode(", ", $kodeGanda);
    }
    
    // Tambahan: Memasukkan aturan SKS tidak valid ke daftar kesalahan
    foreach (cariSksTidakValid($krs) as $kode) {
        $kesalahan[] = "SKS tidak valid: {$kode}";
    }
    
    $total = totalSks($krs);
    $batas = batasSks($ipk);
    
    if ($total > $batas) {
        $kesalahan[] = "Total {$total} SKS melebihi batas {$batas} SKS";
    }
    
    return $kesalahan;
}

function cetakLaporan(string $nama, float $ipk, array $krs): void
{
    echo "== KRS {$nama} (IPK " . number_format($ipk, 2) . ") ==\n";
    foreach ($krs as $nomor => $mk) {
        printf("%d. %-7s %-28s %d SKS\n", $nomor + 1, $mk["kode"], $mk["nama"], $mk["sks"]);
    }
    echo "Total: " . totalSks($krs) . " / " . batasSks($ipk) . " SKS\n";
    
    $kesalahan = validasiKrs($krs, $ipk);
    if (count($kesalahan) === 0) {
        echo "Status: VALID, KRS dapat diajukan\n\n";
        return;
    }
    
    echo "Status: DITOLAK\n";
    foreach ($kesalahan as $pesan) {
        echo " - {$pesan}\n";
    }
    echo "\n";
}

// Tambahan: Fungsi mencetak laporan versi tabel HTML
function cetakLaporanHtml(string $nama, float $ipk, array $krs): void
{
    $ganda = cariKodeGanda($krs);
    $kesalahan = validasiKrs($krs, $ipk);
    
    echo "<h3>KRS " . htmlspecialchars($nama) . " (IPK " . number_format($ipk, 2) . ")</h3>";
    echo "<table border='1' cellpadding='6' cellspacing='0'>";
    echo "<tr><th>No</th><th>Kode</th><th>Mata Kuliah</th><th>SKS</th></tr>";
    
    foreach ($krs as $nomor => $mk) {
        // Baris mata kuliah ganda diberi warna merah muda
        $gaya = in_array($mk["kode"], $ganda, true) ? " style='background-color: pink;'" : "";
        echo "<tr{$gaya}>";
        echo "<td>" . ($nomor + 1) . "</td>";
        echo "<td>" . htmlspecialchars($mk["kode"]) . "</td>";
        echo "<td>" . htmlspecialchars($mk["nama"]) . "</td>";
        echo "<td>{$mk['sks']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<p>Total: " . totalSks($krs) . " / " . batasSks($ipk) . " SKS</p>";
    
    if (count($kesalahan) === 0) {
        echo "<p>Status: VALID, KRS dapat diajukan</p>";
        return;
    }
    
    echo "<p>Status: DITOLAK</p><ul>";
    foreach ($kesalahan as $pesan) {
        echo "<li>" . htmlspecialchars($pesan) . "</li>";
    }
    echo "</ul>";
}

// ---------- Data uji ----------
$krsAndi = [
    ["kode" => "IF301", "nama" => "Pemrograman Web", "sks" => 3],
    ["kode" => "IF302", "nama" => "Basis Data", "sks" => 3],
    ["kode" => "IF303", "nama" => "Rekayasa Perangkat Lunak", "sks" => 3],
    ["kode" => "IF304", "nama" => "Jaringan Komputer", "sks" => 3],
];

// Dikembalikan ke versi asli (dengan duplikat) untuk tes tabel HTML
$krsBudi = [
    ["kode" => "IF301", "nama" => "Pemrograman Web", "sks" => 3],
    ["kode" => "IF302", "nama" => "Basis Data", "sks" => 3],
    ["kode" => "IF301", "nama" => "Pemrograman Web", "sks" => 3],
    ["kode" => "IF305", "nama" => "Kecerdasan Buatan", "sks" => 3],
    ["kode" => "IF306", "nama" => "Sistem Operasi", "sks" => 3],
    ["kode" => "IF307", "nama" => "Grafika Komputer", "sks" => 3],
    ["kode" => "IF308", "nama" => "Metode Numerik", "sks" => 3],
];

echo "<pre>";
// Tambahan: Uji batas batasSks
echo "== Uji Batas SKS ==\n";
foreach ([3.00, 2.99, 2.50, 2.49, 2.00, 1.99] as $ujiIpk) {
    echo number_format($ujiIpk, 2) . " => " . batasSks($ujiIpk) . " SKS\n";
}
echo "\n";

// Cetak Laporan Teks
cetakLaporan("Andi", 3.45, $krsAndi);
cetakLaporan("Budi", 2.10, $krsBudi);
echo "</pre>";

// Cetak Laporan HTML
cetakLaporanHtml("Andi", 3.45, $krsAndi);
cetakLaporanHtml("Budi", 2.10, $krsBudi);