@component('mail::message')
# Pesan Baru Masuk — APPSI

Ada pesan baru yang masuk melalui formulir kontak website APPSI.

---

**Nama:** {{ $pesan->nama }}
**Email:** {{ $pesan->email }}
**Subjek:** {{ $pesan->subjek }}

**Pesan:**

{{ $pesan->pesan }}

---

@component('mail::button', ['url' => url('/admin/pesan/' . $pesan->id)])
Lihat di Panel Admin
@endcomponent

Pesan ini dikirim secara otomatis dari website APPSI.
@endcomponent
