<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bank account</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
        padding: 20px;
    }
    h3 {
        color: #2c3e50;
    }
    .info {
        background-color: #53cae7ff;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .info p {
        margin: 5px 0;
    }
    .error {
        color: red;
        font-weight: bold;
    }
    .success {
        color: green;
        font-weight: bold;
    }
    .warning {
        color: orange;
        font-weight: bold;
    }
    .card {
        background-color: #5DE8F0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
    }

</style>
</head>
<body>
    
</body>
</html>

<?php
class akunbank {
    protected $nama;
    protected $saldo;

    public function __construct($nama, $saldoawal) {
        $this->nama = $nama;
        $this->saldo = $saldoawal;
    }

    public function getnama() {
        return $this->nama;
    }

    public function getsaldo() {
        return $this->saldo;
    }

    public function info() {
        echo "<div class='info'>";
        echo "<div class='card'>";
        echo "<h3>Pemilik Akun Bank</h3>";
        echo "Nama = " . $this->getnama() . "<br>";
        echo "Saldo = " . $this->getsaldo() . "<br>";
        if ($this->getsaldo() > 500000000) {
            echo "Status: Nasabah Prioritas<br>";
        } else {
            echo "Status: Nasabah Biasa<br>";
        }
    }

    public function setor($jumlah) {
        if ($jumlah >= 50000) {
            $this->saldo += $jumlah;
            echo "Setor = " . $jumlah . "<br>";
            echo "Jumlah saldo " . $this->getnama() . " sekarang = " . $this->getsaldo() . "<br>";
        } else {
            echo "Setor = " . $jumlah . "<br>";
            echo "<div class='error'>Maaf gagal setor, minimal setor adalah 50000</div><br>";
        }
    }

    public function tarik($jumlah) {
        if ($jumlah > 20000000) {
            echo "Maaf maksimal tarik adalah 20000000<br>";
        } else if ($jumlah <= $this->getsaldo()) {
            $this->saldo -= $jumlah;
            echo "Tarik = " . $jumlah . "<br>";
            echo "Jumlah saldo " . $this->getnama() . " sekarang = " . $this->getsaldo() . "<br>";
            echo "<div class='warning'>Maksimal tarik adalah 2000000</div><br>";
        } else {
            echo "<div class='error'>Saldo anda tidak cukup untuk tarik</div><br>";
        }
    }

    public function tranfer($jumlah, $tujuan) {
        if (!$tujuan instanceof akunbank) {
            echo "<div class='error'>Akun tujuan tidak valid</div><br>";
            return;
        }
        if ($jumlah < 50000) {
            echo "Transfer = " . $jumlah . "<br>";
            echo "Maaf gagal transfer, minimal transfer adalah 50.000<br>";
            return;
        }
        if ($jumlah > $this->getsaldo()) {
            echo "Maaf gagal transfer, saldo anda tidak cukup<br>";
            return;
        }
        $this->saldo -= $jumlah;
        $tujuan->saldo += $jumlah;

        echo "Dari = " . $this->getnama() . "<br>";
        echo "Tujuan = " . $tujuan->getnama() . "<br>";
        echo "Jumlah transfer = " . $jumlah . "<br>";
        echo "Saldo " . $this->getnama() . " = " . $this->getsaldo() . "<br>";
        echo "Saldo " . $tujuan->getnama() . " = " . $tujuan->getsaldo() . "<br>";
    }
}

class akunreguler extends akunbank {
    public function setor($jumlah) {
        $kuponcashback = 0.02; // 2% cashback
        $cashback = $kuponcashback * $jumlah;
        $this->saldo += $cashback; // tidak ada handling buat diluar ketentuan
        echo "Cashback = " . $cashback . "<br>";
        parent::setor($jumlah);
    }

    public function tarik($jumlah) {
        if ($jumlah > 2000000) {
            echo "<div class='regular'>Maksimal tarik untuk akun reguler adalah 2000000</div><br>";
        } else if ($jumlah <= $this->getsaldo()) {
            $this->saldo -= $jumlah;
            echo "Tarik = " . $jumlah . "<br>";
            echo "Jumlah saldo " . $this->getnama() . " sekarang = " . $this->getsaldo() . "<br>";
            echo "<div class='warning'>Maksimal tarik untuk akun reguler adalah 2000000</div><br>";
        } else {
            echo "Maaf gagal tarik, saldo anda tidak cukup<br>";
        }
    }

    public function tranfer($jumlah, $tujuan) {
        if (!$tujuan instanceof akunbank) {
            echo "<div class='error'>Akun tujuan tidak valid</div><br>";
            return;
        }
        if ($jumlah < 50000) {
            echo "Transfer = " . $jumlah . "<br>";
            echo "<div class='error'>Minimal transfer adalah 50.000</div><br>";
            return;
        }
        $limitTransfer = 0.25 * $this->getsaldo();
        if ($jumlah > $limitTransfer) {
            echo "Maaf gagal transfer, maksimal transfer untuk akun reguler adalah 25% dari saldo (" . $limitTransfer . ")<br>";
            return;
        }
        if ($jumlah > $this->getsaldo()) {
            echo "Maaf gagal transfer, saldo anda tidak cukup<br>";
            return;
        }
        $this->saldo -= $jumlah;
        $tujuan->saldo += $jumlah;

        echo "Dari = " . $this->getnama() . "<br>";
        echo "Tujuan = " . $tujuan->getnama() . "<br>";
        echo "Jumlah transfer = " . $jumlah . "<br>";
        echo "Saldo " . $this->getnama() . " = " . $this->getsaldo() . "<br>";
        echo "Saldo " . $tujuan->getnama() . " = " . $tujuan->getsaldo() . "<br>";
    }
}

class akunpremium extends akunbank {
    public function setor($jumlah) {
        $kuponcashback = 0.05; // 5% cashback
        $cashback = $kuponcashback * $jumlah;
        $this->saldo += $cashback;
        echo "Cashback = " . $cashback . "<br>";
        parent::setor($jumlah);
    }

    public function tarik($jumlah) {
        if ($jumlah <= $this->getsaldo()) {
            $this->saldo -= $jumlah;
            echo "Tarik = " . $jumlah . "<br>";
            echo "Jumlah saldo " . $this->getnama() . " sekarang = " . $this->getsaldo() . "<br>";
            echo "Akun premium tidak memiliki batas maksimal tarik<br>";
        } else {
            echo "Maaf gagal tarik, saldo anda tidak cukup<br>";
        }
    }

    public function tranfer($jumlah, $tujuan) {
        if (!$tujuan instanceof akunbank) {
            echo "<div class='error'>Akun tujuan tidak valid</div><br>";
            return;
        }
        if ($jumlah < 50000) {
            echo "Transfer = " . $jumlah . "<br>";
            echo "<div class='error'>Minimal transfer adalah 50.000</div><br>";
            return;
        }
        if ($jumlah > $this->getsaldo()) {
            echo "<div class='error'>Saldo anda tidak cukup untuk transfer</div><br>";
            return;
        }
        $this->saldo -= $jumlah;
        $tujuan->saldo += $jumlah;

        echo "Dari = " . $this->getnama() . "<br>";
        echo "Tujuan = " . $tujuan->getnama() . "<br>";
        echo "Jumlah transfer = " . $jumlah . "<br>";
        echo "Saldo " . $this->getnama() . " = " . $this->getsaldo() . "<br>";
        echo "Saldo " . $tujuan->getnama() . " = " . $tujuan->getsaldo() . "<br>";
        echo "Akun premium tidak memiliki batas maksimal transfer<br>";
    }
}

// $kevin = new akunreguler("Kevin", 1000000);
// $tujuan = new akunbank("Amba", 5000000);
// $amba = new akunpremium("Amba", 10000000000);

// $kevin->info();
// $kevin->setor(500);
// $kevin->tarik(200000000);
// $amba->info();
// $kevin->tranfer(12752500, $tujuan);
// $kevin->tranfer(5000, $tujuan);
// $amba->setor(1000000);

$faris = new akunreguler("faris", 200000);
$kevin = new akunpremium("kevin", 10000);
// $faris->tarik(10000);
// $faris->tranfer(49000, $kevin);
$kevin->info();
$kevin->setor(40000);
$kevin->info();




?>
    