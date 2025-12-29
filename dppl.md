#

#

#

# **DESKRIPSI PERANCANGAN PERANGKAT LUNAK**

#

# **Website Buku Menu Online ScanDish**

#

#

untuk:

Warung Sego Bude

Dipersiapkan oleh:

Amanda Windhu Gustyas (2311102121)

Naufal Luthfi Assary (2311102125)

Muhammad Rafli Alfarizqi (2311102315)

Grashela Ayudia Prameswari (2311102318)

Muhammad Raihan W.S (2311102116)

#

Telkom University Purwokerto

Prodi Teknik Informatika – Universitas Telkom

2025

| ![][image1] | Prodi S1- Teknik Informatika Universitas Telkom |     Nomor Dokumen      |        |       Halaman        |
| :---------: | ----------------------------------------------- | :--------------------: | :----: | :------------------: |
|             |                                                 | **_DPPL-01 SCANDISH_** |        |     _<#>/<jml #_     |
|             |                                                 |       **Revisi**       | _0001_ | _Tgl: <isi tanggal>_ |

#

# **DAFTAR PERUBAHAN**

| Revisi | Deskripsi |
| :----: | :-------: |
| **A**  |           |
| **B**  |           |
| **C**  |           |
| **D**  |           |
| **E**  |           |
| **F**  |           |
| **G**  |           |

#

#

|   INDEX TGL    | \-  |  A  |  B  |  C  |  D  |  E  |  F  |  G  |
| :------------: | :-: | :-: | :-: | :-: | :-: | :-: | :-: | :-: |
|  Ditulis oleh  |     |     |     |     |     |     |     |     |
| Diperiksa oleh |     |     |     |     |     |     |     |     |
| Disetujui oleh |     |     |     |     |     |     |     |     |

#

#

# **Daftar Halaman Perubahan**

| Halaman | Revisi | Halaman | Revisi |
| :-----: | :----: | :-----: | :----: |
|         |        |         |        |

#

# **Daftar Isi**

1. Pendahuluan [5](#1.-pendahuluan)  
   1.1 Tujuan Penulisan Dokumen [5](#tujuan-penulisan-dokumen)  
   1.2 Lingkup Masalah [5](#lingkup-masalah)  
   1.3 Definisi dan Istilah [5](#definisi-dan-istilah)  
   1.4 Aturan Penamaan dan Penomoran [5](#aturan-penamaan-dan-penomoran)  
   1.5 Referensi [5](#referensi)  
   1.6 Ikhtisar Dokumen [5](#ikhtisar-dokumen)  
   2 Deskripsi Perancangan Global [6](#deskripsi-perancangan-global)  
   2.1 Rancangan Lingkungan Implementasi [6](#rancangan-lingkungan-implementasi)  
   2.2 Deskripsi Arsitektural [6](#deskripsi-arsitektural)  
   2.3 Deskripsi Komponen [6](#deskripsi-komponen)  
   3 Perancangan Rinci [7](#perancangan-rinci)  
   3.1 Realisasi Use Case [7](#realisasi-use-case)  
   3.1.1 Use Case <nama use case 1> [7](#use-case-uc-01-login)  
   3.1.1.1 Identifikasi Kelas [7](#identifikasi-kelas-uc-01-login)  
   3.1.1.2 Sequence Diagram [7](#sequence-diagram-uc-01-login)  
   3.1.1.3 Diagram Kelas [7](#diagram-kelas-uc-01-login)  
   3.2 Perancangan Detil Kelas [7](#perancangan-detil-kelas)  
   3.2.1 Kelas <nama kelas> [7](<#kelas-halamanauth-(login/reset/logout)>)  
   3.2.2 Kelas <nama kelas> [8](<#kelas-dashboardmerchant-(filament-panel)>)  
   3.3 Diagram Kelas Keseluruhan [8](#diagram-kelas-keseluruhan)  
   3.4 Algoritma/Query [8](#algoritma/query)  
   3.5 Diagram Statechart [8](#heading)  
   3.6 Perancangan Antarmuka [8](#perancangan-antarmuka)  
   3.7 Perancangan Representasi Persistensi Kelas [9](#perancangan-representasi-persistensi-kelas)  
   3.8 Matriks Kerunutan [9](#matriks-kerunutan)

#

Setelah Daftar Isi Boleh ada Daftar Tabel dan Daftar Gambar

# **1. Pendahuluan** {#1.-pendahuluan}

1. ## **Tujuan Penulisan Dokumen** {#tujuan-penulisan-dokumen}

Dokumen Dokumen Perancangan Perangkat Lunak (DPPL) ini disusun untuk memberikan penjelasan terstruktur mengenai rancangan teknis aplikasi berbasis web Scandish, mencakup arsitektur sistem, desain modul, alur proses, serta spesifikasi komponen yang akan diimplementasikan. Dokumen ini ditujukan sebagai acuan bagi pengembang, analis sistem, dan penguji agar memiliki pemahaman yang konsisten dan menyeluruh terhadap perancangan sistem sebelum memasuki tahap implementasi.

2. ## **Lingkup Masalah** {#lingkup-masalah}

Scandish merupakan aplikasi berbasis web yang dirancang untuk membantu pemilik usaha kuliner dalam membuat dan mengelola buku menu digital. Setiap toko memperoleh halaman menu yang dapat diakses melalui tautan unik atau QR code. Sistem mendukung pengelolaan multi-toko, kategori produk, item produk dengan detail bahan, serta mekanisme langganan (subscription) untuk menambah kapasitas produk melebihi batas gratis. Lingkup ini sesuai dengan ruang lingkup yang telah didefinisikan dalam dokumen Spesifikasi Kebutuhan Perangkat Lunak (SKPL).

3.  ## **Definisi dan Istilah** {#definisi-dan-istilah}

          Dokumen ini menggunakan beberapa istilah yang didefinisikan sebagai berikut:

-   Scandish: Aplikasi berbasis web untuk pembuatan dan pengelolaan buku menu digital multi-toko.
-   Toko / Merchant: Pemilik usaha kuliner yang mendaftarkan dan mengelola data pada aplikasi (diwakili oleh entitas User dengan role 'store').
-   Produk (Product): Item makanan atau minuman yang ditampilkan pada halaman toko (sebelumnya disebut Menu).
-   Kategori Produk (Product Category): Pengelompokan produk berdasarkan jenis tertentu.
-   Bahan Produk (Product Ingredient): Informasi bahan-bahan yang digunakan dalam sebuah produk.
-   Dashboard Admin: Antarmuka administratif untuk mengelola toko, pengguna, kategori, produk, dan subscription.
-   Dashboard Merchant: Antarmuka untuk pemilik toko dalam mengelola profil toko, kategori, dan produk.
-   Subscription: Layanan berlangganan premium untuk toko yang ingin menambah produk di atas batas gratis (terintegrasi dengan Midtrans).
-   Midtrans: Layanan payment gateway yang digunakan untuk pemrosesan pembayaran subscription.
-   CMS (Content Management System): Sistem untuk mengelola konten toko dan produk.
-   QR Code: Kode yang digunakan untuk mengakses halaman toko via pemindaian.

    4. ## **Aturan Penamaan dan Penomoran** {#aturan-penamaan-dan-penomoran}

##### **Tabel 1 Aturan Penamaan dan Penomoran**

| Hal/Bagian               | Aturan Penomoran/Penamaan                                                                                                                                                         |
| ------------------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Bab dan Subbab           | Menggunakan angka Arab dengan format hirarkis: 1, 1.1, 1.1.1, dan seterusnya sesuai struktur dokumen.                                                                             |
| Tabel                    | Dituliskan sebagai Tabel X dengan nomor urut mulai dari 1 sampai akhir dokumen, diikuti judul tabel (misal: Tabel 1 Aturan Penamaan dan Penomoran).                               |
| Gambar/ Diagram          | Dituliskan sebagai Gambar X dengan nomor urut mulai dari 1 sampai akhir dokumen, diikuti judul gambar/diagram.                                                                    |
| Usecase                  | Dinamai dengan format UC-XX di mana XX adalah nomor urut dua digit, misal: UC-01 Login, UC-02 Registrasi Toko.                                                                    |
| Kelas (class) UML        | Menggunakan gaya PascalCase tanpa spasi, misalnya: User, Product, ProductCategory, Subscription, Transaction.                                                                     |
| Atribut dan metode kelas | Atribut menggunakan huruf kecil dengan pemisah underscore atau camelCase (misal: created_at, storeName), sedangkan metode ditulis sebagai fungsi (mis: login(), updateProfile()). |
| Metode Kelas             | Ditulis dalam bentuk fungsi dengan tanda kurung. Contoh: _login(), updateProfile(), generateQRCode()_.                                                                            |
| Algoritma / Query        | Algoritma diberi kode **Algo-XXX**, sedangkan query diberi kode **Q-XXX** sesuai urutan kemunculan pada dokumen.                                                                  |

5. ## **Referensi** {#referensi}

Referensi yang digunakan dalam penyusunan dokumen DPPL ini adalah:  
\[1\] Dokumen Spesifikasi Kebutuhan Perangkat Lunak (SKPL) Aplikasi ScanDish.  
\[2\] Laravel Official Documentation, https://laravel.com/docs  
\[3\] FilamentPHP Documentation, https://filamentphp.com/docs  
\[4\] Midtrans Payment Gateway Documentation, https://docs.midtrans.com  
\[5\] MySQL Reference Manual, https://dev.mysql.com/doc/

6. ## **Ikhtisar Dokumen** {#ikhtisar-dokumen}

Dokumen Perancangan Perangkat Lunak (DPPL) ScanDish merupakan dokumen yang menjelaskan rancangan teknis dan fungsional dari sistem ScanDish yang dikembangkan sebagai aplikasi web buku menu digital multi-toko. Dokumen ini disusun sebagai acuan dalam proses implementasi agar pengembangan sistem berjalan sesuai kebutuhan pengguna dan spesifikasi yang telah ditetapkan pada dokumen SKPL ScanDish.

DPPL ini memuat perancangan arsitektur sistem (berbasis Laravel 11 dengan Filament sebagai dashboard admin/merchant), rancangan basis data (MySQL/MariaDB), rancangan antarmuka pengguna (halaman publik produk, dashboard pemilik toko, dan dashboard admin), serta pemodelan proses menggunakan diagram yang relevan (misalnya use case, sequence/activity, dan class diagram). Dengan adanya dokumen ini, proses pengembangan ScanDish diharapkan dapat berjalan lebih terstruktur, konsisten, serta meminimalkan kesalahan pada tahap implementasi dan pengujian, termasuk integrasi pembayaran subscription melalui Midtrans.

#

2. # **Deskripsi Perancangan Global** {#deskripsi-perancangan-global}

    1. ## **Rancangan Lingkungan Implementasi** {#rancangan-lingkungan-implementasi}

1. Operating System  
   Aplikasi ScanDish dikembangkan sebagai aplikasi berbasis web sehingga dapat dijalankan pada berbagai sistem operasi. Lingkungan pengembangan dapat menggunakan Windows, Linux, atau macOS, sedangkan lingkungan produksi umumnya menggunakan Linux server (Ubuntu atau sejenisnya).
1. DBMS  
   Sistem manajemen basis data yang digunakan adalah MySQL atau MariaDB untuk menyimpan data pengguna, produk, kategori produk, bahan produk, serta data subscription.
1. Development Tools  
   Alat bantu pengembangan yang digunakan meliputi Visual Studio Code sebagai code editor, Laragon atau web server lokal sejenis untuk pengembangan, Git sebagai version control, serta browser modern untuk pengujian aplikasi.
1. Filing System  
   Sistem penyimpanan file menggunakan file system bawaan Laravel (public storage) untuk menyimpan aset seperti gambar produk.
1. Bahasa Pemrograman  
   Bahasa pemrograman yang digunakan adalah PHP versi 8.2 atau lebih baru dengan framework Laravel 11.

1. ## **Deskripsi Arsitektural** {#deskripsi-arsitektural}

![][image2]  
Gambar 1 Arsitektural  
Aplikasi ScanDish dibangun di atas framework Laravel dengan menggunakan **FilamentPHP** sebagai kerangka kerja untuk panel admin dan dashboard merchant. Arsitektur ini menggabungkan konsep MVC (Model-View-Controller) dengan arsitektur berbasis komponen (Resource) yang disediakan oleh Filament.

1. **Model**  
   Berfungsi untuk mengelola struktur data, validasi, serta interaksi dengan basis data menggunakan ORM Eloquent Laravel. Model menangani penyimpanan dan pengambilan data yang berkaitan dengan pengguna, produk, kategori, dan subscription.  
   Contoh model yang digunakan: `User`, `Product`, `ProductCategory`, `ProductIngredient`, `Subscription`, `Transaction`, `TransactionDetail`.

2. **Filament Resources & Pages (Controller Logic & View)**  
   Alih-alih menggunakan Controller konvensional untuk manajemen data, ScanDish menggunakan **Filament Resources**. Setiap resource (seperti `ProductResource`, `UserResource`) membungkus logika bisnis (CRUD), validasi form, dan definisi tabel dalam satu kesatuan. Filament secara otomatis menangani routing, rendering view (Blade), dan pemrosesan request.

    - **Resources**: Mengelola entitas utama (Produk, Kategori, User).
    - **Pages**: Halaman khusus seperti Dashboard, Login, Register.
    - **Widgets**: Komponen visual untuk statistik dan grafik.

3. **Frontend Controller**  
   Untuk halaman publik (yang diakses pelanggan untuk melihat menu), digunakan Controller standar Laravel (seperti `FrontendController`) yang mengembalikan View berbasis Blade Template.

Arsitektur ini mempercepat pengembangan fitur administratif (backend) sekaligus tetap memberikan fleksibilitas penuh untuk tampilan frontend pelanggan.

3. ## **Deskripsi Komponen** {#deskripsi-komponen}

**Tabel 2 Deskripsi Komponen**

| No  | Nama Komponen                | Keterangan                                                                                                                                                              |
| :-- | :--------------------------- | :---------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| 1   | Modul Autentikasi            | Mengelola proses login, logout, registrasi pemilik toko, serta validasi hak akses pengguna (admin dan pemilik toko) menggunakan fitur autentikasi Laravel dan Filament. |
| 2   | Modul Manajemen Pengguna     | Digunakan oleh admin untuk mengelola data pengguna (`UserResource`), termasuk pemilik toko dan admin sistem.                                                            |
| 3   | Modul Kategori Produk        | Menyediakan fungsi untuk menambah, mengubah, dan menghapus kategori produk (`ProductCategoryResource`).                                                                 |
| 4   | Modul Manajemen Produk       | Mengelola data produk (`ProductResource`) meliputi tambah, ubah, hapus produk, pengaturan harga, serta upload gambar produk.                                            |
| 5   | Modul Bahan Produk           | Mengelola informasi bahan-bahan (`ProductIngredient`) yang terkait dengan suatu produk.                                                                                 |
| 6   | Modul Publikasi Menu         | Menyediakan halaman publik yang menampilkan daftar produk toko yang dapat diakses pelanggan.                                                                            |
| 7   | Modul Filter & Detail Produk | Menyediakan fitur pencarian, filter produk berdasarkan kategori, dan tampilan detail produk untuk pelanggan.                                                            |
| 8   | Modul Subscription           | Mengelola status langganan toko (`SubscriptionResource`) dan pembatasan jumlah produk.                                                                                  |
| 9   | Modul Pembayaran             | Menangani proses pembayaran subscription premium melalui integrasi dengan Midtrans (`TransactionResource`).                                                             |
| 10  | Modul Monitoring Transaksi   | Digunakan admin untuk memantau status transaksi subscription dan detail pembayaran (`TransactionDetail`).                                                               |
| 11  | Modul Dashboard Merchant     | Antarmuka berbasis Filament untuk pemilik toko dalam mengelola produk, kategori, dan melihat status subscription.                                                       |
| 12  | Modul Dashboard Admin        | Antarmuka berbasis Filament untuk admin mengelola pengguna, transaksi, dan data sistem secara keseluruhan.                                                              |
| 13  | Modul Penyimpanan File       | Mengelola penyimpanan file gambar produk menggunakan storage Laravel.                                                                                                   |

3. # **Perancangan Rinci** {#perancangan-rinci}

    1. ## **Realisasi Use Case** {#realisasi-use-case}

        1. ### **Use Case UC-01 Login** {#use-case-uc-01-login}

Use case UC-01 Login merealisasikan proses autentikasi pengguna (Pemilik Toko dan Admin) untuk mengakses sistem ScanDish sesuai dengan peran masing-masing.

1. #### **Identifikasi Kelas UC-01 Login** {#identifikasi-kelas-uc-01-login}

**Tabel 3 Identifikasi kelas UC-01 Login**

| No  | Nama Kelas Perancangan    | Nama Kelas Analisis Terkait |
| :-- | :------------------------ | :-------------------------- |
| 1   | Filament\Pages\Auth\Login | Halaman Login Filament      |
| 2   | User                      | User Model                  |
| 3   | AuthManager               | Sistem Autentikasi Laravel  |

2. #### **Sequence Diagram UC-01 Login** {#sequence-diagram-uc-01-login}

    ![][image3]

    **Gambar 2 Sequence Diagram UC-01 Login**

    3. #### **Diagram Kelas UC-01 Login** {#diagram-kelas-uc-01-login}

    ![][image4]  
    **Gambar 3 Diagram Kelas UC-01 Login**

3. ### **Use Case UC-02 Registrasi Toko**

    Use case UC-02 Registrasi Toko merealisasikan proses pendaftaran akun pemilik toko agar dapat menggunakan fitur pengelolaan produk pada ScanDish.

    1. #### **Identifikasi Kelas UC-02 Registrasi Toko**

    **Tabel 4 Identifikasi Kelas UC-02 Registrasi Toko**

    | No  | Nama Kelas Perancangan       | Nama Kelas Analisis Terkait |
    | :-- | :--------------------------- | :-------------------------- |
    | 1   | Filament\Pages\Auth\Register | Halaman Register Filament   |
    | 2   | User                         | User Model                  |
    | 3   | CreateUser (Action)          | Logika Pembuatan User       |

    2. #### **Sequence Diagram UC-02 Registrasi Toko**

![][image5]  
**Gambar 4 Sequence Diagram UC-02 Registrasi Toko**

3. #### **Diagram Kelas UC-02 Registrasi Toko**

![][image6]  
**Gambar 5 Diagram Kelas UC-02 Registrasi Toko**

3. ### **Use Case UC-03 Kelola Profil Toko**

    Use case ini merealisasikan proses pengelolaan informasi toko oleh Pemilik Toko, meliputi perubahan data nama dan email.

    1. #### **Identifikasi Kelas UC-03 Kelola Profil Toko**

    **Tabel 5 Identifikasi Kelas UC-03 Kelola Profil Toko**

    | No  | Nama Kelas Perancangan          | Nama Kelas Analisis Terkait |
    | :-- | :------------------------------ | :-------------------------- |
    | 1   | Filament\Pages\Auth\EditProfile | Halaman Edit Profil         |
    | 2   | User                            | User Model                  |

    2. #### **Sequence Diagram UC-03 Kelola Profil Toko**

**![][image7]**  
**Gambar 6 Sequence Diagram UC-03 Kelola Profil Toko**

3. #### **Diagram Kelas UC-03 Kelola Profil Toko**

![][image8]  
**Gambar 7 Diagram Kelas UC-03 Kelola Profil Toko**

4. ### **Use Case UC-04 Upload Gambar Produk**

    Use case ini merealisasikan proses unggah gambar produk oleh Pemilik Toko saat menambah atau mengedit produk.

    1. #### **Identifikasi Kelas UC-04 Upload Gambar Produk**

    **Tabel 6 Identifikasi Kelas UC-04 Upload Gambar Produk**

    | No  | Nama Kelas Perancangan | Nama Kelas Analisis Terkait |
    | :-- | :--------------------- | :-------------------------- |
    | 1   | ProductResource        | Resource Produk             |
    | 2   | FileUpload (Component) | Komponen Upload File        |
    | 3   | Product                | Product Model               |

    2. #### **Sequence Diagram UC-04 Upload Gambar Produk**

**![][image9]**  
**Gambar 8 Sequence Diagram UC-04 Upload Gambar Produk**

3. #### **Diagram Kelas UC-04 Upload Gambar Produk**

![][image10]  
**Gambar 9 Diagram Kelas UC-04 Upload Gambar Produk**

5.  ### **Use Case UC-05 Hapus Produk**

    Use case ini merealisasikan proses penghapusan data produk oleh Pemilik Toko.

    1. #### **Identifikasi Kelas UC-05 Hapus Produk**

    **Tabel 7 Identifikasi Kelas UC-05 Hapus Produk**

    | No  | Nama Kelas Perancangan | Nama Kelas Analisis Terkait |
    | :-- | :--------------------- | :-------------------------- |
    | 1   | ProductResource        | Resource Produk             |
    | 2   | DeleteAction           | Aksi Hapus                  |
    | 3   | Product                | Product Model               |

    2. #### **Sequence Diagram UC-05 Hapus Produk**

    **![][image11]**

    **Gambar 10 Sequence Diagram UC-05 Hapus Produk**

          3. #### **Diagram Kelas UC-05 Hapus Produk**

    ![][image12]

    **Gambar 11 Diagram Kelas UC-05 Hapus Produk**

    6. ### **Use Case UC-06 Edit Produk**

        1. #### **Identifikasi Kelas UC-06 Edit Produk**

**Tabel 8 Identifikasi Kelas UC-06 Edit Produk**

| No  | Nama Kelas Perancangan | Nama Kelas Analisis Terkait |
| :-- | :--------------------- | :-------------------------- |
| 1   | ProductResource        | Resource Produk             |
| 2   | EditProduct (Page)     | Halaman Edit Produk         |
| 3   | Product                | Product Model               |
| 4   | ProductCategory        | Kategori Produk             |

2. #### **Sequence Diagram UC-06 Edit Produk**

**![][image13]**  
**Gambar 12 Sequence Diagram UC-06 Edit Produk**

3. #### **Diagram Kelas UC-06 Edit Produk**

![][image14]  
**Gambar 13 Diagram Kelas UC-06 Edit Produk**

7. ### **Use Case UC-07 Tambah Produk**

    Use case ini merealisasikan proses penambahan produk baru oleh Pemilik Toko. Produk yang ditambahkan akan disimpan ke dalam sistem.

    1. #### **Identifikasi Kelas UC-07 Tambah Produk**

    **Tabel 9 Identifikasi Kelas UC-07 Tambah Produk**

    | No  | Nama Kelas Perancangan | Nama Kelas Analisis Terkait |
    | :-- | :--------------------- | :-------------------------- |
    | 1   | ProductResource        | Resource Produk             |
    | 2   | CreateProduct (Page)   | Halaman Tambah Produk       |
    | 3   | Product                | Product Model               |
    | 4   | ProductCategory        | Kategori Produk             |

    2. #### **Sequence Diagram UC-07 Tambah Produk**

**![][image15]**  
**Gambar 14 Sequence Diagram UC-07 Tambah Produk**

3.  #### **Diagram Kelas UC-07 Tambah Produk**

    ![][image16]

    **Gambar 15 Diagram Kelas UC-07 Tambah Produk**

    8. ### **Use Case UC-08 Kelola Kategori Produk**

    Use case ini merealisasikan proses pengelolaan kategori produk oleh Pemilik Toko.

    1. #### **Identifikasi Kelas UC-08 Kelola Kategori Produk**

    **Tabel 10 Identifikasi Kelas UC-08 Kelola Kategori Produk**

    | No  | Nama Kelas Perancangan  | Nama Kelas Analisis Terkait |
    | :-- | :---------------------- | :-------------------------- |
    | 1   | ProductCategoryResource | Resource Kategori Produk    |
    | 2   | ProductCategory         | Model Kategori Produk       |

          2. #### **Sequence Diagram UC-08 Kelola Kategori Produk**

**![][image17]**  
**Gambar 16 Sequence Diagram UC-08 Kelola Kategori Produk**

3. #### **Diagram Kelas UC-8 Kelola Kategori Produk**

![][image18]  
**Gambar 17 Diagram Kelas UC-8 Kelola Kategori Produk**

9. ### **Use Case UC-09 Generate QR Kode**

[image1]: url_gambar_1
[image2]: url_gambar_2
[image3]: url_gambar_3
[image4]: url_gambar_4
[image5]: url_gambar_5
[image6]: url_gambar_6
[image7]: url_gambar_7
[image8]: url_gambar_8
[image9]: url_gambar_9
[image10]: url_gambar_10
[image11]: url_gambar_11
[image12]: url_gambar_12
[image13]: url_gambar_13
[image14]: url_gambar_14
[image15]: url_gambar_15
[image16]: url_gambar_16
[image17]: url_gambar_17
[image18]: url_gambar_18
