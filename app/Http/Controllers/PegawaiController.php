<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;

class PegawaiController extends Controller
{
    public function index()
    {

        $data['name'] = "Isan";

        $tanggal_lahir = new DateTime("2005-05-12");
        $hari_ini = new DateTime();
        $data['my_age'] = $hari_ini->diff($tanggal_lahir)->y;

        $data['hobbies'] = [
            "Badminton",
            "Membaca",
            "Gaming",
            "Sepak bola",
            "Traveling"
        ];

        $data['tgl_harus_wisuda'] = "2026-07-01";


        $tgl_wisuda = new DateTime($data['tgl_harus_wisuda']);
        $selisih = $hari_ini->diff($tgl_wisuda);
        $data['time_to_study_left'] = $selisih->days;


        $data['current_semester'] = 2;


        $data['message'] = $data['current_semester'] < 3
            ? "Masih Awal, Kejar TAK"
            : "Jangan main-main, kurang-kurangi main game!";

        $data['future_goal'] = "Menjadi orang yang bermanfaat bagi orang lain";
        return view('pegawai-view', $data);
    }
}
