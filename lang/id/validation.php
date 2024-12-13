<?php

return [

    /*
    |----------------------------------------------------------------------
    | Validation Language Lines
    |----------------------------------------------------------------------
    |
    | Berikut adalah pesan kesalahan yang digunakan oleh kelas validator. Beberapa
    | aturan memiliki beberapa versi, seperti aturan ukuran. Anda dapat mengubah
    | setiap pesan ini sesuai dengan kebutuhan Anda di sini.
    |
    */

    'accepted' => 'Kolom :attribute harus diterima.',
    'accepted_if' => 'Kolom :attribute harus diterima ketika :other adalah :value.',
    'active_url' => 'Kolom :attribute harus berupa URL yang valid.',
    'after' => 'Kolom :attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => 'Kolom :attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => 'Kolom :attribute hanya boleh mengandung huruf.',
    'alpha_dash' => 'Kolom :attribute hanya boleh mengandung huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num' => 'Kolom :attribute hanya boleh mengandung huruf dan angka.',
    'array' => 'Kolom :attribute harus berupa array.',
    'ascii' => 'Kolom :attribute hanya boleh mengandung karakter alfanumerik satu byte dan simbol.',
    'before' => 'Kolom :attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => 'Kolom :attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => 'Kolom :attribute harus memiliki antara :min dan :max item.',
        'file' => 'Kolom :attribute harus memiliki ukuran antara :min dan :max kilobyte.',
        'numeric' => 'Kolom :attribute harus berada antara :min dan :max.',
        'string' => 'Kolom :attribute harus terdiri dari antara :min dan :max karakter.',
    ],
    'boolean' => 'Kolom :attribute harus bernilai true atau false.',
    'can' => 'Kolom :attribute mengandung nilai yang tidak sah.',
    'confirmed' => 'Kolom :attribute konfirmasinya tidak cocok.',
    'contains' => 'Kolom :attribute tidak mengandung nilai yang diperlukan.',
    'current_password' => 'Kata sandi yang dimasukkan salah.',
    'date' => 'Kolom :attribute harus berupa tanggal yang valid.',
    'date_equals' => 'Kolom :attribute harus berupa tanggal yang sama dengan :date.',
    'date_format' => 'Kolom :attribute harus sesuai dengan format :format.',
    'decimal' => 'Kolom :attribute harus memiliki :decimal tempat desimal.',
    'declined' => 'Kolom :attribute harus ditolak.',
    'declined_if' => 'Kolom :attribute harus ditolak ketika :other adalah :value.',
    'different' => 'Kolom :attribute dan :other harus berbeda.',
    'digits' => 'Kolom :attribute harus terdiri dari :digits digit.',
    'digits_between' => 'Kolom :attribute harus terdiri dari antara :min dan :max digit.',
    'dimensions' => 'Kolom :attribute memiliki dimensi gambar yang tidak sah.',
    'distinct' => 'Kolom :attribute memiliki nilai yang duplikat.',
    'doesnt_end_with' => 'Kolom :attribute tidak boleh diakhiri dengan salah satu dari: :values.',
    'doesnt_start_with' => 'Kolom :attribute tidak boleh diawali dengan salah satu dari: :values.',
    'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
    'ends_with' => 'Kolom :attribute harus diakhiri dengan salah satu dari: :values.',
    'enum' => 'Pilihan :attribute tidak sah.',
    'exists' => 'Pilihan :attribute tidak sah.',
    'extensions' => 'Kolom :attribute harus memiliki salah satu ekstensi berikut: :values.',
    'file' => 'Kolom :attribute harus berupa file.',
    'filled' => 'Kolom :attribute harus memiliki nilai.',
    'gt' => [
        'array' => 'Kolom :attribute harus memiliki lebih dari :value item.',
        'file' => 'Kolom :attribute harus lebih besar dari :value kilobyte.',
        'numeric' => 'Kolom :attribute harus lebih besar dari :value.',
        'string' => 'Kolom :attribute harus lebih panjang dari :value karakter.',
    ],
    'gte' => [
        'array' => 'Kolom :attribute harus memiliki :value item atau lebih.',
        'file' => 'Kolom :attribute harus lebih besar dari atau sama dengan :value kilobyte.',
        'numeric' => 'Kolom :attribute harus lebih besar dari atau sama dengan :value.',
        'string' => 'Kolom :attribute harus lebih panjang dari atau sama dengan :value karakter.',
    ],
    'hex_color' => 'Kolom :attribute harus berupa warna hex yang valid.',
    'image' => 'Kolom :attribute harus berupa gambar.',
    'in' => 'Pilihan :attribute tidak sah.',
    'in_array' => 'Kolom :attribute harus ada dalam :other.',
    'integer' => 'Kolom :attribute harus berupa angka bulat.',
    'ip' => 'Kolom :attribute harus berupa alamat IP yang valid.',
    'ipv4' => 'Kolom :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => 'Kolom :attribute harus berupa alamat IPv6 yang valid.',
    'json' => 'Kolom :attribute harus berupa string JSON yang valid.',
    'list' => 'Kolom :attribute harus berupa daftar.',
    'lowercase' => 'Kolom :attribute harus menggunakan huruf kecil.',
    'lt' => [
        'array' => 'Kolom :attribute harus memiliki kurang dari :value item.',
        'file' => 'Kolom :attribute harus kurang dari :value kilobyte.',
        'numeric' => 'Kolom :attribute harus kurang dari :value.',
        'string' => 'Kolom :attribute harus kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => 'Kolom :attribute tidak boleh memiliki lebih dari :value item.',
        'file' => 'Kolom :attribute tidak boleh lebih besar dari :value kilobyte.',
        'numeric' => 'Kolom :attribute tidak boleh lebih besar dari :value.',
        'string' => 'Kolom :attribute tidak boleh lebih panjang dari :value karakter.',
    ],
    'mac_address' => 'Kolom :attribute harus berupa alamat MAC yang valid.',
    'max' => [
        'array' => 'Kolom :attribute tidak boleh lebih dari :max item.',
        'file' => 'Kolom :attribute tidak boleh lebih dari :max kilobyte.',
        'numeric' => 'Kolom :attribute tidak boleh lebih dari :max.',
        'string' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
    ],
    'max_digits' => 'Kolom :attribute tidak boleh memiliki lebih dari :max digit.',
    'mimes' => 'Kolom :attribute harus berupa file dengan tipe: :values.',
    'mimetypes' => 'Kolom :attribute harus berupa file dengan tipe: :values.',
    'min' => [
        'array' => 'Kolom :attribute harus memiliki minimal :min item.',
        'file' => 'Kolom :attribute harus memiliki ukuran minimal :min kilobyte.',
        'numeric' => 'Kolom :attribute harus minimal :min.',
        'string' => 'Kolom :attribute harus minimal :min karakter.',
    ],
    'min_digits' => 'Kolom :attribute harus memiliki minimal :min digit.',
    'missing' => 'Kolom :attribute harus hilang.',
    'missing_if' => 'Kolom :attribute harus hilang ketika :other adalah :value.',
    'missing_unless' => 'Kolom :attribute harus hilang kecuali :other adalah :value.',
    'missing_with' => 'Kolom :attribute harus hilang ketika :values ada.',
    'missing_with_all' => 'Kolom :attribute harus hilang ketika :values ada.',
    'multiple_of' => 'Kolom :attribute harus merupakan kelipatan dari :value.',
    'not_in' => 'Pilihan :attribute tidak sah.',
    'not_regex' => 'Format kolom :attribute tidak sah.',
    'numeric' => 'Kolom :attribute harus berupa angka.',
    'password' => [
        'letters' => 'Kolom :attribute harus mengandung setidaknya satu huruf.',
        'mixed' => 'Kolom :attribute harus mengandung setidaknya satu huruf besar dan satu huruf kecil.',
        'numbers' => 'Kolom :attribute harus mengandung setidaknya satu angka.',
        'symbols' => 'Kolom :attribute harus mengandung setidaknya satu simbol.',
        'uncompromised' => 'Kolom :attribute telah muncul dalam kebocoran data. Silakan pilih :attribute lain.',
    ],
    'present' => 'Kolom :attribute harus ada.',
    'present_if' => 'Kolom :attribute harus ada ketika :other adalah :value.',
    'present_unless' => 'Kolom :attribute harus ada kecuali :other adalah :value.',
    'present_with' => 'Kolom :attribute harus ada ketika :values ada.',
    'present_with_all' => 'Kolom :attribute harus ada ketika :values ada.',
    'prohibited' => 'Kolom :attribute tidak boleh ada.',
    'prohibited_if' => 'Kolom :attribute tidak boleh ada ketika :other adalah :value.',
    'prohibited_unless' => 'Kolom :attribute tidak boleh ada kecuali :other ada di :values.',
    'prohibits' => 'Kolom :attribute melarang :other untuk hadir.',
    'regex' => 'Format kolom :attribute tidak sah.',
    'required' => 'Kolom :attribute harus diisi.',
    'required_array_keys' => 'Kolom :attribute harus berisi entri untuk: :values.',
    'required_if' => 'Kolom :attribute harus diisi ketika :other adalah :value.',
    'required_if_accepted' => 'Kolom :attribute harus diisi ketika :other diterima.',
    'required_if_declined' => 'Kolom :attribute harus diisi ketika :other ditolak.',
    'required_unless' => 'Kolom :attribute harus diisi kecuali :other ada di :values.',
    'required_with' => 'Kolom :attribute harus diisi ketika :values ada.',
    'required_with_all' => 'Kolom :attribute harus diisi ketika semua :values ada.',
    'required_without' => 'Kolom :attribute harus diisi ketika :values tidak ada.',
    'required_without_all' => 'Kolom :attribute harus diisi ketika tidak ada satu pun dari :values.',
    'same' => 'Kolom :attribute harus cocok dengan :other.',
    'size' => [
        'array' => 'Kolom :attribute harus berisi :size item.',
        'file' => 'Kolom :attribute harus berukuran :size kilobyte.',
        'numeric' => 'Kolom :attribute harus bernilai :size.',
        'string' => 'Kolom :attribute harus terdiri dari :size karakter.',
    ],
    'starts_with' => 'Kolom :attribute harus diawali dengan salah satu dari: :values.',
    'string' => 'Kolom :attribute harus berupa string.',
    'timezone' => 'Kolom :attribute harus berupa zona waktu yang valid.',
    'unique' => 'Kolom :attribute sudah terdaftar.',
    'uploaded' => 'Kolom :attribute gagal diupload.',
    'uppercase' => 'Kolom :attribute harus menggunakan huruf kapital.',
    'url' => 'Kolom :attribute harus berupa URL yang valid.',
    'ulid' => 'Kolom :attribute harus berupa ULID yang valid.',
    'uuid' => 'Kolom :attribute harus berupa UUID yang valid.',

    /*
    |----------------------------------------------------------------------
    | Custom Validation Language Lines
    |----------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi kustom untuk atribut menggunakan
    | konvensi "attribute.rule" untuk memberi nama pesan.
    |
    */

    'custom' => [
        'nis' => [
            'unique' => 'Kolom :attribute sudah terdaftar.',
        ],
        'nama' => [
            'required' => 'Kolom :nama harus di isi',
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Custom Validation Attributes
    |----------------------------------------------------------------------
    |
    | Di sini Anda dapat mengganti placeholder atribut dengan sesuatu yang lebih
    | mudah dibaca, seperti "Alamat E-Mail" alih-alih "email".
    |
    */

    'attributes' => [],
];
