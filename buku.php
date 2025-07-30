<?php
class Buku {
    public $judul;
    public $pengarang;
    public $penerbit;
    public $tahun;

    public function __construct($judul, $pengarang, $penerbit, $tahun) {
        $this->judul = $judul;
        $this->pengarang = $pengarang;
        $this->penerbit = $penerbit;
        $this->tahun = $tahun;
    }

    public function infoBuku() {
        echo "<h1>Informasi Buku</h1>";
        echo "Judul: " . $this->judul . "<br>";
        echo "Pengarang: " . $this->pengarang . "<br>";
        echo "Penerbit: " . $this->penerbit . "<br>";
        echo "Tahun Terbit: " . $this->tahun . "<br>";
        echo $this->tahunTerbit();
        echo "<br>";
    }

    public function tahunTerbit() {
        if ($this->tahun < 2000) {
            return "Buku ini terbit sebelum tahun 2000.<br>";
        } else {
            return "Buku ini terbit setelah tahun 2000.<br>";
        }
    }

    public function __destruct() {
        echo "Buku '{$this->judul}' telah dihapus.<br>";
    }
}

$semuabuku = [
    new Buku("Sang Pemimpi", "Andrea Hirata", "Bentang Pustaka", 2006),
    new Buku("Pulang", "Leila S. Chudori", "KPG", 2012),
    new Buku("Bumi Manusia", "Pramoedya Ananta Toer", "Hasta Mitra", 1980),
    new Buku("Anak Semua Bangsa", "Pramoedya Ananta Toer", "Hasta Mitra", 1980),
    new Buku("Jejak Langkah", "Pramoedya Ananta Toer", "Hasta Mitra", 1985)
];

foreach ($semuabuku as $buku) {
    $buku->infoBuku();
}
