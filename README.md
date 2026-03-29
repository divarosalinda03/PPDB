# Sistem PPDB(Penerimaan Peserta Didik Baru)

Sistem PPDB (Penerimaan Peserta Didik Baru) adalah aplikasi berbasis web yang dirancang untuk mengelola proses pendaftaran siswa di TKQ AS-SALAM secara digital. 
Sistem ini bertujuan untuk mempermudah proses registrasi, pengunggahan dokumen, pembayaran, hingga pelaporan secara terstruktur dan efisien.
Aplikasi ini mendukung berbagai peran pengguna seperti admin, bendahara, kepala sekolah, dan wali siswa untuk memastikan seluruh proses berjalan dengan baik dan terorganisir.

## Fitur Utama

### Wali Siswa
- Melakukan registrasi siswa secara online
- Mengunggah dokumen persyaratan (KK, Akta, dll)
- Melakukan pembayaran
- Melihat status pendaftaran dan hasil seleksi

### Admin PPDB (Penerimaan Peserta Didik Baru)
- Mengelola akun siswa
- Memverifikasi berkas pendaftaran
- Mengelola data pendaftaran

### Bendahara
- Memverifikasi pembayaran
- Mengelola transaksi keuangan
- Melihat dan mencetak laporan pembayaran

### Kepala Sekolah
- Melihat laporan pendaftaran siswa
- Melihat laporan pembayaran

## Kemampuan Sistem

- Sistem pendaftaran siswa secara online
- Upload dan verifikasi dokumen
- Sistem login multi-role (Admin, Bendahara, Kepala Sekolah, Wali)
- Sistem pembayaran (konsep integrasi payment gateway)
- Verifikasi dan monitoring pembayaran
- Sistem laporan (pendaftaran dan keuangan)
- Manajemen hasil seleksi siswa


## Struktur Database

Beberapa tabel utama:
- `siswa` → Data siswa
- `wali_siswa` → Data orang tua/wali
- `pegawai` → Admin & user internal
- `rincian_biaya` → Daftar biaya
- `pembayaran` → Data transaksi pembayaran
- `hasil_seleksi` → Status kelulusan


## Teknologi yang Digunakan

- **Bahasa**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Server**: XAMPP / Apache
- **Payment Gateway**: Midtrans


## Cara Menjalankan Project

1. Clone repository:
   ```bash
   git clone https://github.com/SatriaAlp/PPDB.git
