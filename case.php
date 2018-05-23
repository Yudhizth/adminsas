<?php
$array = array(
   "hrd" => array(
        "main_case" => array(
            "1" => "filter calon karyawan(on_load_pages)",
            "2" => "input hasil test (add only grade [a, b, c])",
            "3" => "export search data",
            "4" => "nama, nomor tlp, email, domisili, posisi",
            "5" => "mandatory NOMOR TLP (form_daftar)"
        ),
        "additional_case" => array(
            "1" => 'base location'
        )
   ),
   "customer" => array(
        "main_case"  => array(
          "1" => 'add invoice project',
          "2" => '2 layer approve',
          "3" => 'filter lembur'
        ),
        "additional_case" => array(
          "1" => 'sistem kontrak [kontrak, freelance, daily worker(shift times)]'
        )
   )
);

echo '<pre>';
print_r($array);
echo '</pre>';
// kontrak, freelance, daily worker(shift times),
