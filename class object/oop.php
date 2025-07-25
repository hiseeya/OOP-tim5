<?php
// ini adalah class PPLG3
Class PPLG3 {
        // ini adalah property dari class PPLG3
      public $name;
      public $age;
      public $gender;
      public $agama;
        public function __construct($name, $age, $gender, $agama) {
            $this->name = $name;
            $this->age = $age;
            $this->gender = $gender;
            $this->agama = $agama;
            
        }

        // ini adalah method dari class PPLG3
        public function profilsiswa(){
            echo "<h1>Profil Siswa XI PPLG 3</h1>";
            echo "nama : " . $this->name . "<br>";
            echo "umur : " . $this->age . "<br>";
            echo "gender : " . $this->gender();
            echo "agama : " . $this->agama . "<br>";
        }

        public function gender() {
            if ($this->gender == "L") {
                return "Laki-laki<br>";
            } else{
                return "perempuan<br>";
            }
        }
}
$faris = new PPLG3("Faris","1", "L", "Islam");


$lauhul = new PPLG3("Lauhul", 100, "P", "protestan");


$kalingga = new PPLG3("Kalingga", 20, "L", "Kristen");


$nabhan = new PPLG3("Nabhan", 15, "L", "protestan");


$amba = new PPLG3("Amba", 17, "L", "islam");


$semuasiswa = array ($faris, $lauhul, $kalingga, $nabhan, $amba);

foreach ($semuasiswa as $ss) {
    $ss->profilsiswa();
    $ss->gender();
}


