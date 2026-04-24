# 📦 Black Box Testing — Sistem PPDB TKQ AS-SALAM

## 📌 Deskripsi
Folder ini berisi dokumen pengujian **Black Box Testing** pada Sistem 
PPDB (Penerimaan Peserta Didik Baru) TKQ AS-SALAM.

Black Box Testing dilakukan dari **sisi pengguna (user interface)** 
tanpa melihat kode internal. Fokus pada fungsionalitas, output sistem, 
dan pengalaman pengguna (Wali Siswa, Admin, Bendahara).

---

## 👥 Tim Pengujian
| Nama | NIM | Peran |
|------|-----|-------|
| Diva Rosalinda | 20231310005 | Tester & Dokumentasi |
| Gita Nurcahyani | 20231310006 | Tester & Dokumentasi |
| Gustiar Rifaldi | 20231310031 | Tester & Dokumentasi |
| Satria Alparezi | 20231310017 | Tester & Dokumentasi |

---

## 🎯 Teknik Pengujian
| Teknik | Keterangan |
|--------|-----------|
| Equivalence Partitioning | Membagi input ke kelas valid & tidak valid |
| Boundary Value Analysis | Menguji nilai batas (min, max, tepat di batas) |
| Decision Table Testing | Menguji kombinasi kondisi & aksi |
| Use Case Testing | Menguji skenario penggunaan nyata per role |

---

## 📂 Daftar Dokumen
| No | Nama File | Modul yang Diuji | Jumlah TC | Status |
|----|-----------|-----------------|-----------|--------|
| 1 | `TestCase_BlackBox_Login_RegisterAkun.pdf` | Login & Registrasi Akun | 11 TC | ✅ Selesai |
| 2 | `TestCase_BlackBox_Pendaftaran.pdf` | Form Pendaftaran Siswa | 12 TC | ✅ Selesai |
| 3 | `TestCase_BlackBox_Pembayaran_Dashboard.pdf` | Pembayaran & Dashboard | 12 TC | ✅ Selesai |

---

## 📊 Rekap Hasil Pengujian
| Dokumen | Total TC | Pass | Fail | Coverage |
|---------|----------|------|------|----------|
| Black Box Login & Register | 11 | 11 | 0 | 100% |
| Black Box Pendaftaran | 12 | 12 | 0 | 100% |
| Black Box Pembayaran & Dashboard | 12 | 12 | 0 | 100% |
| **TOTAL** | **35** | **35** | **0** | **100%** |

---

## 🔍 Halaman yang Diuji
### 1. `views/login.php` & `views/register_akun.php`
- Login valid/invalid untuk Wali dan Pegawai
- Registrasi akun baru, username duplikat
- Validasi field kosong & pesan error
- Navigasi antar halaman

### 2. `views/register.php` — Form Pendaftaran Siswa
- Pendaftaran lengkap dengan umur valid
- Seleksi otomatis berdasarkan umur (>= 4 tahun)
- Boundary Value Analysis pada field umur
- Validasi format file upload (.jpg, .png, .pdf)
- Validasi dropdown dan field wajib

### 3. `views/form_pembayaran.php` & `views/dashboard_wali.php`
- Pembayaran valid dan invalid
- Dropdown tagihan hanya tampil yang belum lunas
- Dashboard per role (admin, bendahara, staf, wali)
- Fitur multi-profil anak
- Fungsi Logout

---

## 🛠️ Teknologi & Cara Pengujian
- **Tools:** Browser (Google Chrome/Firefox)
- **Server:** XAMPP (localhost)
- **Metode:** Observasi langsung UI, URL redirect, pesan error di browser

---

## 📅 Informasi Pengujian
| Keterangan | Detail |
|------------|--------|
| Mata Kuliah | Software Quality |
| Dosen | Deni Suprihadi, S.T., M.Kom., MCE |
| Program Studi | Teknik Informatika |
| Universitas | Universitas Kebangsaan Republik Indonesia |
| Tanggal Pengujian | 24 April 2026 |
