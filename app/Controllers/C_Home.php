<?php

namespace App\Controllers;

use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Cookie\CookieStore;
use Config\App;
use DateTime;
use DateTimeZone;

class C_Home extends BaseController
{
    protected $Config;
    protected $Cokkie;
    protected $C_Activity;
    public function __construct()
    {

        $this->Config = new App();
        $this->Cokkie = new Cookie('AppSession');
        $this->C_Activity = new C_Activity();
    }
    public function index()
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));
            if (session()->get('Role') == 2 && session()->get('Position') == 2) {
                return  redirect()->to(base_url('/Transaksi'));
            }
            $setData = [
                'NamaPage' => 'Beranda',
                'IconPage' => 'Beranda'
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            if (session()->get('Role') == 2 && session()->get('Position') == 3) {
                return view('Dashboard/V_Dashboard_Kasir_Manager');
            } else if (session()->get('Role') == 1) {
                return view('Dashboard/V_Dashboard_Owner');
            } else if (session()->get('Role') == 3) {
                return view('Dashboard/V_Dashboard_Admin_Staf');
            }
        } else {
            return  redirect()->to(base_url('/'));
        }
    }

    public function error()
    {
        if (session()->get('status') == TRUE) {
            $setData = [
                'NamaPage' => 'Error Halaman',
                'IconPage' => 'Error'
            ];
            // $this->C_Activity->LastActiveUser();
            session()->set($setData);
            return view('errors/V_Error');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }

    public function testData()
    {
        // echo json_encode(session()->session_id());
        // session_cache_expire(1);
        // session_start();
        // echo json_encode(session_cache_expire());
        // echo json_encode(session_cache_limiter());
        // echo json_encode($_SERVER['HTTP_USER_AGENT']);
        // return view('testView');
        // $agent = $this->request->getUserAgent();

        // if ($agent->isBrowser()) {
        //     $currentAgent = $agent->getBrowser(); //. ' ' . $agent->getVersion();
        // } elseif ($agent->isRobot()) {
        //     $currentAgent = $agent->getRobot();
        // } elseif ($agent->isMobile()) {
        //     $currentAgent = $agent->getMobile();
        // } else {
        //     $currentAgent = 'Unidentified User Agent';
        // }

        // // echo $currentAgent;

        // waktu lahir
        $tanggal_1 = date_create('2024-08-10 23:00');
        // waktu sekarnag
        $tanggal_2 = date_create();
        // date_diff adalah fungsi php dalam menghitung har
        $selisih  = date_diff($tanggal_1, $tanggal_2);
        if ($selisih->h <= 0 && $selisih->i <= 30 && $selisih->s < 60) {
            // echo 1;
        } else {
            // echo 0;
        }
        // echo json_encode($selisih);
        $start = new DateTime('2024-08-10 10:00:00');
        $end = new DateTime('2024-08-10 09:30:00');

        echo $_SERVER['HTTP_USER_AGENT'];

        // Using get_browser() with return_array set to TRUE 
        $mybrowser = get_browser(null, true);
        print_r(new Browser);
        // // $this->Config->sessionExpiration
        // helper('cookie');
        // $cookie_name = "User";
        // $cookie_value = "John Doe";
        // setcookie($cookie_name, $cookie_value, new DateTime('2025-02-14 00:00:00', new DateTimeZone('UTC')), "/"); // 86400 = 1 day
        // // set_cookie('admin_token', 'yes');
        // $tiemes = time() + (1800 * 1);
        // echo json_encode(session());

        // $cookie = new Cookie(
        //     'remember_token',
        //     'f699c7fd18a8e082d0228932f3acd40e1ef5ef92efcedda32842a211d62f0aa6',
        //     [
        //         'expires'  => new DateTime('2025-02-14 00:00:00', new DateTimeZone('UTC')),
        //         'prefix'   => '__Secure-',
        //         'path'     => '/',
        //         'domain'   => '',
        //         'secure'   => true,
        //         'httponly' => true,
        //         'raw'      => false,
        //         'samesite' => Cookie::SAMESITE_LAX,
        //     ]
        // );
        // // $cookie->put($cookie);
        // new CookieStore([$cookie]);
        // setcookie($cookie);
        // $cookie = new Cookie('AppSession');
        // echo $cookie->getMaxAge();
        // echo htmlspecialchars($_COOKIE["name"]);

        // echo $result;
    }
}
