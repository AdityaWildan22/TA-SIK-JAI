<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

Cara Installasi : </br>
Buka file htdocs yang ada di folder xampp </br>
Buka address bar kemudian pilih cmd </br>
Setelah itu jalankan Perintah "git clone https://github.com/AdityaWildan22/TA-SIK-JAI.git" untuk clone isi project tunggu hingga selesai </br>
Ketika sudah buka file menggunakan visual studio code dan buka terminal kemudian jalankan perintah "composer install" </br>
Setelah selesai jalankan perintah "php artisan key:generate" </br>
Nyalakan Mysql di xampp kemudian bikin database kosong bebas kasih nama  </br>
Buka lagi visual studio code dan buka file .env kemudian rubah "DB_DATABASE='ganti menjadi Nama Database yang dibuat di xampp tadi'" </br>
Jalankan perintah "php artisan migrate --seed" </br>
Nyalakan Apache juga di xampp </br>
panggil folder yang ada di htdocs di browser "localhost/TA-SIK-JAI" kemudian pilih folder public </br>
Setelah berhasil akan diarahkan ke halaman login dan masukkan username dan password yang ada di database </br>
Username menggunakan nama karyawan dan password menggunakan nip karyawan </br>
Anda bisa login sesuai divisi yang ada yaitu staff, staff hr dan atasan yang di dalamnya memiliki hak akses masing-masing </br>
Jika berhasil login akan diarahkan ke halaman dashboard </br>
Jika ingin logout klik username yang ada di navbar sebelah atas kanan kemudian pilih logout </br>
