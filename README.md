fitur-baru
# Sistem PPDB SEKOLAH

# Sistem PPDB 
main

Sistem PPDB (Penerimaan Peserta Didik Baru) adalah aplikasi berbasis web yang dirancang untuk mengelola proses pendaftaran siswa di TKQ AS-SALAM secara digital.
Sistem ini bertujuan untuk mempermudah proses registrasi, pengunggahan dokumen, pembayaran, hingga pelaporan secara terstruktur dan efisien.
Aplikasi ini mendukung berbagai peran pengguna seperti admin, bendahara, kepala sekolah, dan wali siswa untuk memastikan seluruh proses berjalan dengan baik dan terorganisir.

## Fitur Utama

### Wali Siswa
- Melakukan registrasi siswa secara online
- Mengunggah dokumen persyaratan (KK, Akta, dll)
- Melakukan pembayaran
- Melihat status pendaftaran dan hasil seleksi

### Admin PPDB
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

Beberapa tabel utama dalam sistem:

- **siswa** → Data siswa
- **wali_siswa** → Data wali/orang tua
- **pegawai** → Data admin dan pengguna internal
- **rincian_biaya** → Data rincian biaya
- **pembayaran** → Data transaksi pembayaran
- **hasil_seleksi** → Hasil seleksi siswa

---

## Teknologi yang Digunakan

- PHP (Native)
- MySQL
- HTML, CSS, JavaScript
- XAMPP (Apache Server)
- Midtrans (Konsep Payment Gateway)

---

## Cara Menjalankan Project

1. Clone repository:https://github.com/SatriaAlp/PPDB.git

