<?php

class rumah {
    private $kamarutama = "hanya bisa diakses di dalam classnya (pemiliknya)<br>";
    protected $ruangkeluarga = "ruang keluarga bisa diakses didalam classnya dan class keturunan<br/>";
    public $ruangtamu = "ruang tamu dapat diakses oleh siapa saja <br/>";

    public function aksesdaridalam() {
        echo "<h3>Akses dari dalam class rumah</h3>";
        echo $this->kamarutama;
        echo $this->ruangkeluarga;
        echo $this->ruangtamu;

    }
}
class anak extends rumah {
    public function aksesdariclassanak(){
        echo "<h3>Akses dari class anak</h3>";
       
        echo $this->ruangkeluarga;
        echo $this->ruangtamu;
    }
}


echo "<h3>Akses dari luar class</h3>";
$anak = new anak();
$rumah = new rumah();
//echo $rumah->kamarutama;
echo $rumah->ruangtamu;
//echo $rumah->ruangkeluarga; 
$rumah->aksesdaridalam();
$anak->aksesdariclassanak();

