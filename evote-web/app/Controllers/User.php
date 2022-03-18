<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\IPBlockedModel;
use App\Models\PanitiaModel;
use App\Models\RekapModel;
use App\Models\TokenModel;
use CodeIgniter\Controller;
use App\Models\UserModel;
use DateTime;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer as PHPMailerPHPMailer;
use Config\Services;
use function GuzzleHttp\json_decode;

class User extends Controller
{
    // Ganti tema sesuai yang diiingin (default: '')
    private $theme = 'v2';

    public function index()
    {
        $data['youtube'] =  getenv("ID_YOUTUBE");
        echo view($this->theme . '/user/Sign', $data);
    }

    public function daftar()
    {
        $session = session();
        helper(['form']);
        $rules = [
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Nama tidak boleh dikosongi."
                ]
            ],
            'npm' => [
                'rules' => 'required|max_length[11]|numeric|is_unique[user.npm]',
                'errors' => [
                    'is_unique' => "NPM anda sudah terdaftar.",
                    'required' => "NPM tidak boleh dikosongi."
                ]
            ]
        ];
        if ($this->validate($rules)) {
            $fasilkom = true;
            if ($fasilkom) {
                //Backup semua data
                $ch = curl_init('https://api-mahasiswapemira.herokuapp.com/mahasiswa/' . $this->request->getVar('npm'));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $response = curl_exec($ch);
                $response = json_decode($response);
                $mhs_upn = "";
                #$url="";
                foreach ($response->mahasiswa as $key => $value) {
                    $mhs = explode(',', $value->text);
                    #$url = $value->website_link;
                    $check_upn = strpos($mhs[1], 'PT : UNIVERSITAS PEMBANGUNAN NASIONAL VETERAN JAWA TIMUR');
                    // $check_if = strpos($mhs[2], 'Prodi: INFORMATIKA');
                    // $check_if2 = strpos($mhs[2], 'Prodi: TEKNIK INFORMATIKA');
                    if ($check_upn !== false) {
                        $mhs_upn =  preg_replace('/\s+/', ' ', $value->text);
                    }
                }
                if ($mhs_upn == "") {
                    $session->setFlashdata('msg', "Pastikan NPM anda terdaftar sebagai mahasiswa UPN 'Veteran' Jawa Timur di prodi Informatika, silahkan cek di dikti. Masukkan NPM pada kolom pencarian di <a target='_blank' href='https://pddikti.kemdikbud.go.id/data_mahasiswa'>kemdikbud</a>");
                    return redirect()->to(base_url('user'));
                }
                //$single_quote = ["'",'"','`',"-",". ","."];
                $name_check = trim($this->request->getVar('nama')); #str_replace($single_quote,"",$this->request->getVar('nama'));
                $response = explode(',', $mhs_upn);
                if (strtolower($response[0]) != strtolower($name_check) . "(" . $this->request->getVar('npm') . ")") {
                    $session->setFlashdata('msg', "Pastikan NAMA dan NPM anda sesuai dengan data di dikti. Cek <a target='_blank' href='" . base_url("mahasiswa/" . $this->request->getVar('npm')) . "'>disini</a>");
                    return redirect()->to(base_url('user'));
                }
            } else {
                $ch = curl_init('https://api-frontend.kemdikbud.go.id/hit_mhs/' . $this->request->getVar('npm'));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $response = curl_exec($ch);
                $response = json_decode($response);
                $mhs_upn = "";
                #$url="";
                foreach ($response->mahasiswa as $key => $value) {
                    $mhs = explode(',', $value->text);
                    #$url = $value->website_link;
                    $check_upn = strpos($mhs[1], 'PT : UNIVERSITAS PEMBANGUNAN NASIONAL VETERAN JAWA TIMUR');
                    $check_if = strpos($mhs[2], 'Prodi: INFORMATIKA');
                    $check_if2 = strpos($mhs[2], 'Prodi: TEKNIK INFORMATIKA');
                    if ($check_upn !== false && ($check_if !== false || $check_if2 !== false)) {
                        $mhs_upn =  preg_replace('/\s+/', ' ', $value->text);
                    }
                }
                if ($mhs_upn == "") {
                    $session->setFlashdata('msg', "Pastikan NPM anda terdaftar sebagai mahasiswa UPN 'Veteran' Jawa Timur di prodi Informatika, silahkan cek di dikti. Masukkan NPM pada kolom pencarian di <a target='_blank' href='https://pddikti.kemdikbud.go.id/data_mahasiswa'>kemdikbud</a>");
                    return redirect()->to(base_url('user'));
                }
                //$single_quote = ["'",'"','`',"-",". ","."];
                $name_check = trim($this->request->getVar('nama')); #str_replace($single_quote,"",$this->request->getVar('nama'));
                $response = explode(',', $mhs_upn);
                if (strtolower($response[0]) != strtolower($name_check) . "(" . $this->request->getVar('npm') . ")") {
                    $session->setFlashdata('msg', "Pastikan NAMA dan NPM anda sesuai dengan data di dikti.Silahkan untuk mengecek pada link berikut dan gunakan nama tersebut saat pendaftaran <a target='_blank' href='https://api-frontend.kemdikbud.go.id/hit_mhs/" . $this->request->getVar('npm') . "'>disini</a>");
                    return redirect()->to(base_url('user'));
                }
            }

            helper("text");
            $onetime_pass = random_string("alnum", 8);
            $user = new UserModel();
            $email_to = $this->request->getVar('npm') . "@student.upnjatim.ac.id";
            $data = [
                'nama_user' => trim($this->request->getVar('nama')),
                'npm' => $this->request->getVar('npm'),
                'email_user' => $email_to,
                'password_user' => password_hash($onetime_pass, PASSWORD_DEFAULT),
                'type' => false
            ];
            $main_email = getenv("EMAIL_SENDER");
            $email = \Config\Services::email();
            $email->setTo($email_to);
            $email->setFrom($main_email, "Admin Evote IF");
            $email->setReplyTo($main_email, "Admin Evote IF");
            $email->setSubject('Temporary Password');
            $email_str = "<br><p>Untuk berbagai informasi seputar Pemira 2022, silakan kunjungi & follow instagram kami untuk Pemira IF di : <a href='https://instagram.com/pemiraif2022'>@pemiraif2022</a> dan Pemira Fasilkom di : <a href='https://instagram.com/kpumfasilkom'>@kpumfasilkom</a></p>";
            $email->setMessage("Ini adalah password sementara untuk akunmu : " . $onetime_pass . $email_str);
            if ($email->send()) {
                $user->save($data);
                $session->setFlashdata('msg', "Berhasil mengirim email, Cek password di email " . $email_to . "<br><a href='" . base_url('user/resend/') . "/" . $email_to . "' id='resend_email' class='btn btn-secondary disabled mt-1'>Kirim Ulang (01:00)</a>");
                return redirect()->to(base_url('user'));
            } else {
                $session->setFlashdata('msg', "Gagal Mengirim email. Silahkan coba lagi beberapa saat lagi.");
                // echo $email->printDebugger();
                return redirect()->to(base_url('user'));
            }
        } else {
            $data['validation'] = $this->validator;
            $data['youtube'] =  getenv("ID_YOUTUBE");
            return view($this->theme . '/user/Sign', $data);
        }
    }

    public function changeForget($token)
    {
        $session = session();
        $tokenModel = new TokenModel();
        $data = $tokenModel->where('token', $token)->first();

        if ($this->request->getMethod() == "post") {

            helper(['form']);
            $rules = [
                'new_pass' => [
                    'rules' => 'required|min_length[8]|matches[confirm_new_pass]',
                    'errors' => [
                        'required' => "Password tidak boleh dikosongi.",
                        'min_length' => "Password minimal 8 karakter.",
                        'matches' => "Password tidak sama dengan konfirmasi password."
                    ]
                ],
                'confirm_new_pass' => [
                    'rules' => 'required',
                    'errors' => [

                        'required' => "Harap isi konfirmasi password"
                    ]
                ],
                'token_data' => [
                    'rules' => 'required',
                    'errors' => [

                        'required' => "Token tidak ditemukan"
                    ]
                ]
            ];

            if ($this->validate($rules)) {

                $data = $tokenModel->where('token', $token)->first();
                if ($data) {
                    $user = new UserModel();
                    // $user_data = $user->where('email_user', $data['email'])->first();
                    // Ubah passowrd
                    $user->set(['password_user' => password_hash($this->request->getVar('new_pass'), PASSWORD_DEFAULT)])->where('email_user', $data['email'])->update();
                    // Hapus token
                    $tokenModel->where('token', $token)->delete();
                    $session->setFlashdata('msg', "Berhasil mengubah password, silahkan login dengan password baru anda.");
                    return redirect()->to(base_url('user'));
                } else {
                    $session->setFlashdata('msg', "Token tidak ditemukan");
                    return redirect()->to(base_url('user'));
                }
            } else {
                if ($token) {
                    $data['token'] = $token;
                    $data['validation'] = $this->validator;
                    return view($this->theme . '/user/ForgotPass', $data);
                } else {
                    $session->setFlashdata('msg', "Token tidak ditemukan");
                    return redirect()->to(base_url('user'));
                }
            }
        }
        if ($data) {
            if ($data['status'] == 0) {
                return view($this->theme . '/user/ForgotPass', $data);
            }
            $session->setFlashdata('msg', "Token expired harap minta lagi");
        }

        return redirect()->to(base_url('user'));
    }

    public function formForget()
    {
        $session = session();
        $tokenModel = new TokenModel();
        helper(['form']);
        $rules = [
            'new_pass' => [
                'rules' => 'required|min_length[8]|matches[confirm_new_pass]',
                'errors' => [
                    'required' => "Password tidak boleh dikosongi.",
                    'min_length' => "Password minimal 8 karakter.",
                    'matches' => "Password tidak sama dengan konfirmasi password."
                ]
            ],
            'confirm_new_pass' => [
                'rules' => 'required',
                'errors' => [

                    'required' => "Harap isi konfirmasi password"
                ]
            ],
            'token' => [
                'rules' => 'required',
                'errors' => [

                    'required' => "Token tidak ditemukan"
                ]
            ]
        ];
        $token = $this->request->getVar("token");
        if ($this->validate($rules)) {

            $data = $tokenModel->where('token', $token)->first();
            if ($data) {
                $user = new UserModel();
                $user_data = $user->where('email_user', $data['email'])->first();
                // Ubah passowrd
                $user->update($user_data['npm'], ['password_user' => password_hash($this->request->getVar('new_pass'), PASSWORD_DEFAULT)]);
                // Hapus token
                $tokenModel->where('token', $token)->delete();
                $session->setFlashdata('msg', "Berhasil mengubah password, silahkan login dengan password baru anda.");
                return redirect()->to(base_url('user'));
            } else {
                $session->setFlashdata('msg', "Token tidak ditemukan");
                return redirect()->to(base_url('user'));
            }
        } else {
            if ($token) {
                $data['token'] = $token;
                $data['validation'] = $this->validator;
                return view($this->theme . '/user/ForgotPass', $data);
            } else {
                $session->setFlashdata('msg', "Token tidak ditemukan");
                return redirect()->to(base_url('user'));
            }
        }
    }

    //ganti post
    public function forgot($email_to)
    {

        $session = session();
        $ip_address = md5($this->request->getIPAddress());
        $throttler = Services::throttler();
        if ($throttler->check($ip_address, 5, 60) === false) {
            $session->setFlashdata('msg', "Anda terlalu banyak mencoba merubah password. Silahkan coba lagi nanti.");
            return redirect()->to(base_url("user"));
        }


        $user = new UserModel();
        $tokenModel = new TokenModel();
        if ($tokenModel->where('email', $email_to)->where('status', 0)->first()) {
            $session->setFlashdata('msg', "Penggantian password telah diajukan sebelumnya harap check email atau spam");
            return redirect()->to(base_url('user'));
        }
        $data_user = $user->where('email_user', $email_to)->first();
        if ($data_user) {
            helper("text");
            $token = date("YmdHis") . random_string("alnum", 8);
            $email = \Config\Services::email();
            $main_email = getenv("EMAIL_SENDER");
            $email->setTo($email_to);
            $email->setFrom($main_email, "Admin Evote IF");
            $email->setReplyTo($main_email, "Admin Evote IF");
            $email->setSubject('Lupa Password');
            $email->setMessage("Ini adalah link untuk merubah password untuk akunmu : <a href='" . base_url('user/password/' . $token) . "'>Ubah Password</a>");

            if ($email->send()) {
                $token_data = [
                    'email' => $email_to,
                    'token' => $token,

                ];
                $tokenModel->insert($token_data);
                $session->setFlashdata('msg', "Berhasil mengirim link merubah password email, Cek password di email " . $email_to . "");
                return redirect()->to(base_url('user'));
            } else {
                $session->setFlashdata('msg', "Gagal Mengirim email. Silahkan coba lagi nanti. ");
                return redirect()->to(base_url('user'));
            }
        } else {
            $session->setFlashdata('msg', "Akun tidak ditemukan");
            return redirect()->to(base_url('user'));
        }
    }

    public function resend($email_to)
    {
        $session = session();
        $ip_address = md5($this->request->getIPAddress());
        $throttler = Services::throttler();
        if ($throttler->check($ip_address, 5, 60) === false) {
            $session->setFlashdata('msg', "Anda terlalu banyak mencoba merubah password. Silahkan coba lagi nanti.");
            return redirect()->to(base_url("user"));
        }
        $user = new UserModel();
        $data_user = $user->where('email_user', $email_to)->first();
        if ($data_user) {
            if ($data_user['type']) {
                $session->setFlashdata('msg', "Akun anda sudah aktif, tidak dapat meminta password lagi.");
                return redirect()->to(base_url('user'));
            }
            helper("text");
            $onetime_pass = random_string("alnum", 8);
            $email = \Config\Services::email();
            $main_email = getenv("EMAIL_SENDER");
            $email->setTo($email_to);
            $email->setFrom($main_email, "Admin Evote IF");
            $email->setReplyTo($main_email, "Admin Evote IF");
            $email->setSubject('Temporary Password');
            $email->setMessage("Ini adalah password sementara untuk akunmu : " . $onetime_pass);
            $data = [
                'password_user' => password_hash($onetime_pass, PASSWORD_DEFAULT)
            ];
            if ($email->send()) {
                $user->where('email_user', $email_to)->set($data)->update();
                $session->setFlashdata('msg', "Berhasil mengirim email, Cek password di email " . $email_to . "
<a href='" . base_url('user/resend/') . "/" . $email_to . "' id='resend_email' class='btn btn-secondary disabled'>Kirim Ulang (01:00)</a>");
                return redirect()->to(base_url('user'));
            } else {
                $session->setFlashdata('msg', "Gagal Mengirim email. Silahkan coba lagi nanti. ");
                return redirect()->to(base_url('user'));
            }
        } else {
            $session->setFlashdata('msg', "Akun tidak ditemukan");
            return redirect()->to(base_url('user'));
        }
    }



    public function masuk()
    {
        $session = session();

        // cek throttler mencegah bruteforce
        $throttler = Services::throttler();
        $ipblocked =  new IPBlockedModel();
        $ip_address = md5($this->request->getIPAddress());
        $dataIPAddress = $ipblocked->where('ip_address', $ip_address)->first();

        if ($dataIPAddress) {

            if ($dataIPAddress['blocked_time'] >= date('Y-m-d H:i:s')) {
                if ($dataIPAddress['times'] == 1) {
                    $session->setFlashdata('msg', 'Anda terlalu banyak mencoba masuk, tunggu 1 menit lagi');
                } else {
                    $session->setFlashdata('msg', 'Anda terlalu banyak mencoba masuk, tunggu 5 menit lagi');
                }
                return redirect()->to(base_url("user"));
            }
        }
        if ($throttler->check($ip_address, 5, 60 * 5) === false) {

            if ($dataIPAddress) {
                $session->setFlashdata('msg', 'Anda terlalu banyak mencoba masuk, tunggu 5 menit lagi');
                $dataIPAddress['blocked_time'] = date('Y-m-d H:i:s', strtotime('+5 min'));
                $dataIPAddress['times'] = 2;
                $ipblocked->update($ip_address, $dataIPAddress);
            } else {
                $session->setFlashdata('msg', 'Anda terlalu banyak mencoba masuk, tunggu 1 menit lagi');
                $ipblocked->insert([
                    'ip_address' => $ip_address,
                    'blocked_time' => date('Y-m-d H:i:s', strtotime("+1 min")),
                    'times' => 1
                ]);
            }
            return redirect()->to(base_url("user"));
        }

        $user = new UserModel();
        $npm = $this->request->getVar('npm');
        $password = $this->request->getVar('password');
        $data = $user->where('npm', $npm)->first();
        if ($data) {
            $pass = $data['password_user'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $activate_user = [
                    'type' => true
                ];
                $user->where('npm', $npm)->set($activate_user)->update();
                $ses_data = [
                    'npm' => $data['npm'],
                    'nama_user' => $data['nama_user'],
                    'email_user' => $data['email_user'],
                    'is_user' => true,
                    'is_panitia' => false
                ];
                $panitia = new PanitiaModel();
                $data_panitia = $panitia->where("npm_panitia", $npm)->first();
                if ($data_panitia) {
                    $ses_data['is_panitia'] = true;
                    $ses_data['kode_panitia'] = $data_panitia['kode_panitia'];
                }
                $session->set($ses_data);
                $db = \Config\Database::connect();
                $builder = $db->table('event');
                $builder->select("*");
                $query = $builder->get();
                $events = $query->getResultArray();
                $rekap = new RekapModel();
                foreach ($events as $key => $event) {
                    $builder = $db->table('DP_' . $event['kode_event']);
                    $data_rekap = $rekap->where('npm_pemilih', $npm)->where('event', $event['kode_event'])->first();
                    $data_pemilih = $builder->where('npm', $npm)->get()->getResultArray();
                    if (count($data_pemilih) > 0 && !$data_rekap) {
                        if ($db->tableExists('TEMP_' . $event['kode_event'])) {
                            $builder = $db->table('TEMP_' . $event['kode_event']);
                            $builder->where('npm', $npm)->delete();
                        }
                    }
                }
                return redirect()->to(base_url('user/event'));
            } else {
                $session->setFlashdata('msg', "Password anda salah.");
                return redirect()->to(base_url('user'));
            }
        } else {
            $session->setFlashdata('msg', "NPM belum terdaftar.");
            return redirect()->to(base_url('user'));
        }
    }

    public function keluar()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url("user/"));
    }

    public function event()
    {
        $session = session();
        helper(['url']);
        $db = \Config\Database::connect();
        $builder = $db->table('event');
        $builder->select("*");
        $query = $builder->get();
        $events = $query->getResultArray();
        foreach ($events as $key => $event) {
            $builder = $db->table('DP_' . $event['kode_event']);
            $data_pemilih = $builder->where('npm', $_SESSION['npm'])->get()->getResultArray();
            if (count($data_pemilih) == 0) {
                unset($events[$key]);
                continue;
            }
            $date_s = new DateTime($event['waktu_mulai']);
            $date_e = new DateTime($event['waktu_selesai']);
            $date_n = new DateTime();
            if ($date_s > $date_n)
                $events[$key]["status"] = 2;
            else if ($date_e > $date_n && $date_s < $date_n) {
                $events[$key]["status"] = 1;
            } else if ($date_e < $date_n)
                $events[$key]["status"] = 3;
            $rekap = new RekapModel();
            $data_rekap = $rekap->where('npm_pemilih', $_SESSION['npm'])->where('event', $event['kode_event'])->first();
            if ($data_rekap) {
                $events[$key]["pilih"] = 1;
            } else {
                $events[$key]["pilih"] = 0;
            }
            $builder = $db->table('PEM_' . $event['kode_event']);
            $data_pem = $builder->get()->getResultArray();
            if (count($data_pem) > 0) {
                $events[$key]['first'] = $data_pem[0]['id'];
            } else {
                $events[$key]['first'] = NULL;
            }
        }
        usort($events, function ($a, $b) {
            return $a['status'] <=> $b['status'];
        });
        $data = [
            'event_data' => $events
        ];
        $data['youtube'] =  getenv("ID_YOUTUBE");
        echo view($this->theme . '/user/Event', $data);
    }

    public function pilih_v($kode)
    {
        $session = session();
        helper(['url']);
        $db = \Config\Database::connect();
        $builder = $db->table('event');
        $builder->select("*");
        $builder->where("kode_event", $kode);
        $query = $builder->get();
        $data_event = $query->getResultArray();
        $builder = $db->table('DP_' . $kode);
        $data_pemilih = $builder->where('npm', $_SESSION['npm'])->get()->getResultArray();
        $rekap = new RekapModel();
        $data_rekap = $rekap->where('npm_pemilih', $_SESSION['npm'])->where('event', $kode)->first();
        if (count($data_pemilih) == 0 || $data_rekap) {
            return redirect()->to(base_url('user/event'));
        }
        $builder = $db->table('TEMP_' . $kode);
        $data_temp = $builder->where('npm', $_SESSION['npm'])->get()->getResultArray();
        $builder = $db->table('PEM_' . $kode);
        $data_pem = $builder->get()->getResultArray();
        $data_diff_pem = array_diff(array_column($data_pem, 'id'), array_column($data_temp, 'pem'));
        sort($data_diff_pem, SORT_NUMERIC);
        if (count($data_diff_pem) == 0 && !$data_rekap) {
            echo view("v2/user/Pilih", ['rekap' => 1, 'event' => $kode]);
            return;
        }
        $pem = $data_diff_pem[0];
        $now = new DateTime();
        $ev_s = new DateTime($data_event[0]['waktu_mulai']);
        $ev_e = new DateTime($data_event[0]['waktu_selesai']);

        if ($now > $ev_s && $now < $ev_e) {
            $panitia = new PanitiaModel();
            $kode_panitia = $panitia->where('event', $kode)->findColumn('kode_panitia');
            $db = \Config\Database::connect();
            $builder = $db->table('calon');
            $builder->select("ketua.nama_user as nama_ketua,wakil.nama_user as nama_wakil,calon.*");
            $builder->join("user as ketua", "ketua.npm=calon.npm_ketua", "left");
            $builder->join("user as wakil", "wakil.npm=calon.npm_wakil", "left");
            $builder->whereIn('panitia', $kode_panitia)->where('calon.pem', $pem);
            $query = $builder->get();
            $calon = $query->getResultArray();
            $builder = $db->table('PEM_' . $kode);
            $data_pem = $builder->where('id', $pem)->get()->getResultArray();
            $data = [
                'data_calon' => $calon,
                'event' => $kode,
                'pem' => $pem,
                'judul_event' => $data_event[0]['nama_event'],
                'judul_pem' => $data_pem[0]['nama'],
                'rekap' => 0
            ];
            $rekap = new RekapModel();
            $data_rekap = $rekap->where('npm_pemilih', $_SESSION['npm'])->where('event', $kode)->first();
            if ($data_rekap)
                return redirect()->to(base_url('user/event'));
            else
                echo view("v2/user/Pilih", $data);
        } else {
            return redirect()->to(base_url('user/event'));
        }
    }

    public function pilih_u($kode, $pem)
    {
        $session = session();
        helper(['url']);
        $db = \Config\Database::connect();
        $builder = $db->table('event');
        $builder->select("*");
        $builder->where("kode_event", $kode);
        $query = $builder->get();
        $data_event = $query->getResultArray();
        $builder = $db->table('DP_' . $kode);
        $data_pemilih = $builder->where('npm', $_SESSION['npm'])->get()->getResultArray();
        if (count($data_pemilih) == 0) {
            return redirect()->to(base_url('user/event'));
        }
        $builder = $db->table('PEM_' . $kode);
        $data_pem = $builder->where('id', $pem)->get()->getResultArray();
        if ($pem == 0) {
            $session->setFlashdata('rekap', '1');
            echo view("v2/user/uPilih", [
                'rekap' => 1,
                'event' => $kode
            ]);
            return;
        }
        if (count($data_pem) == 0) {
            return redirect()->to(base_url('user/event'));
        }
        $now = new DateTime();
        $ev_s = new DateTime($data_event[0]['waktu_mulai']);
        $ev_e = new DateTime($data_event[0]['waktu_selesai']);

        if ($now > $ev_s && $now < $ev_e) {
            $panitia = new PanitiaModel();
            $kode_panitia = $panitia->where('event', $kode)->findColumn('kode_panitia');
            $db = \Config\Database::connect();
            $builder = $db->table('calon');
            $builder->select("ketua.nama_user as nama_ketua,wakil.nama_user as nama_wakil,calon.*");
            $builder->join("user as ketua", "ketua.npm=calon.npm_ketua", "left");
            $builder->join("user as wakil", "wakil.npm=calon.npm_wakil", "left");
            $builder->whereIn('panitia', $kode_panitia)->where('calon.pem', $pem);
            $query = $builder->get();
            $calon = $query->getResultArray();
            $data = [
                'data_calon' => $calon,
                'event' => $kode,
                'pem' => $pem,
                'judul_event' => $data_event[0]['nama_event'],
                'judul_pem' => $data_pem[0]['nama'],
                'rekap' => 0
            ];
            $rekap = new RekapModel();
            $data_rekap = $rekap->where('npm_pemilih', $_SESSION['npm'])->where('event', $kode)->first();
            if ($data_rekap)
                return redirect()->to(base_url('user/event'));
            else
                echo view("v2/user/uPilih", $data);
        } else {
            return redirect()->to(base_url('user/event'));
        }
    }

    public function pilih()
    {
        helper(['form', 'url']);
        $kode = $this->request->getVar("calon");
        $pem = $this->request->getVar("pem");
        $session = session();
        $db = \Config\Database::connect();
        $builder = $db->table('calon');
        $builder->select("*");
        $builder->join('panitia', "calon.panitia=panitia.kode_panitia");
        $builder->where("calon.kode_calon", $kode);
        $query = $builder->get();
        $data_calon = $query->getResultArray();
        $kotak_kosong = false;
        if (count($data_calon) == 0) {
            $data_calon[0]['event'] = $kode;
            $kotak_kosong = true;
        }
        $time = time();
        $builder = $db->table('DP_' . $data_calon[0]['event']);
        $data_pemilih = $builder->where('npm', $_SESSION['npm'])->get()->getResultArray();
        if (count($data_pemilih) == 0) {
            $msg = array(
                'msg' => "Anda tidak terdaftar di Daftar Pemilih!",
                'type' => "fatal"
            );
            echo json_encode($msg);
            return;
        }
        if ($pem != 0) {
            $data_temp = [
                'npm' => $_SESSION['npm'],
                'pem' => $pem,
                'pilihan' => $kode
            ];
            if ($kotak_kosong)
                $data_temp['pilihan'] = NULL;

            $builder = $db->table('TEMP_' . $data_calon[0]['event']);
            $data_temp_chk = $builder->where('npm', $_SESSION['npm'])->where('pem', $pem)->get()->getResultArray();
            if (count($data_temp_chk) > 0) {
                $builder = $db->table('PEM_' . $data_calon[0]['event']);
                $data_pem = $builder->where('id > ', $pem)->get()->getResultArray();
                if (count($data_pem) > 0) {
                    $msg = array(
                        'msg' => "Anda sudah memilih pada pilihan ini. Lanjut ke pemilihan berikutnya",
                        'type' => "success",
                        'url' => base_url('user/pilih_u/' . $data_calon[0]['event'] . "/" . $data_pem[0]['id'])
                    );
                } else {
                    $msg = array(
                        'msg' => "Anda sudah memilih pada pilihan ini. Lanjut ke bukti pengambilan suara.",
                        'type' => "success",
                        'url' => base_url('user/pilih_u/' . $data_calon[0]['event'] . "/0")
                    );
                    $session->setFlashdata('rekap', '1');
                }
                echo json_encode($msg);
                return;
            }

            $builder = $db->table('TEMP_' . $data_calon[0]['event']);
            if ($builder->insert($data_temp)) {
                $builder = $db->table('PEM_' . $data_calon[0]['event']);
                $data_pem = $builder->where('id > ', $pem)->get()->getResultArray();
                if (count($data_pem) > 0) {
                    $msg = array(
                        'msg' => "Berhasil menyimpan. Lanjut ke pemilihan berikutnya",
                        'type' => "success",
                        'url' => base_url('user/pilih_u/' . $data_calon[0]['event'] . "/" . $data_pem[0]['id'])
                    );
                } else {
                    $msg = array(
                        'msg' => "Berhasil menyimpan. Lanjut ke bukti pengambilan suara.",
                        'type' => "success",
                        'url' => base_url('user/pilih_u/' . $data_calon[0]['event'] . "/0")
                    );
                    $session->setFlashdata('rekap', '1');
                }
            } else {
                $msg = array(
                    'msg' => "Terjadi kesalahan, mohon coba beberapa saat lagi.",
                    'type' => "error"
                );
            }
            echo json_encode($msg);
        } else {
            $photo = $_FILES['image'];
            $data_foto = $photo['name'];
            $rekap = new RekapModel();
            $data_rekap = $rekap->where('npm_pemilih', $_SESSION['npm'])->where('event', $data_calon[0]['event'])->first();

            if ($data_rekap) {
                $msg = array(
                    'msg' => "Anda sudah memilih!",
                    'type' => "fatal"
                );
            } else {
                if (is_image($photo['tmp_name']) && is_image($_FILES['pilih_ktm']['tmp_name'])) {
                    $file_id_foto = gdupload($_FILES['image']['tmp_name'], $_SESSION['npm'] . "_" . $data_calon[0]['event'] . "_FOTO");
                    $file_id_ktm = gdupload($_FILES['pilih_ktm']['tmp_name'], $_SESSION['npm'] . "_" . $data_calon[0]['event'] . "_KTM");
                    if (($file_id_foto != FALSE) && ($file_id_ktm != FALSE)) {
                        $builder = $db->table("rekap");
                        $last_rekap = $builder->orderBy("kode_rekap", "DESC")->limit(1)->get()->getResultArray();
                        if (count($last_rekap) == 0) {
                            $new_kode_rekap = "REK0000001";
                        } else {
                            $new_kode_rekap = "REK" . sprintf("%07d", (((int)substr($last_rekap[0]['kode_rekap'], -7)) + 1));
                        }
                        $data = [
                            'kode_rekap' => $new_kode_rekap,
                            'npm_pemilih' => $_SESSION['npm'],
                            'event' => $data_calon[0]['event'],
                            'foto_ktm' => $file_id_ktm,
                            'foto_rekap' => $file_id_foto,
                            'tanggal_pilih' => date('Y-m-d H:i:s', $time)
                        ];
                        if ($rekap->save($data)) {
                            $msg = array(
                                'msg' => "Berhasil menyimpan bukti. Terima kasih telah menggunakan hak pilih anda.",
                                'type' => "success"
                            );
                        } else {
                            $msg = array(
                                'msg' => "Terjadi Kesalahan, Silahkan ulangi beberapa saat lagi",
                                'type' => "error"
                            );
                        }
                    }
                } else {
                    $msg = array(
                        'msg' => "Pastikan foto anda benar benar foto",
                        'type' => "fatal"
                    );
                }
            }
            echo json_encode($msg);
        }
    }

    public function changepass_v()
    {
        $session = session();
        echo view($this->theme . '/user/ChangePass');
    }

    public function changepass()
    {
        helper(['form']);
        $session = session();
        $old_pass = $this->request->getVar('old_pass');
        $new_pass = $this->request->getVar('new_pass');
        $new_pass2 = $this->request->getVar('confirm_new_pass');
        $npm = $_SESSION['npm'];
        $user = new UserModel();
        $data = $user->where('npm', $npm)->first();
        if (strlen($new_pass) < 8) {
            $msg = [
                'type' => 'error',
                'msg' => 'Minimal panjang password adalah 8 karakter.'
            ];
            echo json_encode($msg);
            return;
        } else if ($new_pass != $new_pass2) {
            $msg = [
                'type' => 'error',
                'msg' => 'Konfirmasi password tidak sama !!.'
            ];
            echo json_encode($msg);
            return;
        }
        if ($data) {
            $pass = $data['password_user'];
            $verify_pass = password_verify($old_pass, $pass);
            if ($verify_pass) {
                $new_pass = [
                    'password_user' => password_hash($new_pass, PASSWORD_DEFAULT)
                ];
                if ($user->where('npm', $npm)->set($new_pass)->update()) {
                    $msg = [
                        'type' => 'success',
                        'msg' => 'Berhasil merubah password.'
                    ];
                } else {
                    $msg = [
                        'type' => 'error',
                        'msg' => 'Gagal merubah password.'
                    ];
                }
            } else {
                $msg = [
                    'type' => 'error',
                    'msg' => 'Password anda salah.'
                ];
            }
        }
        echo json_encode($msg);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('user'));
    }

    public function detail_mahasiswa($npm)
    {
        $data['npm'] =  $npm;
        return view($this->theme . '/user/DetailMahasiswa', $data);
    }
}
