<?php

namespace Database\Seeders;

use App\Models\Instruktur;
use App\Models\Kelas;
use App\Models\Member;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Promo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'almindosaviorrammang@gmail.com',
            'nama' => 'Almindo Savior Tiranda Rammang',
            'username' => 'savior',
            'role' => 'Kasir',
            'email_verified_at' => now(),
            'password' => bcrypt('12345'),
            ],
        );
        User::create([
            'email' => 'savior@gmail.com',
            'nama' => 'Almindo Savior',
            'username' => 'vior',
            'role' => 'MO',
            'email_verified_at' => now(),
            'password' => bcrypt('12345'),
            ],
        );
        User::create([
            'email' => 'almindo@gmail.com',
            'nama' => 'Savior Rammang',
            'username' => 'Tiranda',
            'role' => 'Admin',
            'email_verified_at' => now(),
            'password' => bcrypt('12345'),
            ],
        );
        User::create([
            'email' => 'kimjennie@gmail.com',
            'nama' => 'Kim Jennie',
            'username' => 'jennie',
            'role' => 'Member',
            'email_verified_at' => now(),
            'password' => bcrypt('12345'),
            ],
        );
        User::create([
            'email' => 'lisamanoban@gmail.com',
            'nama' => 'Lisa Manoban',
            'username' => 'lisa',
            'role' => 'Instruktur',
            'email_verified_at' => now(),
            'password' => bcrypt('12345'),
            ],
        );
        

        Pegawai::create([
            'id_pegawai' => 'P01',
            'id_user' => '1',
            'nama_pegawai' => 'Almindo Savior Tiranda Rammang',
            'no_telp_pegawai' => '08128218291',
            'alamat_pegawai' => 'Yadara',
        ]);
        Pegawai::create([
            'id_pegawai' => 'P02',
            'id_user' => '2',
            'nama_pegawai' => 'Almindo Savior',
            'no_telp_pegawai' => '08128218331',
            'alamat_pegawai' => 'Yadara',
        ]);
        Pegawai::create([
            'id_pegawai' => 'P03',
            'id_user' => '3',
            'nama_pegawai' => 'Savior Rammang',
            'no_telp_pegawai' => '08128218331',
            'alamat_pegawai' => 'Yadara',
        ]);

        Promo::create([
            'id' => '1',
            'jenis_promo' => 'Promo Reguler',
            'nama_promo' => 'Promo Reguler Biasa',
            // 'mulai_promo' => '2023-01-01',
            'selesai_promo' => '2023-02-02',
            'minimal_deposit' => '3000000',
            'bonus_promo' => '300000'
        ]);
        Promo::create([
            'id' => '2',
            'jenis_promo' => 'Promo Reguler',
            'nama_promo' => 'Promo Reguler Luar Biasa',
            // 'mulai_promo' => '2023-01-01',
            'selesai_promo' => '2023-05-26',
            'minimal_deposit' => '3000000',
            'bonus_promo' => '300000'
        ]);
        Promo::create([
            'id' => '3',
            'jenis_promo' => 'Promo Kelas',
            'nama_promo' => 'Promo Kelas Biasa',
            'selesai_promo' => '2023-06-03',
            'minimal_deposit' => '5',
            'bonus_promo' => '1'
        ]);
        Promo::create([
            'id' => '4',
            'jenis_promo' => 'Promo Kelas',
            'nama_promo' => 'Promo Kelas Luar Biasa',
            'selesai_promo' => '2023-07-03',
            'minimal_deposit' => '5',
            'bonus_promo' => '1'
        ]);

        Member::create([
            'id_member'=> '23.05.001',
            'id_user' => '1',
            'nama_member' => 'Almindo Savior',
            'username_member'=> 'Savior',
            'tanggal_lahir_member'=> '2002-26-12',
            'no_telp_member' => '082238897016',
            'email_member'=> 'al@gmail.com',
            'password_member' => '12345',
            'alamat_member' => 'Jl.Babarsari',
            'tanggal_aktivasi_member' => '2023-01-01',
            'saldo_deposit_member'=> '3000000',

        ]);
        Member::create([
            'id_member'=> '23.05.002',
            'id_user' => '2',
            'nama_member' => 'Savior Tiranda',
            'username_member'=> 'Tiranda',
            'tanggal_lahir_member'=> '2002-19-12',
            'no_telp_member' => '0822389017',
            'email_member'=> 'tir@gmail.com',
            'password_member' => '12345',
            'alamat_member' => 'Jl.Seturan',
            'tanggal_aktivasi_member' => '2023-02-02',
            'saldo_deposit_member'=> '3500000',

        ]);
        Member::create([
            'id_member'=> '23.05.003',
            'id_user' => '3',
            'nama_member' => 'Tiranda Rammang',
            'username_member'=> 'Rammang',
            'tanggal_lahir_member'=> '2002-10-13',
            'no_telp_member' => '082238898019',
            'email_member'=> 'ra@gmail.com',
            'password_member' => '12345',
            'alamat_member' => 'Jl.Raya Solo',
            'tanggal_aktivasi_member' => '2023-04-02',
            'saldo_deposit_member'=> '3900000',

        ]);
        Kelas::create([
            'id' => '1',
            'nama_kelas' => 'Muaythai',
            'harga_kelas' => '150000',
        ]);
        Kelas::create([
            'id' => '2',
            'nama_kelas' => 'Dance Wings',
            'harga_kelas' => '200000',
        ]);
        Kelas::create([
            'id' => '3',
            'nama_kelas' => 'Bally Dance',
            'harga_kelas' => '250000',
        ]);Kelas::create([
            'id' => '4',
            'nama_kelas' => 'Zumba',
            'harga_kelas' => '200000',
        ]);
        Kelas::create([
            'id' => '5',
            'nama_kelas' => 'Yoga',
            'harga_kelas' => '250000',
        ]);
        Kelas::create([
            'id' => '6',
            'nama_kelas' => 'Spine',
            'harga_kelas' => '300000',
        ]);
        Instruktur::create([
            'id'=>'1',
            'id_user'=>'1',
            'nama_instruktur'=>'Alfonsus Setiawan',
            'username_instruktur'=> 'Alfons',
            'email_instruktur' => 'alfons@gmail.com',
            'password_instruktur'=>'12345',
            'no_telp_instruktur' =>'20132910182',
            'alamat_instruktur'=> 'Jl.Yadara'
        ]);
        Instruktur::create([
            'id'=>'2',
            'id_user'=>'2',
            'nama_instruktur'=>'Almindo Rammang',
            'username_instruktur'=> 'Almindo',
            'email_instruktur' => 'almindo@gmail.com',
            'password_instruktur'=>'12345',
            'no_telp_instruktur' =>'1929282192',
            'alamat_instruktur'=> 'Jl.Babarsari',
        ]);
        Instruktur::create([
            'id'=>'3',
            'id_user'=>'3',
            'nama_instruktur'=>'Almindo Savior',
            'username_instruktur'=> 'Savior',
            'email_instruktur' => 'al@gmail.com',
            'password_instruktur'=>'12345',
            'no_telp_instruktur' =>'082101929310',
            'alamat_instruktur'=> 'Jl.Sorong',
        ]);
        
        // Promo::create([
        //     'id' => '1',
        //     'jenis_promo' => 'Promo Reguler',
        //     // 'mulai_promo' => '2023-01-01',
        //     'selesai_promo' => '2023-02-02',
        //     'minimal_deposit' => '3000000',
        //     'bonus_promo' => '300000'
        // ]);
        
    }
}
