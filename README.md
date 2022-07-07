# isblog (Web Blog 3 Hak Akses)
Blog Menggunakan CI_3 Base

Akses Admin : 
  1. Username : Admin
  2. Password : admin1234

Akses Penulis : 
  1. Username : Arif
  2. Password : user1234
	
Username dapat diganti sesuai keinginan

Fitur : 
  1. CRUD Blog (Kategori, Tag)
  2. Datatable
  3. Chart Pengunjung
  4. Komentar dan Kelola Komentar
  5. WYSIWYG Summernote support delete dan insert image
  6. Kelola Database, Download DB & Restore DB (Beta)
  7. Recaptcha
  8. Aktivasi Akun dan Lupa Password
  9. Manajemen data user (Khusus akses Admin)
 10. Pengaturan

## Cara Penggunaan
1. Jalankan XAMPP anda atau yang lain
2. Buat Repository dan Masukkan hasil download anda kedalam repository (Maksudnya adalah clone atau yang lainnya)
3. Panggil Repository dengan http://localhost/(sesuai_direktori_anda) 
4. Buat database baru di mysql dan import dari direktori folder database **DATABASE** dengan nama `(terserah).sql`
5. Pastikan kode pada file `application/config/database.php` telah sama seperti baris kode berikut :

- Default DB "isblog" (bisa diganti sesuai keinginan), update jika semisal merubah nama database 'database' => '(nama_database)' sesuai nama di mysql.

(tampilan default dari projek ini di file database.php)
``` php
defined('BASEPATH') OR exit('No direct script access allowed');
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'isblog',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
```
