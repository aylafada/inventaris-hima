<?php

session_start();

if (!isset($_SESSION['buku'])) {
    $_SESSION['buku'] = [
        [
            'judul' => 'Laskar Pelangi',
            'pengarang' => 'Andrea Hirata',
            'tahun' => 2005,
            'stok' => 4
        ],
        [
            'judul' => 'Bumi Manusia',
            'pengarang' => 'Pramoedya Ananta Toer',
            'tahun' => 1980,
            'stok' => 2
        ],
        [
            'judul' => 'Negeri 5 Menara',
            'pengarang' => 'Ahmad Fuadi',
            'tahun' => 2009,
            'stok' => 0
        ],
        [
            'judul' => 'Filosofi Teras',
            'pengarang' => 'Henry Manampiring',
            'tahun' => 2018,
            'stok' => 5
        ],
        [
            'judul' => 'Ronggeng Dukuh Paruk',
            'pengarang' => 'Ahmad Tohari',
            'tahun' => 1982,
            'stok' => 1
        ],
        [
            'judul' => 'Filosofi Kopi',
            'pengarang' => 'Dewi Lestari',
            'tahun' => 2006,
            'stok' => 10
        ],
        [
            'judul' => 'Cantik Itu Luka',
            'pengarang' => 'Eka Kurniawan',
            'tahun' => 2002,
            'stok' => 7
        ],
        [
            'judul' => 'Perahu Kertas',
            'pengarang' => 'Dewi Lestari',
            'tahun' => 2009,
            'stok' => 3
        ],
        [
            'judul' => 'Ayat-Ayat Cinta',
            'pengarang' => 'Habiburrahman El Shirazy',
            'tahun' => 2004,
            'stok' => 6
        ],
        [
            'judul' => 'Dilan 1990',
            'pengarang' => 'Pidi Baiq',
            'tahun' => 2014,
            'stok' => 4
        ]
    ];  
}

if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [
        [
            'no_anggota' => 'A001',
            'nama' => 'Siti Aminah',
            'alamat' => 'Malang',
            'no_hp' => '081230012039'
        ],
        [
            'no_anggota' => 'A002',
            'nama' => 'Budi Santoso',
            'alamat' => 'Batu',
            'no_hp' => '081334567'
        ],
        [
            'no_anggota' => 'A003',
            'nama' => 'Rina Wulandari',
            'alamat' => 'Malang',
            'no_hp' => '081445678'
        ],
        [
            'no_anggota' => 'A004',
            'nama' => 'Andi Pratama',
            'alamat' => 'Kepanjen',
            'no_hp' => '081556789'
        ],
        [
            'no_anggota' => 'A005',
            'nama' => 'Dina Lestari',
            'alamat' => 'Batu',
            'no_hp' => '081667890'
        ],
        [
            'no_anggota' => 'A006',
            'nama' => 'Fajar Ramadhan',
            'alamat' => 'Malang',
            'no_hp' => '081778901'
        ],
        [
            'no_anggota' => 'A007',
            'nama' => 'Nadia Putri',
            'alamat' => 'Blitar',
            'no_hp' => '081889012'
        ],
        [
            'no_anggota' => 'A008',
            'nama' => 'Rizky Maulana',
            'alamat' => 'Malang',
            'no_hp' => '081990123'
        ],
        [
            'no_anggota' => 'A009',
            'nama' => 'Citra Permata',
            'alamat' => 'Batu',
            'no_hp' => '082101234'
        ],
        [
            'no_anggota' => 'A010',
            'nama' => 'Yoga Saputra',
            'alamat' => 'Malang',
            'no_hp' => '082212345'
        ]
    ];
}