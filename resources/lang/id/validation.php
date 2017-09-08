<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute harus diterima.',
    'active_url'           => 'URL :attribute tidak valid.',
    'after'                => ':attribute harus berupa tanggal setelah :date.',
    'after_or_equal'       => ':attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha'                => ':attribute hanya dapat berupa huruf.',
    'alpha_dash'           => ':attribute hanya dapat berupa huruf, nomor dan dash.',
    'alpha_num'            => ':attribute hanya dapat berupa huruf dan nomor.',
    'array'                => ':attribute harus berupa array.',
    'before'               => ':attribute harus berupa tanggal sebelum :date.',
    'before_or_equal'      => ':attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'numeric' => ':attribute harus bernilai antara :min dan :max.',
        'file'    => ':attribute harus berukuran antara :min dan :max kilobyte.',
        'string'  => ':attribute harus memiliki panjang antara :min dan :max karakter.',
        'array'   => ':attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute harus berupa benar atau salah.',
    'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
    'date'                 => ':attribute bukan tanggal yang valid.',
    'date_format'          => ':attribute tidak sesuai dengan format :format.',
    'different'            => ':attribute dan :other harus berbeda.',
    'digits'               => ':attribute harus memiliki :digits digit.',
    'digits_between'       => ':attribute harus memiliki antara :min dan :max digit.',
    'dimensions'           => ':attribute memiliki ukuran yang tidak valid.',
    'distinct'             => ':attribute memiliki nilai yang duplikat.',
    'email'                => ':attribute harus berupa alamat email yang valid.',
    'exists'               => ':attribute yang dipilih tidak valid.',
    'file'                 => ':attribute harus berupa file.',
    'filled'               => ':attribute harus diisi.',
    'image'                => ':attribute harus berupa gambar.',
    'in'                   => ':attribute yang dipilih tidak valid.',
    'in_array'             => ':attribute tidak ada di :other.',
    'integer'              => ':attribute harus berupa angka.',
    'ip'                   => ':attribute harus berupa alamat IP yang valid.',
    'ipv4'                 => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6'                 => ':attribute harus berupa alamat IPv6 yang valid.',
    'json'                 => ':attribute harus berupa string JSON yang valid.',
    'max'                  => [
        'numeric' => ':attribute tidak boleh lebih besar dari :max.',
        'file'    => ':attribute tidak boleh lebih besar dari :max kilobyte.',
        'string'  => ':attribute tidak boleh lebih panjang dari :max karakter.',
        'array'   => ':attribute tidak boleh lebih dari :max.',
    ],
    'mimes'                => ':attribute harus berupa file berjenis: :values.',
    'mimetypes'            => ':attribute harus berupa file berjenis: :values.',
    'min'                  => [
        'numeric' => ':attribute tidak boleh lebih kecil dari :min.',
        'file'    => ':attribute tidak boleh lebih kecil dari :min kilobyte.',
        'string'  => ':attribute tidak boleh lebih pendek dari :min karakter.',
        'array'   => ':attribute tidak boleh kurang dari :min.',
    ],
    'not_in'               => ':attribute yang dipilih tidak valid.',
    'numeric'              => ':attribute harus berupa angka.',
    'present'              => ':attribute wajib diisi.',
    'regex'                => 'Format :attribute tidak valid.',
    'required'             => ':attribute wajib diisi.',
    'required_if'          => ':attribute wajib diisi jika :other sama dengan :value.',
    'required_unless'      => ':attribute wajib diisi kecuali jika :other adalah :values.',
    'required_with'        => ':attribute wajib diisi jika :values juga diisi.',
    'required_with_all'    => ':attribute wajib diisi jika :values juga diisi.',
    'required_without'     => ':attribute wajib diisi jika :values tidak diisi.',
    'required_without_all' => ':attribute wajib diisi jika diantara :values tidak ada yang diisi.',
    'same'                 => ':attribute dan :other harus sama.',
    'size'                 => [
        'numeric' => ':attribute harus bernilai :size.',
        'file'    => ':attribute harus berukuran :size kilobyte.',
        'string'  => ':attribute harus sepanjang :size karakter.',
        'array'   => ':attribute harus memiliki :size.',
    ],
    'string'               => ':attribute harus berupa string.',
    'timezone'             => ':attribute harus berupa zona waktu yang valid.',
    'unique'               => ':attribute sudah digunakan.',
    'uploaded'             => ':attribute gagal diupload.',
    'url'                  => 'Format :attribute tidak valid.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
