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
     }
 }

    $buku1 = new Buku("Laskar Pelangi", "Andrea Hirata", "Bentang Pustaka", 2005);

    $buku2 = new Buku("Perahu Kertas", "Dee Lestari", " Bentang Pustaka",  2009);

    $buku3 = new Buku("Amba", " Laksmi Pamuntjak", "Gramedia Pustaka Utama", 2012);

    $buku4 = new Buku("Supernova: Ksatria, Puteri, dan Bintang Jatuh", " Dee Lestari", " Truedee Books",  2001);

    $buku5 = new Buku("Cantik Itu Luka", " Eka Kurniawan", "Gramedia Pustaka Utama", 2002);
    
    $semuabuku = array($buku1, $buku2, $buku3, $buku4, $buku5);
    
    foreach ($semuabuku as $buku) {
        $buku->infoBuku();
    }
