<?php

namespace App\Controllers;

use App\Models\RekapModel;
use CodeIgniter\Controller;
use App\Models\AdminModel;
use App\Models\PanitiaModel;
use App\Models\EventModel;
use App\Models\UserModel;
use App\Models\ConfigModel;
use App\Models\IPBlockedModel;
use CodeIgniter\Database\Database;
use DateTime;
use Config\Services;

#username : evote_admin
#password : Admin123!
class Admin extends Controller
{

    public function index()
    {
        return redirect()->to(base_url("admin/masuk_v"));
    }

    public function generate_capcta()
    {
        $possible = "123456789";
        $operator = "x+";
        $a = substr($possible, mt_rand(0, 7), 1);
        $b = substr($possible, mt_rand(0, 7), 1);
        $angka = [
            "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan"
        ];
        $operator = substr($operator, mt_rand(0, 1), 1);
        $result = 0;
        $text_opr = "";
        if ($operator    == "x") {
            $result = $a * $b;
            $text_opr = "dikali";
        } else {
            $result = $a + $b;
            $text_opr = "ditambah";
        }


        $code["res"] = $result;
        $code["text"] = "Berapa " . $angka[$a - 1] . " " . $text_opr . " " . $angka[$b - 1] . " ?";
        return $code;
    }

    public function masuk_v()
    {
        $data = $this->generate_capcta();
        $session = session();
        $session->set("captcha", $data["res"]);
        helper(['form', 'url']);
        echo view('admin/Masuk', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url("admin/masuk_v"));
    }

    public function masuk()
    {
        $session = session();
        $captcha = $session->get("captcha");
        if ($captcha != $this->request->getVar('captcha')) {
            $session->setFlashdata('msg', 'Captch salah harap isi dengan benar');
            return redirect()->to(base_url("admin/masuk_v"));
        }
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
                return redirect()->to(base_url("admin/masuk_v"));
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
            return redirect()->to(base_url("admin/masuk_v"));
        }


        $admin = new AdminModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $admin->where('username_admin', $username)->first();
        $admin->set(['password_admin' => password_hash(getenv("DEFAULT_ADMIN_PASSWORD"), PASSWORD_DEFAULT)])->where('username_admin', $username)->update();

        if ($data) {
            $pass = $data['password_admin'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'admin' => $data['kode_admin'],
                    'username_admin' => $data['username_admin'],
                    'email_admin' => $data['email_admin'],
                    'is_admin' => true
                ];
                $session->set($ses_data);
                return redirect()->to("event");
            } else {
                $session->setFlashdata('msg', 'Username atau Password anda salah.');
                return redirect()->to("masuk_v");
            }
        } else {
            $session->setFlashdata('msg', 'Username atau Password anda salah.');
            return redirect()->to("masuk_v");
        }
    }

    public function config()
    {
        $sesion = session();
        helper(['form', 'url']);
        echo view('admin/PanelTop', array('judul' => 'Event'));
        $this->get_config();
        echo view('admin/PanelBot');
    }

    public function get_config()
    {
        $config = new ConfigModel();
        $dataConfig = $config->first();
        $data = array(
            'config' => $dataConfig
        );
        echo view('admin/Config', $data);
    }

    public function event()
    {
        $session = session();
        helper(['form', 'url']);
        echo view('admin/PanelTop', array('judul' => 'Event'));
        $this->get_event();
        echo view('admin/PanelBot');
    }
    public function edit_event_v($kode)
    {
        $event = new EventModel();
        $db = \Config\Database::connect();
        $event_data = $event->where('kode_event', $kode)->first();
        $builder = $db->table("user");
        $builder->select("npm");
        $query = $builder->get();
        $users_npm = $query->getResultArray();
        foreach ($users_npm as $key => $value) {
            $users_npm[$key] = "20" . substr($value['npm'], 0, 2);
        }

        $event_data['waktu_mulai'] = DateTime::createFromFormat("Y-m-d H:i:s", $event_data['waktu_mulai']);
        $event_data['waktu_mulai'] = date_format($event_data['waktu_mulai'], "d/m/Y H.i");
        $event_data['waktu_selesai'] = DateTime::createFromFormat("Y-m-d H:i:s", $event_data['waktu_selesai']);
        $event_data['waktu_selesai'] = date_format($event_data['waktu_selesai'], "d/m/Y H.i");

        $data = array(
            'event_data' => $event_data,
        );
        echo view('admin/EditEvent', $data);
    }
    public function get_event()
    {
        helper(['form', 'url']);
        $db = \Config\Database::connect();
        $builder = $db->table('event');
        $builder->select('*');
        $builder->join('admin', 'event.admin=admin.kode_admin');
        $query = $builder->get();
        $event_data = $query->getResult();
        foreach ($event_data as $key => $value) {
            $dp = $db->table('DP_' . $value->kode_event)->selectCount('npm', 'jumlah')->get()->getResultArray();
            $event_data[$key]->dp_count = $dp[0]['jumlah'];
            $rekap = new RekapModel();
            $rek = $rekap->selectCount('kode_rekap', 'jumlah')->where('event', $value->kode_event)->first();
            $event_data[$key]->rek_count = $rek['jumlah'];
        }
        $data = array(
            'event_data' => $event_data
        );
        echo view("admin/Event", $data);
    }

    public function add_event()
    {
        $session = session();
        helper(['form', 'url']);
        $db = \Config\Database::connect();
        $builder = $db->table("event");
        $event = new EventModel();
        $msg = [];
        $last_event = $builder->orderBy("kode_event", "DESC")->limit(1)->get()->getResultArray();
        if (count($last_event) == 0) {
            $new_kode_event = "EVE0001";
        } else {
            $new_kode_event = "EVE" . sprintf("%04d", (((int)substr($last_event[0]['kode_event'], -4)) + 1));
        }
        $nama_event = $this->request->getVar("add_nama_event");
        $mulai_event = $this->request->getVar("add_mulai_event");
        $mulai_event = DateTime::createFromFormat("d/m/Y H.i", $mulai_event);
        $selesai_event = $this->request->getVar("add_selesai_event");
        $selesai_event = DateTime::createFromFormat("d/m/Y H.i", $selesai_event);
        $deskripsi_event = $this->request->getVar("add_deskripsi_event");
        $photo_event = $_FILES['add_foto_event']['name'];
        if ($mulai_event > $selesai_event) {
            $msg = array(
                'msg' => "Waktu selesai event tidak boleh mendahului waktu mulai event.",
                'type' => "error"
            );
        } else {
            if (!is_image($_FILES['add_foto_event']['tmp_name'])) {
                $msg = array('msg' => $photo_event->getErrorString());
                $msg['type'] = 'warning';
            } else {
                $photo_id =  gdupload($_FILES['add_foto_event']['tmp_name'], $new_kode_event);
                $data = array(
                    'kode_event' => $new_kode_event,
                    'nama_event' => $nama_event,
                    'deskripsi' => $deskripsi_event,
                    'foto_event' => $photo_id,
                    'admin' => $_SESSION['admin'],
                    'waktu_mulai' => $mulai_event->format('Y-m-d H:i'),
                    'waktu_selesai' => $selesai_event->format('Y-m-d H:i')
                );
                if ($event->save($data)) {
                    $forge = \Config\Database::forge();
                    $fields = [
                        'npm' => [
                            'type'          => 'VARCHAR',
                            'constraint'    => 11,
                            'null'          => false
                        ]
                    ];
                    $forge->addField($fields);
                    $forge->addPrimaryKey("npm");
                    $forge->createTable("DP_" . $new_kode_event, TRUE);
                    $fields = [
                        'id'        => [
                            'type'              => 'INT',
                            'constraint'        => 5,
                            'unsigned'          => true,
                            'auto_increment'    => true
                        ],
                        'pem' => [
                            'type'              => 'INT',
                            'constraint'        => 11
                        ],
                        'npm'       => [
                            'type'              => 'VARCHAR',
                            'constraint'        => 11
                        ],
                        'pilihan'   => [
                            'type'              => 'VARCHAR',
                            'constraint'        => 7,
                            'null'              => true
                        ]
                    ];
                    $forge->addField($fields);
                    $forge->addPrimaryKey("id");
                    $forge->createTable("TEMP_" . $new_kode_event, TRUE);
                    $fields = [
                        'id'        => [
                            'type'              => 'INT',
                            'constraint'        => 5,
                            'unsigned'          => true,
                            'auto_increment'    => true
                        ],
                        'nama'       => [
                            'type'              => 'VARCHAR',
                            'constraint'        => 50
                        ]
                    ];
                    $forge->addField($fields);
                    $forge->addPrimaryKey("id");
                    $forge->createTable("PEM_" . $new_kode_event, TRUE);
                    $msg = array(
                        'msg' => "Berhasil menambahkan event.",
                        'type' => 'success'
                    );
                }
            }
        }
        echo json_encode($msg);
    }
    public function edit_event($kode)
    {
        helper(['url', 'filesystem']);
        $sesion = session();
        $event = new EventModel();
        $nama_event = $this->request->getVar("edit_nama_event");
        $mulai_event = $this->request->getVar("edit_mulai_event");
        $mulai_event = DateTime::createFromFormat("d/m/Y H.i", $mulai_event);
        $selesai_event = $this->request->getVar("edit_selesai_event");
        $selesai_event = DateTime::createFromFormat("d/m/Y H.i", $selesai_event);
        $deskripsi_event = $this->request->getVar("edit_deskripsi_event");

        if ($mulai_event > $selesai_event) {
            $msg = array(
                'msg' => "Waktu selesai event tidak boleh mendahului waktu mulai event.",
                'type' => "error"
            );
        } else {
            $data = array(
                'nama_event' => $nama_event,
                'deskripsi' => $deskripsi_event,
                'admin' => $_SESSION['admin'],
                'waktu_mulai' => $mulai_event->format('Y-m-d H:i'),
                'waktu_selesai' => $selesai_event->format('Y-m-d H:i')
            );
            $event_data = $event->where('kode_event', $kode)->first();
            if (file_exists($_FILES['edit_foto_event']['tmp_name']) && is_uploaded_file($_FILES['edit_foto_event']['tmp_name'])) {
                $old_photoID = $event_data['foto_event'];
                if ($new_photoID = gdupload($_FILES['edit_foto_event']['tmp_name'], $kode)) {
                    gddelete($old_photoID);
                    $data['foto_event'] = $new_photoID;
                }
            }
            if ($event->where('kode_event', $kode)->set($data)->update()) {
                $msg = array(
                    'msg' => "Berhasil merubah event.",
                    'type' => 'success'
                );
            }
        }
        echo json_encode($msg);
    }
    public function delete_event($kode)
    {
        $event = new EventModel();
        $event_data = $event->where('kode_event', $kode)->first();
        if ($event->where('kode_event', $kode)->delete()) {
            gddelete($event_data['foto_event']);
            $forge = \Config\Database::forge();
            $forge->dropTable("DP_" . $kode);
            $forge->dropTable("TEMP_" . $kode);
            $forge->dropTable("PEM_" . $kode);
            $msg = array(
                'msg' => "Berhasil menghapus event.",
                'type' => 'success'
            );
        } else {
            $msg = array(
                'msg' => "Gagal menghapus event.",
                'type' => 'error'
            );
        }
        echo json_encode($msg);
    }
    //panitia
    public function panitia($kode = "all")
    {
        $sesion = session();
        helper(['url', 'form']);
        $event = new EventModel();
        if ($kode != "all") {
            $data = $event->where('kode_event', $kode)->first();
            echo view('admin/PanelTop', array('judul' => 'Panitia <b>' . $data['nama_event'] . "</b>"));
        }
        $this->get_panitia($kode);
        echo view('admin/PanelBot');
    }
    public function get_panitia($kode)
    {
        helper(['form', 'url']);
        $db = \Config\Database::connect();
        $builder = $db->table('panitia');
        $builder->select('user.npm,user.nama_user,event.nama_event,panitia.kode_panitia,panitia.jabatan,panitia.event');
        $builder->join('event', 'panitia.event=event.kode_event');
        $builder->join('user', "panitia.npm_panitia=user.npm");
        if ($kode != "all") $builder->where("panitia.event", $kode);
        $query = $builder->get();
        $panitia_data = $query->getResult();
        $data = array(
            "panitia_data" => $panitia_data,
            "event" => $kode
        );
        echo view('admin/Panitia', $data);
    }
    public function add_panitia()
    {
        $session = session();
        helper(['form', 'url']);
        $db = \Config\Database::connect();
        $builder = $db->table("panitia");
        $panitia = new PanitiaModel();
        $last_panitia = $builder->orderBy("kode_panitia", "DESC")->limit(1)->get()->getResultArray();
        if (count($last_panitia) == 0) {
            $new_kode_panitia = "PAN0001";
        } else {
            $new_kode_panitia = "PAN" . sprintf("%04d", (((int)substr($last_panitia[0]['kode_panitia'], -4)) + 1));
        }
        $npm = $this->request->getVar("add_npm_panitia");
        $jabatan = $this->request->getVar("add_jabatan_panitia");
        $event = $this->request->getVar("add_event_panitia");
        $check1 = $panitia->where('event', $event)->where('jabatan', $jabatan)->first();
        $check2 = $panitia->where('event', $event)->where('npm_panitia', $npm)->first();
        $data = array(
            'kode_panitia' => $new_kode_panitia,
            'npm_panitia' => $npm,
            'event' => $event,
            'jabatan' => $jabatan
        );
        if (is_null($check1) && is_null($check2)) {
            if ($panitia->save($data)) {
                $msg = array(
                    'msg' => "Berhasil menambahkan panitia.",
                    'type' => "success"
                );
            } else {
                $msg = array(
                    'msg' => "Terjadi kesalahan.",
                    'type' => "error"
                );
            }
        } else {
            $msg['type'] = "error";
            $msg['msg'] = "";
            if (!is_null($check2)) $msg['msg'] .= "NPM " . $npm . " sudah menjadi panitia di event ini. ";
            if (!is_null($check1)) $msg['msg'] .= "Jabatan " . $jabatan . " sudah ada di event ini. ";
        }
        $msg["event"] = $event;
        echo json_encode($msg);
    }
    public function get_panitia_edit($kode)
    {
        $session = session();
        helper(['url']);
        $db = \Config\Database::connect();
        $builder = $db->table('panitia');
        $builder->select("npm_panitia,nama_user,kode_panitia,jabatan");
        $builder->where("kode_panitia", $kode);
        $builder->join('user', "panitia.npm_panitia=user.npm");
        $data = $builder->get()->getResultArray();
        echo json_encode($data[0]);
    }
    public function edit_panitia()
    {
        $session = session();
        helper(['url', 'form']);
        $db = \Config\Database::connect();
        $builder = $db->table('panitia');
        $data = array(
            'npm_panitia' => $this->request->getVar("edit_npm_panitia"),
            'jabatan' => $this->request->getVar("edit_jabatan_panitia")
        );
        if ($builder->where("kode_panitia", $this->request->getVar("edit_kode_panitia"))->set($data)->update()) {
            $msg = array(
                'msg' => "Berhasil merubah panitia",
                'type' => "success"
            );
        } else {
            $msg = array(
                'msg' => "Terjadi Kesalahan",
                'type' => "error"
            );
        }
        $panitia = new PanitiaModel();
        $data = $panitia->where("kode_panitia", $this->request->getVar("edit_kode_panitia"))->first();
        $msg['event'] = $data['event'];
        echo json_encode($msg);
    }
    public function delete_panitia($kode)
    {
        $panitia = new PanitiaModel();
        $data = $panitia->where("kode_panitia", $kode)->first();
        if ($panitia->where("kode_panitia", $kode)->delete()) {
            $msg = array(
                'msg' => "Berhasil menghapus panitia.",
                'type' => 'success'
            );
        } else {
            $msg = array(
                'msg' => "Gagal menghapus panitia.",
                'type' => 'error'
            );
        }
        $msg['event'] = $data['event'];
        echo json_encode($msg);
    }
    //user
    public function get_user($npm)
    {
        $session = session();
        helper(['url']);
        $db = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->select("nama_user");
        $builder->where("npm", $npm);
        $data = $builder->get()->getResultArray();
        echo json_encode($data);
    }
    public function user()
    {
        $session = session();
        helper(['form', 'url']);
        echo view('admin/PanelTop', array('judul' => 'Daftar User'));
        $this->list_user();
        echo view('admin/PanelBot');
    }
    public function list_user()
    {
        $session = session();
        $user = new UserModel();
        $data_user = $user->findAll();
        $data = [
            'data_user' => $data_user
        ];
        echo view('admin/User', $data);
    }
    public function add_user()
    {
        helper(['form', 'text']);
        $npm = $this->request->getVar('add_npm_user');
        $nama =  $this->request->getVar('add_nama_user');
        $email_to = $this->request->getVar('add_email_user');
        $check_if = substr($npm, 2, 3);
        if ($check_if != "081") {
            $msg = [
                'msg' => "NPM bukan berasal dari informatika.",
                'type' => "warning"
            ];
            echo json_encode($msg);
            return;
        }
        $onetime_pass = random_string("alnum", 8);
        $user = new UserModel();
        $data = [
            'nama_user' => $nama,
            'npm' => $npm,
            'email_user' => $email_to,
            'password_user' => password_hash($onetime_pass, PASSWORD_DEFAULT)
        ];
        $email = \Config\Services::email();
        $main_email = getenv("EMAIL_SENDER");
        $email->setTo($email_to);
        $email->setFrom($main_email, "Admin Evote IF");
        $email->setReplyTo($main_email, "Admin Evote IF");
        $email->setSubject('Temporary Password');
        $email_str = "<br><p>Untuk berbagai informasi seputar Pemira 2022, silakan kunjungi & follow instagram kami untuk Pemira IF di : <a href='https://instagram.com/pemiraif2022'>@pemiraif2022</a> dan Pemira Fasilkom di : <a href='https://instagram.com/kpumfasilkom'>@kpumfasilkom</a></p>";
        $email->setMessage("Ini adalah password sementara untuk akunmu : " . $onetime_pass . $email_str);
        if ($email->send()) {
            if ($user->save($data)) {
                $msg = [
                    'msg' => "Berhasil menambahkan user.",
                    'type' => "success"
                ];
            }
        } else {
            $msg = [
                'msg' => $email->printDebugger(),
                'type' => "error"
            ];
        }
        echo json_encode($msg);
    }
    public function delete_user($npm)
    {
        $user = new UserModel();
        if ($user->where('npm', $npm)->delete()) {
            $msg = [
                'msg' => "Berhasil menghapus user.",
                'type' => "success"
            ];
        } else {
            $msg = [
                'msg' => "Gagal menghapus user.",
                'type' => "error"
            ];
        }
        echo json_encode($msg);
    }
}
