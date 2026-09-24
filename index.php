```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Desain Pemrograman Web</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --navy: #183142;
            --blue: #42677a;
            --sage: #4f7d6b;
            --green: #6f927f;
            --cream: #f6f5ef;
            --white: #ffffff;
            --text: #24333b;
            --muted: #718087;
            --border: #dfe6e2;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--cream);
            color: var(--text);
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 55px 35px;
        }

        /* HEADER */
        .header {
            margin-bottom: 40px;
        }

        .eyebrow {
            color: var(--sage);
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .header h1 {
            color: var(--navy);
            font-size: 38px;
            margin-bottom: 12px;
        }

        .header p:last-child {
            color: var(--muted);
            font-size: 15px;
            line-height: 1.6;
            max-width: 650px;
        }

        /* GRID */
        .jobsheet-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        /* CARD */
        .jobsheet-card {
            position: relative;
            overflow: hidden;

            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 18px;

            padding: 28px;
            min-height: 245px;

            display: flex;
            flex-direction: column;

            transition: 0.25s ease;
        }

        .jobsheet-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(24, 49, 66, 0.13);
        }

        /* AKSEN WARNA DI ATAS CARD */
        .jobsheet-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: var(--sage);
        }

        .jobsheet-card:nth-child(2)::before {
            background: #587b91;
        }

        .jobsheet-card:nth-child(3)::before {
            background: #769b89;
        }

        .jobsheet-card:nth-child(4)::before {
            background: #9a8b68;
        }

        .jobsheet-card:nth-child(5)::before {
            background: #607f91;
        }

        .jobsheet-card:nth-child(6)::before {
            background: #668c7c;
        }

        .jobsheet-card:nth-child(7)::before {
            background: #7b6f8d;
        }

        .jobsheet-card:nth-child(8)::before {
            background: var(--navy);
        }

        /* NOMOR */
        .number {
            color: var(--sage);
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 1.5px;
            margin-bottom: 18px;
        }

        .jobsheet-card:nth-child(2) .number {
            color: #587b91;
        }

        .jobsheet-card:nth-child(3) .number {
            color: #668c7c;
        }

        .jobsheet-card:nth-child(4) .number {
            color: #9a8b68;
        }

        .jobsheet-card:nth-child(5) .number {
            color: #607f91;
        }

        .jobsheet-card:nth-child(6) .number {
            color: #668c7c;
        }

        .jobsheet-card:nth-child(7) .number {
            color: #7b6f8d;
        }

        .jobsheet-card:nth-child(8) .number {
            color: var(--navy);
        }

        /* JUDUL */
        .jobsheet-card h2 {
            color: var(--navy);
            font-size: 22px;
            margin-bottom: 10px;
        }

        /* DESKRIPSI */
        .jobsheet-card p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
        }

        /* BUTTON */
        .button {
            margin-top: auto;
            padding-top: 22px;
        }

        .button a {
            display: inline-block;

            background: var(--navy);
            color: white;

            text-decoration: none;

            padding: 10px 17px;
            border-radius: 9px;

            font-size: 13px;
            font-weight: bold;

            transition: 0.2s ease;
        }

        .button a:hover {
            background: var(--sage);
            transform: translateY(-2px);
        }

        /* CURRENT JOBSHEET */
        .current {
            background: #eef4f1;
            border-color: #b8cec3;
        }

        .current h2 {
            color: var(--navy);
        }

        .current .button a {
            background: var(--sage);
        }

        .current .button a:hover {
            background: var(--navy);
        }

        /* RESPONSIVE */
        @media (max-width: 700px) {
            .container {
                padding: 35px 20px;
            }

            .jobsheet-grid {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 30px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">

        <p class="eyebrow">
            Desain Pemrograman Web
        </p>

        <h1>
            Perkembangan Project
        </h1>

        <p>
            Kumpulan hasil pengembangan project dari Jobsheet 1
            hingga Jobsheet 8, mulai dari struktur halaman hingga
            sistem inventaris berbasis database.
        </p>

    </div>


    <div class="jobsheet-grid">

        <!-- JOBSHEET 1 -->
        <div class="jobsheet-card">

            <div class="number">
                JOBSHEET 01
            </div>

            <h2>
                Struktur HTML
            </h2>

            <p>
                Membuat struktur dasar website menggunakan HTML,
                mulai dari halaman anggota, buku, hingga form
                untuk menambahkan data.
            </p>

            <div class="button">
                <a href="/jobsheet1/">
                    Lihat Jobsheet →
                </a>
            </div>

        </div>


        <!-- JOBSHEET 2 -->
        <div class="jobsheet-card">

            <div class="number">
                JOBSHEET 02
            </div>

            <h2>
                Styling dengan CSS
            </h2>

            <p>
                Mengembangkan tampilan halaman dengan CSS,
                termasuk pengaturan layout, warna, typography,
                tabel, form, dan komponen halaman.
            </p>

            <div class="button">
                <a href="/jobsheet2/">
                    Lihat Jobsheet →
                </a>
            </div>

        </div>


        <!-- JOBSHEET 3 -->
        <div class="jobsheet-card">

            <div class="number">
                JOBSHEET 03
            </div>

            <h2>
                Pengembangan Tampilan
            </h2>

            <p>
                Melanjutkan pengembangan halaman website dengan
                menerapkan struktur dan tampilan yang lebih
                terorganisir.
            </p>

            <div class="button">
                <a href="/jobsheet3/">
                    Lihat Jobsheet →
                </a>
            </div>

        </div>


        <!-- JOBSHEET 4 -->
        <div class="jobsheet-card">

            <div class="number">
                JOBSHEET 04
            </div>

            <h2>
                Perancangan Website
            </h2>

            <p>
                Mengembangkan rancangan halaman dan struktur
                project sebagai dasar sebelum menambahkan
                fitur interaktif.
            </p>

            <div class="button">
                <a href="/jobsheet4/">
                    Lihat Jobsheet →
                </a>
            </div>

        </div>


        <!-- JOBSHEET 5 -->
        <div class="jobsheet-card">

            <div class="number">
                JOBSHEET 05
            </div>

            <h2>
                JavaScript & DOM
            </h2>

            <p>
                Menambahkan interaksi pada website menggunakan
                JavaScript, seperti hamburger menu, validasi,
                pencarian, dan pengelolaan elemen DOM.
            </p>

            <div class="button">
                <a href="/jobsheet5/">
                    Lihat Jobsheet →
                </a>
            </div>

        </div>


        <!-- JOBSHEET 6 -->
        <div class="jobsheet-card">

            <div class="number">
                JOBSHEET 06
            </div>

            <h2>
                Fetch API & JSON
            </h2>

            <p>
                Mengambil dan menampilkan data secara asynchronous
                menggunakan Fetch API dengan sumber data
                berbentuk JSON.
            </p>

            <div class="button">
                <a href="/jobsheet6/">
                    Lihat Jobsheet →
                </a>
            </div>

        </div>


        <!-- JOBSHEET 7 -->
        <div class="jobsheet-card">

            <div class="number">
                JOBSHEET 07
            </div>

            <h2>
                Integrasi PHP
            </h2>

            <p>
                Mengubah project menjadi halaman berbasis PHP
                dengan pemisahan komponen dan proses pengolahan
                data melalui server.
            </p>

            <div class="button">
                <a href="/jobsheet7/">
                    Lihat Jobsheet →
                </a>
            </div>

        </div>


        <!-- JOBSHEET 8 -->
        <div class="jobsheet-card current">

            <div class="number">
                JOBSHEET 08 • CURRENT
            </div>

            <h2>
                PHP + Database
            </h2>

            <p>
                Mengembangkan sistem inventaris dengan PHP dan
                database, termasuk pengelolaan barang,
                peminjaman, pengembalian, dan dashboard.
            </p>

            <div class="button">
                <a href="/jobsheet8/">
                    Buka Project →
                </a>
            </div>

        </div>

    </div>

</div>

</body>
</html>
```
