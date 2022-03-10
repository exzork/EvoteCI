<?php

namespace App\Controllers;

use App\Models\PanitiaModel;
use App\Models\CalonModel;
use App\Models\EventModel;
use App\Models\RekapModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\Encryption\Encryption;
use DateTime;
use function GuzzleHttp\json_decode;

class Panitia extends Controller
{

    public function index()
    {
        $this->event();
    }

    public function event()
    {
        $session = session();
        echo view("panitia/PanelTop", array('judul' => 'Event'));
        $this->get_event();
        echo view("panitia/PanelBot");
    }

    //event
    public function get_event()
    {
        $session = session();
        helper(['url']);
        $panitia = new PanitiaModel();
        $kode_event = $panitia->where('npm_panitia', $_SESSION['npm'])->findColumn('event');
        $event = new EventModel();
        $data_event = $event->whereIn('kode_event', $kode_event)->findAll();
        foreach ($data_event as $key => $value) {
            $date_s = new DateTime($value['waktu_mulai']);
            $date_e = new DateTime($value['waktu_selesai']);
            $date_n = new DateTime();
            if ($date_s > $date_n)
                $data_event[$key]["status"] = 2;
            else if ($date_e > $date_n && $date_s < $date_n) {
                $data_event[$key]["status"] = 1;
            } else if ($date_e < $date_n)
                $data_event[$key]["status"] = 3;

            $db = \Config\Database::connect();
            $builder = $db->table("rekap")->where('event', $value['kode_event'])->where('valid', NULL);
            $data_temp = $builder->select("*")->get()->getResultArray();
            if (count($data_temp) != 0)
                $data_event[$key]["verif"] = 0;
            else
                $data_event[$key]["verif"] = 1;
            $builder = $db->table("PEM_" . $value['kode_event']);
            $data_pem = $builder->select("*")->get()->getResultArray();
            if (count($data_pem) > 0) {
                $data_event[$key]['pemilihan'] = $data_pem;
            } else {
                $data_event[$key]['pemilihan'] = [];
            }
        }

        $data = array(
            'event_data' => $data_event
        );
        echo view("panitia/Event", $data);
    }

    //calon
    public function calon($kode_event, $kode_pem)
    {
        $session = session();
        helper(['url']);
        $db = \Config\Database::connect();
        $builder = $db->table('PEM_' . $kode_event);
        $data_pem = $builder->where("id", $kode_pem)->get()->getResultArray();
        if (count($data_pem) == 0)
            return redirect()->to(base_url('panitia/event'));
        echo view("panitia/PanelTop", array('judul' => 'Calon'));
        $this->get_calon($kode_event, $kode_pem);
        echo view("panitia/PanelBot");
    }

    public function get_calon($event, $pem)
    {
        $session = session();
        helper(['url']);
        $db = \Config\Database::connect();
        $builder = $db->table('calon');
        $builder->select('calon.npm_ketua,calon.npm_wakil,calon.kode_calon,calon.foto_calon,calon.pesan,calon.panitia,ketua.nama_user as nama_ketua, wakil.nama_user as nama_wakil, panitia.nama_user as nama_panitia');
        $builder->join('user as ketua', 'ketua.npm=calon.npm_ketua', 'left');
        $builder->join('user as wakil', 'wakil.npm=calon.npm_wakil', 'left');
        $builder->join('panitia as pan', 'pan.kode_panitia=calon.panitia');
        $builder->join('user as panitia', 'panitia.npm=pan.npm_panitia');
        $builder->where('pan.event', $event)->where('calon.pem', $pem);
        $data_calon = $builder->get()->getResultArray();
        $data = array(
            'calon_data' => $data_calon,
            'event' => $event,
            'pem' => $pem
        );
        echo view('panitia/Calon', $data);
    }

    public function add_calon()
    {
        $sesion = session();
        helper(['url', 'form']);
        $db = \Config\Database::connect();
        $builder = $db->table("calon");
        $calon = new CalonModel();
        $last_calon = $builder->orderBy("kode_calon", "DESC")->limit(1)->get()->getResultArray();
        if (count($last_calon) == 0) {
            $new_kode_calon = "CAL0001";
        } else {
            $new_kode_calon = "CAL" . sprintf("%04d", (((int)substr($last_calon[0]['kode_calon'], -4)) + 1));
        }
        $event = $this->request->getVar("add_event_calon");
        $ketua = $this->request->getVar("add_ketua_calon");
        $wakil = $this->request->getVar("add_wakil_calon");
        $pem = $this->request->getVar('add_pem_calon');
        if ($wakil == "") $wakil = NULL;
        $foto = $_FILES['add_foto_calon']['tmp_name'];
        $pesan = $this->request->getVar("add_pesan_calon");
        $panitia = new PanitiaModel();
        $panitia_data = $panitia->where('event', $event)->where('npm_panitia', $_SESSION['npm'])->first();
        if (is_image($foto) > 0) {
            if ($foto_id = gdupload($foto, $new_kode_calon)) {
                $data = array(
                    'kode_calon' => $new_kode_calon,
                    'npm_ketua' => $ketua,
                    'npm_wakil' => $wakil,
                    'foto_calon' => $foto_id,
                    'pesan' => $pesan,
                    'pem' => $pem,
                    'panitia' => $panitia_data['kode_panitia']
                );
                if ($calon->save($data)) {
                    $msg = array(
                        'msg' => "Berhasil menambahkan calon.",
                        'type' => 'success'
                    );
                } else {
                    $msg = array(
                        'msg' => "Terjadi kesalahan.",
                        'type' => "error"
                    );
                }
            } else {
                $msg = array(
                    'msg' => "Terjadi kesalahan saat upload foto.",
                    'type' => "error"
                );
            }
        }
        $msg['event'] = $event;
        $msg['pem'] = $pem;
        echo json_encode($msg);
    }

    public function edit_calon_v($kode)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('calon');
        $builder->select('calon.npm_ketua,calon.npm_wakil,calon.kode_calon,calon.foto_calon,calon.pesan,calon.panitia,ketua.nama_user as nama_ketua, wakil.nama_user as nama_wakil,pan.event');
        $builder->join('user as ketua', 'ketua.npm=calon.npm_ketua', 'left');
        $builder->join('user as wakil', 'wakil.npm=calon.npm_wakil', 'left');
        $builder->join('panitia as pan', 'pan.kode_panitia=calon.panitia');
        $builder->where('calon.kode_calon', $kode);
        $data_calon = $builder->get()->getResultArray();
        $data = array(
            'data_calon' => $data_calon
        );
        echo view("panitia/EditCalon", $data);
    }

    public function edit_calon($kode)
    {
        helper(['url', 'filesystem']);
        $sesion = session();
        $calon = new CalonModel();
        $ketua = $this->request->getVar("edit_ketua_calon");
        $wakil = $this->request->getVar("edit_wakil_calon");
        if ($wakil == "") $wakil = NULL;

        $pesan = $this->request->getVar("edit_pesan_calon");
        $event = $this->request->getVar("edit_event_calon");
        $panitia = new PanitiaModel();
        $panitia_data = $panitia->where('event', $event)->where('npm_panitia', $_SESSION['npm'])->first();
        $data = array(
            'npm_ketua' => $ketua,
            'npm_wakil' => $wakil,
            'pesan' => $pesan,
            'panitia' => $panitia_data['kode_panitia']
        );
        $calon_data = $calon->where('kode_calon', $kode)->first();
        if (file_exists($_FILES['edit_foto_calon']['tmp_name']) && is_uploaded_file($_FILES['edit_foto_calon']['tmp_name'])) {
            $foto = $_FILES['edit_foto_calon']['tmp_name'];
            $foto_id = gdupload($foto, $kode);
            $data['foto_calon'] = $foto_id;
            gddelete($calon_data['foto_calon']);
        }
        if ($calon->where('kode_calon', $kode)->set($data)->update()) {
            $msg = array(
                'msg' => "Berhasil merubah event.",
                'type' => 'success'
            );
        } else {
            $msg = array(
                'msg' => "Terjadi Kesalahan.",
                'type' => 'error'
            );
        }
        $msg['event'] = $event;
        $msg['pem'] = $calon_data['pem'];
        echo json_encode($msg);
    }

    public function delete_calon($kode)
    {
        $calon = new CalonModel();
        $db = \Config\Database::connect();
        $builder = $db->table('calon');
        $builder->select("panitia.event,calon.foto_calon,calon.pem");
        $builder->join('panitia', "panitia.kode_panitia=calon.panitia");
        $builder->where("calon.kode_calon", $kode);
        $data_calon = $builder->get()->getResultArray();
        if ($calon->where('kode_calon', $kode)->delete()) {
            gddelete($data_calon[0]['foto_calon']);
            $msg = array(
                'msg' => "Berhasil menghapus calon.",
                'type' => 'success'
            );
        } else {
            $msg = array(
                'msg' => "Gagal menghapus event.",
                'type' => 'error'
            );
        }
        $msg['event'] = $data_calon[0]['event'];
        $msg['pem'] = $data_calon[0]['pem'];
        echo json_encode($msg);
    }

    //user
    public function get_user($npm)
    {
        $sesion = session();
        helper(['url']);
        $db = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->select("nama_user");
        $builder->where("npm", $npm);
        $data = $builder->get()->getResultArray();
        echo json_encode($data);
    }

    //verifikasi suara
    public function verif_v($kode)
    {
        $sesion = session();
        helper(['url']);
        echo view("panitia/PanelTop", array('judul' => 'Verifikasi Suara'));
        $this->verif($kode);
        echo view("panitia/PanelBot");
    }

    public function verif($kode)
    {
        $sesion = session();
        $db = \Config\Database::connect();
        $builder = $db->table("TEMP_" . $kode);
        $data_temp = $builder->select("TEMP_" . $kode . ".id,TEMP_" . $kode . ".npm,rekap.foto_rekap")->join("rekap", "rekap.npm_pemilih=TEMP_" . $kode . ".npm")->where('event', $kode)->get()->getResultArray();
        $data = [
            'data_temp' => $data_temp,
            'event' => $kode
        ];
        echo view("panitia/Verif", $data);
    }

    public function verif_u($kode)
    {
        $session = session();
        helper(['form']);
        $db = \Config\Database::connect();
        $builder = $db->table("TEMP_" . $kode);
        $data_temp = $builder->select("TEMP_" . $kode . ".id,TEMP_" . $kode . ".npm,rekap.foto_rekap,rekap.foto_ktm")->join("rekap", "rekap.npm_pemilih=TEMP_" . $kode . ".npm")->where('event', $kode)->groupBy("TEMP_" . $kode . ".npm")->get()->getResultArray();
        $data_view = [
            'data_temp' => $data_temp
        ];
        $data['html'] = view("panitia/UVerif", $data_view);
        echo json_encode($data);
    }

    public function verify($kode)
    {

        $encryption = new Encryption();
        $encrypter = $encryption->initialize();
        $session = session();
        helper(['form']);
        $rekap = new RekapModel();
        $db = \Config\Database::connect();
        $npm = $this->request->getVar("npm");
        $valid = $this->request->getVar("valid");
        $builder = $db->table("TEMP_" . $kode);
        $data_temp = $builder->where("npm", $npm)->get()->getResultArray();
        $error = false;
        if (count($data_temp) > 0) {
            $data = [
                'valid' => $valid
            ];
            if ($rekap->where('event', $kode)->where('npm_pemilih', $data_temp[0]['npm'])->set($data)->update()) {
                if ($data_temp[0]['pilihan'] != NULL) {
                    $calon = new CalonModel();
                    foreach ($data_temp as $value) {
                        $data_calon = $calon->where('kode_calon', $value['pilihan'])->first();
                        if (!is_null($data_calon) && $valid == 1) {
                            $calon->where('kode_calon', $value['pilihan'])->set("jumlah", "jumlah+1", FALSE)->update();
                        }
                    }
                }
                $msg = [
                    'msg' => "Berhasil menyimpan.",
                    'type' => "success",
                    'timer' => true
                ];
            }
        } else {
            $msg = [
                'msg' => "Sudah divalidasi",
                'type' => "warning",
                'timer' => true
            ];
        }
        if ($error) {
            $msg = [
                'msg' => "Terjadi Kesalahan. Mohon Laporkan Admin! Kode : C" . bin2hex($npm),
                'type' => "error",
                'timer' => false
            ];
        } else {
            $builder->where("npm", $npm)->delete();
        }
        echo json_encode($msg);
    }

    public function hasil($kode)
    {
        $forge = \Config\Database::forge();
        $db = \Config\Database::connect();
        $event = new EventModel();
        $data_event = $event->where('kode_event', $kode)->first();
        $date_e = new DateTime($data_event['waktu_selesai']);
        $date_n = new DateTime();
        if ($date_e > $date_n)
            return redirect()->to(base_url('panitia/event'));
        if ($db->tableExists("TEMP_" . $kode)) {
            $builder = $db->table("rekap")->where('event', $kode)->where('valid', NULL);
            $res = $builder->get()->getResultArray();
            if (count($res) == 0) {
                //$forge->dropTable("TEMP_" . $kode);
                goto lanjut_hasil;
            } else {
                return redirect()->to(base_url('panitia/verif_v/' . $kode));
            }
        } else {
            lanjut_hasil:
            $dp_table = $db->table('DP_' . $kode);
            $dp = $dp_table->get()->getResultArray();
            $rekap = new RekapModel();
            $rekap_valid = $rekap->where('event', $kode)->where('valid', 1)->findAll();
            $rekap_invalid = $rekap->where('event', $kode)->where('valid', 0)->findAll();
            $pem_tbl = $db->table('PEM_' . $kode);
            $data_pem = $pem_tbl->get()->getResultArray();
            foreach ($data_pem as $key => $value) {
                $builder = $db->table('calon');
                $builder->select('calon.npm_ketua,calon.npm_wakil,calon.kode_calon,calon.foto_calon,calon.pesan,calon.panitia,ketua.nama_user as nama_ketua, wakil.nama_user as nama_wakil, panitia.nama_user as nama_panitia,calon.jumlah');
                $builder->join('user as ketua', 'ketua.npm=calon.npm_ketua', 'left');
                $builder->join('user as wakil', 'wakil.npm=calon.npm_wakil', 'left');
                $builder->join('panitia as pan', 'pan.kode_panitia=calon.panitia');
                $builder->join('user as panitia', 'panitia.npm=pan.npm_panitia');
                $builder->where('pan.event', $kode)->where('calon.pem', $value['id']);
                $data_calon = $builder->get()->getResultArray();
                $data_pem[$key]['data_calon'] = $data_calon;
            }
        }
        $data = [
            'data_pem' => $data_pem,
            'data_event' => $data_event,
            'jml_dp' => count($dp),
            'jml_valid' => count($rekap_valid),
            'jml_invalid' => count($rekap_invalid)
        ];
        echo view("panitia/PanelTop", array('judul' => 'Hasil ' . $data_event['nama_event']));
        echo view('panitia/Hasil', $data);
        echo view("panitia/PanelBot");
    }

    //pemilih

    public function pemilih($kode)
    {
        $session = session();
        echo view("panitia/PanelTop", array('judul' => 'Daftar Pemilih'));
        $this->get_pemilih($kode);
        echo view("panitia/PanelBot");
    }
    public  function  send_pemilih($npm)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->select("nama_user");
        $builder->where("npm", $npm);
        $data = $builder->get()->getResultArray();
        if (count($data) > 0) {
            echo 0;
        } else {
            $ch = curl_init('https://api-frontend.kemdikbud.go.id/hit_mhs/' . $npm);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            $response = json_decode($response);
            $mhs_upn = "";
            foreach ($response->mahasiswa as $key => $value) {
                $mhs = explode(',', $value->text);
                $check_upn = strpos($mhs[1], 'PT : UNIVERSITAS PEMBANGUNAN NASIONAL VETERAN JAWA TIMUR');
                $check_if = strpos($mhs[2], 'Prodi: INFORMATIKA');
                $check_if2 = strpos($mhs[2], 'Prodi: TEKNIK INFORMATIKA');
                if ($check_upn !== false && ($check_if !== false || $check_if2 !== false)) {
                    $mhs_upn =  preg_replace('/\s+/', ' ', $value->text);
                }
            }
            //echo $mhs_upn;
            $result = explode('(', $mhs_upn);
            $nama = ucwords(strtolower($result[0]));
            helper(['form', 'text']);
            $email_to = $npm . "@student.upnjatim.ac.id";
            $onetime_pass = random_string("alnum", 8);
            $user = new UserModel();
            $data = [
                'nama_user' => $nama,
                'npm' => $npm,
                'email_user' => $email_to,
                'password_user' => password_hash($onetime_pass, PASSWORD_DEFAULT)
            ];
            $email = \Config\Services::email();
            $email->setTo($email_to);
            $email->setFrom("admin@evote-if.xyz", "Admin Evote IF");
            $email->setReplyTo("admin@evote-if.xyz", "Admin Evote IF");
            $email->setSubject('PEMIRA INFORMATIKA 2022');
            $email_str = '<p>PEMIRA INFORMATIKA 2022 sudah semakin dekat, pastikan suara anda digunakan sebaik mungkin pada pemilihannya yang dilaksanakan pada tanggal 19 Maret 2022 pukul 08.00 - 15.00 WIB yang dilakukan secara online di website <a href="https://pemiraifupn.com" target="_blank" rel="noopener">pemiraifupn.com</a> .</p><p>Bagi yang belum mendaftar per tanggal 28 Februari 2021 pukul 22.00 WIB.</p><p>Berikut password yang digunakan untuk login : ' . $onetime_pass . '</p><p>Silakan login di <a href="https://evoteif.xyz" target="_blank" rel="noopener">evoteif.xyz</a>&nbsp; untuk melakukan pemilihan menggunakan NPM masing-masing dan password diatas</p><p>Untuk Info lebih lanjut mengenai cara memilih dan para calon silakan cek IG PEMIRA INFORMATIKA <a href="https://www.instagram.com/pemiraif2022/">@pemiraif2022</a> dan channel youtube <a href="https://www.youtube.com/channel/UCsyT1maVLJouLYiuhBV66UA" target="_blank" rel="noopener">PEMIRA INFORMATIKA</a> (https://www.youtube.com/channel/UCsyT1maVLJouLYiuhBV66UA)</p><p>jika ada kendala saat akses website silakan hubungi :<br />- CP Yanuar <br />Wa: 081233806275<br />Line: fitroni123</p><p>- CP Daffa <br />Wa: 087815584752<br />Line: ardidafa21</p>';
            $email->setMessage($email_str);
            if ($email->send()) {
                if ($user->save($data)) {
                    echo 1;
                }
            } else {
                $msg = [
                    'msg' => $email->printDebugger(),
                    'type' => "error"
                ];
                echo json_encode($msg);
            }
        }
    }
    public function get_pemilih($kode)
    {
        $db = \Config\Database::connect();
        $builder = $db->table("DP_" . $kode);
        $data_pemilih = $builder->select("npm")->get()->getResultArray();
        $data = [
            'data_pemilih' => $data_pemilih,
            'kode_event' => $kode
        ];
        echo view('panitia/Pemilih', $data);
    }

    public function add_pemilih()
    {
        helper(['session', 'form']);
        $npm = $this->request->getVar('npm');
        $event = $this->request->getVar('event');
        $db = \Config\Database::connect();
        $builder = $db->table("DP_" . $event);
        $data_pemilih = $builder->select("*")->get()->getResultArray();
        $npm = preg_split('/\r\n|\r|\n/', $npm);
        foreach ($npm as $key => $value) {
            if ($value == "")
                unset($npm[$key]);
        }
        $data = [];
        $jumlah_asli = count($npm);
        $npm = array_diff($npm, array_column($data_pemilih, 'npm'));
        foreach ($npm as $key => $value) {
            if (!(strlen($value) > 11))
                array_push($data, ['npm' => $value]);
        }
        $jumlah_sukses = 0;
        if (count($data) > 0)
            $jumlah_sukses = $builder->insertBatch($data, null, 1000);
        $msg = [
            'msg' => "Sukses menambahkan " . $jumlah_sukses . " dari " . $jumlah_asli . " inputan.",
            'type' => "success"
        ];
        echo json_encode($msg);
    }

    public function delete_pemilih($kode)
    {
        helper(['form']);
        $npm = $this->request->getVar('npm');
        $db = \Config\Database::connect();
        $builder = $db->table("DP_" . $kode);
        $builder->where('npm', $npm)->delete();
        $msg = [
            'msg' => "Berhasil menghapus " . $npm,
            'type' => "success"
        ];
        echo json_encode($msg);
    }

    public function delete_all_pemilih($kode)
    {
        $db = \Config\Database::connect();
        $builder = $db->table("DP_" . $kode);
        $builder->truncate();
        $msg = [
            'msg' => "Berhasil menghapus semua data",
            'type' => "success"
        ];
        echo json_encode($msg);
    }

    //pemilihan
    public function add_pemilihan()
    {
        helper(['form']);
        $pemilihan = $this->request->getVar('add_pemilihan');
        $event = $this->request->getVar('event');
        $db = \Config\Database::connect();
        $builder = $db->table("PEM_" . $event);
        $data = ['nama' => $pemilihan];
        if ($builder->insert($data)) {
            $msg = [
                'msg' => "Berhasil menambahakan pemilihan",
                'type' => "success"
            ];
        } else {
            $msg = [
                'msg' => "Gagal menambahakan pemilihan",
                'type' => "error"
            ];
        }
        echo json_encode($msg);
    }

    public function remove_pemilihan()
    {
        helper(['form']);
        $event = $this->request->getVar('event');
        $pem = $this->request->getVar('pem');
        $db = \Config\Database::connect();
        $builder = $db->table("PEM_" . $event);
        if ($builder->where('id', $pem)->delete()) {
            $msg = [
                'msg' => "Berhasil menghapus pemilihan",
                'type' => "success"
            ];
        } else {
            $msg = [
                'msg' => "Gagal menghapus pemilihan",
                'type' => "error"
            ];
        }
        echo json_encode($msg);
    }
}
