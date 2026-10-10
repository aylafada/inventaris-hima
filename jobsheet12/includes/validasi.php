<?php

/*
|--------------------------------------------------------------------------
| validasi.php  (Jobsheet 12 - validasi & sanitasi input)
|--------------------------------------------------------------------------
| input_string() : tipe string, panjang min-max, tanpa karakter kontrol
| input_int()    : integer dalam rentang (filter_var)
| input_date()   : tanggal valid format YYYY-MM-DD
| get_id()       : ?id= sebagai integer positif
| kategori_exists() : whitelist kategori dari tabel kategori
*/

const ROLE_VALID = ['admin', 'petugas'];


class InputException extends Exception
{
}

/* Panjang & potong teks UTF-8 (tanpa bergantung pada ekstensi mbstring) */
function text_len(string $v): int
{
    if (function_exists('mb_strlen')) {
        return mb_strlen($v, 'UTF-8');
    }

    $n = preg_match_all('/./us', $v);

    return $n === false ? strlen($v) : $n;
}

function text_cut(string $v, int $max): string
{
    if (function_exists('mb_substr')) {
        return mb_substr($v, 0, $max, 'UTF-8');
    }

    preg_match('/^.{0,' . $max . '}/us', $v, $m);

    return $m[0] ?? substr($v, 0, $max);
}

function input_string($value, string $label, int $min, int $max): string
{
    if (!is_string($value)) {
        throw new InputException("$label tidak valid.");
    }

    $value = trim($value);
    $len   = text_len($value);

    if ($len < $min || $len > $max) {
        throw new InputException("$label harus $min-$max karakter.");
    }

    if (preg_match('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', $value)) {
        throw new InputException("$label mengandung karakter yang tidak diizinkan.");
    }

    return $value;
}

function input_int($value, string $label, int $min = 0, int $max = 1000000): int
{
    $result = filter_var($value, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => $min, 'max_range' => $max],
    ]);

    if ($result === false) {
        throw new InputException("$label harus berupa angka bulat $min-$max.");
    }

    return (int) $result;
}

function input_date($value, string $label): string
{
    if (!is_string($value)) {
        throw new InputException("$label tidak valid.");
    }

    $d = DateTime::createFromFormat('!Y-m-d', $value);

    if (!$d || $d->format('Y-m-d') !== $value) {
        throw new InputException("$label harus berformat YYYY-MM-DD.");
    }

    return $value;
}

/* Ambil ?id= dari URL sebagai integer positif, atau null */
function get_id(string $key = 'id'): ?int
{
    $v = filter_var($_GET[$key] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

    return $v === false ? null : (int) $v;
}

/* Cek id kategori ada di database (whitelist dari tabel) */
function kategori_exists(PDO $pdo, int $id): bool
{
    $stmt = $pdo->prepare('SELECT 1 FROM kategori WHERE id_kategori = ?');
    $stmt->execute([$id]);

    return (bool) $stmt->fetchColumn();
}


/* Jobsheet 12: ambil data anggota (atau null jika tidak ada) */
function find_anggota(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT id_anggota, nim, nama, no_hp FROM anggota WHERE id_anggota = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ?: null;
}
