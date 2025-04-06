<?php

namespace App\Controllers;

class C_WhatsApp extends BaseController
{
    public function index()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return
            getHostByName(getHostName());
    }
    public function sendData($nomor, $username, $pass)
    {
        $curl = curl_init();

        $timeText = 'Selamat Pagi';
        // $link = base_url('/Masuk');
        $link = 'http://' . getHostByName(getHostName()) . '/KonveksiR3New/public/Masuk';

        if (date('H') > 23 && date('H') < 12) {
            $timeText = 'Selamat Pagi';
        } else  if (date('H') > 11 && date('H') < 15) {
            $timeText = 'Selamat Siang';
        } else  if (date('H') > 14 && date('H') < 18) {
            $timeText = 'Selamat Sore';
        } else  if (date('H') > 17) {
            $timeText = 'Selamat Malam';
        }
        $pesan = "$timeText Rekan Kerja,

Berikut kami sampai akses akun karyawan aplikasi Konveksi R-3
Username: $username
Kata Sandi : $pass
Link Akses : $link

Jika ada hal yang kurang mengerti terkait aplikasi bisa menghubungi nomor admin ini 

Demikian atas informasi yang saya sampaikan

Terima kasih,
Admin Konveksi R3        
        ";

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.whacenter.com/api/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('device_id' => '92bd11dc23b470d1fc5b9021679d8f18', 'number' => $nomor, 'message' => $pesan),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $curl;
    }
}
