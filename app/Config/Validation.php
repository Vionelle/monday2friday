<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $admin = [
        'username' => [
            'rules' => 'required|min_length[5]',
        ],
        'password' => [
            'rules' => 'required|min_length[6]'
        ]
    ];
    public $admin_errors = [
        'username' => [
            'required' => 'Username Harus Diisi',
            'min_length' => 'Username Minimal 5 Karakter'
        ],
        'password' => [
            'required' => 'Password Harus Diisi',
            'min_length' => 'Password Minimal 6 Karakter'
        ]
    ];

    public $register = [
        'username' => [
            'rules' => 'required|min_length[5]',
        ],
        'email' => [
            'rules' => 'required',
        ],
        'password' => [
            'rules' => 'required|min_length[6]'
        ],
        'repeatPassword' => [
            'rules' => 'required|matches[password]'
        ]
    ];

    public $register_errors = [
        'username' => [
            'required' => 'Username Harus Diisi',
            'min_length' => 'Username Minimal 5 Karakter'
        ],
        'email' => [
            'required' => 'Email Harus Diisi',
        ],
        'password' => [
            'required' => 'Password Harus Diisi',
            'min_length' => 'Password Minimal 6 Karakter'    
        ],
        'repeatPassword' => [
            'required' => 'Mohon Konfirmasi Password Anda',
            'matches' => 'Konfirmasi Password Tidak sesuai dengan Password yang Anda masukkan'
        ]
    ];

    public $login = [
        'username' => [
            'rules' => 'required|min_length[5]',
        ],
        'password' => [
            'rules' => 'required|min_length[6]'
        ]
    ];

    public $login_errors = [
        'username' => [
            'required' => 'Username Harus Diisi',
            'min_length' => 'Username Minimal 5 Karakter',
        ],
        'password' => [
            'required' => 'Password Harus Diisi',
            'min_length' => 'Password Minimal 6 Karakter'
        ]
    ];

    public $barang = [
        'nama' => [
            'rules' => 'required|min_length[5]',
        ],
        'harga' => [
            'rules' => 'required',
        ],
        'stok' => [
            'rules' => 'required|is_natural',
        ],
        'size' => [
            'rules' => 'required',
        ],
        'gambar' => [
            'rules' => 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
        ]
    ];

    public $barang_errors = [
        'nama' => [
            'required' => 'Nama Harus Diisi',
            'min_length' => 'Nama Minimal 5 Karakter',
        ],
        'harga' => [
            'required' => 'Harga Harus Diisi',
        ],
        'stok' => [
            'required' => 'Stok Harus Diisi',
            'is_natural' => 'Stok Tidak Boleh Negatif',
        ],
        'size' => [
            'required' => 'Size Harus Diisi',
        ],
        'gambar' => [
            'uploaded' => 'Gambar Harus Diupload',
            'is_image' => 'File yang anda pilih bukan gambar',
            'mime_in' => 'File yang anda pilih bukan gambar'
        ]
    ];

    public $barangupdate = [
        'nama' => [
            'rules' => 'required|min_length[5]',
        ],
        'harga' => [
            'rules' => 'required',
        ],
        'stok' => [
            'rules' => 'required|is_natural',
        ]
    ];

    public $barangupdate_errors = [
        'nama' => [
            'required' => 'Nama Harus Diisi',
            'min_length' => 'Nama Minimal 5 Karakter',
        ],
        'harga' => [
            'required' => 'Harga Harus Diisi',
        ],
        'stok' => [
            'required' => 'Stok Harus Diisi',
            'is_natural' => 'Stok Tidak Boleh Negatif',
        ]
    ];

    public $transaksi = [
        'id_barang' => [
            'rules' => 'required',
        ],
        'id_pembeli' => [
            'rules' => 'required'
        ],
        'jumlah' => [
            'rules' => 'required'
        ],
        'total_harga' => [
            'rules' => 'required'
        ],
        'alamat' => [
            'rules' => 'required'
        ],
        'ongkir' => [
            'rules' => 'required'
        ]
    ];

    public $checkout = [
        'id_pembeli' => [
            'rules' => 'required'
        ],
        'total_harga' => [
            'rules' => 'required'
        ],
        'alamat' => [
            'rules' => 'required'
        ],
        'ongkir' => [
            'rules' => 'required'
        ]
    ];

    public $komentar = [
        'komentar' => [
            'rules' => 'required',
        ],
    ];

    public $resetpasswordadmin = [
        'password' => [
            'rules' => 'required|min_length[6]'
        ],
        'repeatPassword' => [
            'rules' => 'required|matches[password]'
        ]
    ];

    public $resetpasswordadmin_errors = [
        'password' => [
            'required' => 'Password Harus Diisi',
            'min_length' => 'Password Minimal 6 Karakter'    
        ],
        'repeatPassword' => [
            'required' => 'Mohon Konfirmasi Password Anda',
            'matches' => 'Konfirmasi Password Tidak sesuai dengan Password yang Anda masukkan'
        ]
    ];
}
