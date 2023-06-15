<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\UserModel;
use App\Models\BarangModel;
use CodeIgniter\Config\Config;

use TCPDF;

class Transaksi extends BaseController
{
    public function __construct(){
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->session = session();
        $this->transaksiModel = new \App\Models\TransaksiModel();
        $this->userModel = new \App\Models\UserModel();
        $this->barangModel = new \App\Models\BarangModel();
        $this->email = \Config\Services::email();
    }

    public function viewTransaksi(){
        $id_transaksi = $this->request->uri->getSegment(3);
        $data = [];
        $data['judul'] = "Transaksi";
        $data['validation'] = \Config\Services::validation();

        // $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $this->transaksiModel  ->select('*', 'transaksi.id_transaksi AS id_transaksi')
                                            ->join('barang','barang.id_barang=transaksi.id_barang')
                                            ->join('user','user.id=transaksi.id_pembeli')
                                            ->where('transaksi.id_transaksi',$id_transaksi)
                                            ->first();

        echo view('admin/template_header',$data);
        echo view('admin/view_transaksi', ['transaksi' => $transaksi,]); 
        echo view('admin/template_footer',$data);  
             
    }

    public function daftarTransaksi(){
        
        $transaksiModel = new \App\Models\TransaksiModel();
        // $transaksiModel = new \App\Models\TransaksiModel();
        $model = $transaksiModel
        ->where('transaksi.status!=', 'BATAL')
        ->findAll();

        $data = [
            'judul' => 'Daftar Transaksi',
        ];

        echo view('admin/template_header',$data);
        echo view('admin/daftar_transaksi',['model' => $model]);
        echo view('admin/template_footer',$data); 
    }

    public function laporan(){

        $request = service('request');
        $searchData = $request->getGet();
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        $dari = "";
        $ke = "";
        if (isset($searchData) && isset($searchData['dari'])) {
            $dari = $searchData['dari'];
        }
        if (isset($searchData) && isset($searchData['ke'])) {
            $ke = $searchData['ke'];
        }

        // Get data 
        $transaksi = new TransaksiModel();

        if ($dari == '' || $ke == '') {
            $paginateData = $transaksi->join('barang', 'barang.id_barang = transaksi.id_barang')
                ->join('user', 'user.id = transaksi.id_pembeli')
                ->paginate(10);
        } else {
            $paginateData = $transaksi->select('*')
                ->join('barang', 'barang.id_barang = transaksi.id_barang')
                ->join('user', 'user.id = transaksi.id_pembeli')
                ->where('transaksi.created_date >=', $dari)
                ->where('transaksi.created_date <=', $ke)
                ->paginate(10);
        }
        // dd($model);

        $data = [
            'judul' => 'Laporan Penjualan',
            'transaksi' => $paginateData,
            'pager' => $transaksi->pager,
            'dari' => $dari,
            'ke' => $ke,
            'currentPage' => $currentPage
        ];

        // $transaksiModel = new \App\Models\TransaksiModel();
        $model = $this->transaksiModel->findAll();

        echo view('admin/template_header',$data);
        echo view('admin/laporan_transaksi',['model' => $model]);
        echo view('admin/template_footer',$data);
    }

    public function invoice(){
        $id_transaksi = $this->request->uri->getSegment(3);

        // $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $this->transaksiModel->find($id_transaksi);
        // $transaksi = $this->transaksiModel->select('id_transaksi')->where('id_transaksi',$id);

        // $userModel = new \App\Models\UserModel();
        // dd($transaksi);
        $pembeli = $this->userModel->find($transaksi->id_pembeli);
        // $pembeli = $this->transaksiModel->select('id_pembeli')->where('id_transaksi',$id);
        
        // $barangModel = new \App\Models\BarangModel();
        $barang = $this->barangModel->find($transaksi->id_barang);
        // $barang = $this->transaksiModel->select('id_barang')->where('id_transaksi',$id);

        $html = view('transaksi/invoice',[
            'transaksi' => $transaksi,
            'pembeli' => $pembeli,
            'barang' => $barang,
        ]);

        $pdf = new TCPDF('L', PDF_UNIT, 'A5B', true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Monday to Friday Store');
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('Invoice');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->addPage();
        
        $pdf->writeHTML($html, true, false, true, false, '');

        //$this->response->setContentType('application/pdf');
        $email_pembeli = $pembeli->email;

        $pdf->Output('C:/xampp/htdocs/monday2friday/uploads/invoice.pdf', 'F');
        $attachment = base_url('uploads/invoice.pdf');
        $message = "<h1>Invoice Pembelian</h1><p>Kepada ".$pembeli->username.
        " berikut Invoice atas pembelian Anda</p><br><h4><strong>TERIMA KASIH</strong></h4>";

        $this->sendEmail($attachment, $email_pembeli, 'Invoice', $message);

        $this->session->setFlashdata('success',['Invoice Berhasil Dikirim']);
        return redirect()->to(site_url('admin/daftartransaksi'));
    }

    private function sendEmail($attachment, $to, $title, $message){
        $this->email->setFrom(EMAIL_PENGIRIM,EMAIL_NAMA);
        $this->email->setTo($to);
        $this->email->attach($attachment);
        $this->email->setSubject($title);
        $this->email->setMessage($message);

        if(!$this->email->send()){
            return false;
        }else{
            return true;
        }
    }

    public function bayar()
    {
        // if (!$this->session->has('isLogin')) {
        //     return redirect()->to('/login');
        // }
        $id_transaksi = $this->request->uri->getSegment(3);
        $transaksiModel = new \App\Models\TransaksiModel();

        $model = $transaksiModel->join('user', 'user.id=transaksi.id_pembeli')
            ->join('barang', 'barang.id_barang=transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id_transaksi)
            ->first();

            // dd($model);

        // $productsModel = new \App\Models\ProductsModel();
        // $barang = $this->barangModel->getProducts();

        $data = [
            'title' => 'Bayar Pesanan | Monday to Friday',
            // 'statusNav' => 'order',
            'validation' => \Config\Services::validation(),
            'model' => $model,
            // 'barang' => $barang,
            'transaksi' => $this->transaksiModel->getTransaction($id_transaksi),
            'cart' => $cart = \Config\Services::cart()
        ];
        return view('transaksi/bayar', $data);
    }

    public function submitBayar()
    {
        $id_transaksi = $this->request->uri->getSegment(3);
        // if (!$this->session->has('isLogin')) {
        //     return redirect()->to('/login');
        // }

        
        
        $transaksiModel = new \App\Models\TransaksiModel();

        if (!$this->validate([
            'nama_bank' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} product harus diisi,',
                ]
            ],
            'atas_nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} product harus diisi,',
                ]
            ],
            'bukti_bayar' => [
                'rules' => 'max_size[bukti_bayar,1024]|is_image[bukti_bayar]|mime_in[bukti_bayar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            return redirect()->to('/transaksi/bayar/' . $id_transaksi)->withInput();
        }

        $fileBuktiBayar = $this->request->getFile('bukti_bayar');
        //Cek apakah tidak ada gambar yang diupload
        if ($fileBuktiBayar->getError() == 4) {
            $namaGambar = 'default.png';
        } else {
            //Generate nama gambar random
            $namaGambar = $fileBuktiBayar->getRandomName();
            //pindahkan file ke folder img
            $fileBuktiBayar->move('img', $namaGambar);
        }

        // dd($namaGambar);

        $transaksiModel->save([
            'id_transaksi' => $id_transaksi,
            'bukti_bayar' => $namaGambar,
            'metode_pembayaran' => $this->request->getVar('nama_bank'),
            // 'atas_nama' => $this->request->getVar('atas_nama'),
            'status' => 'MENUNGGU KONFIRMASI PEMBAYARAN'
        ]);

        session()->setFlashdata('pesan', 'Kamu berhasil membayar, silahkan tunggu konfirmasi dari kami');

        return redirect()->to('/transaksi/user');
    }
    public function cekPembayaran()
    {
        $id_transaksi = $this->request->uri->getSegment(3);
        $transaksiModel = new \App\Models\TransaksiModel();

        $model = $transaksiModel
            ->join('user', 'user.id=transaksi.id_pembeli')
            ->join('barang', 'barang.id_barang=transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id_transaksi)
            ->first();

            // dd($model->bukti_bayar);

        $data = [
            'judul' => 'Konfirmasi Pembayaran | Admin',
            // 'statusSide' => 'pesanan',
            'validation' => \Config\Services::validation(),
            'model' => $model,
            'transaksi' => $this->transaksiModel->getTransaction($id_transaksi)
        ];
        echo view('admin/template_header',$data);
        echo view('admin/cekPembayaran', $data);
        echo view('admin/template_footer',$data);
    }

    public function prosesProduk()
    {
        $id_transaksi = $this->request->uri->getSegment(3);
        $transaksiModel = new \App\Models\TransaksiModel();
        $model = $transaksiModel
            ->join('user', 'user.id=transaksi.id_pembeli')
            ->join('barang', 'barang.id_barang=transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id_transaksi)
            ->first();

            // ->join('barang','barang.id_barang=transaksi.id_barang')
            // ->join('user','user.id=transaksi.id_pembeli')
            // ->where('transaksi.id_transaksi',$id_transaksi)
            // ->first()

            // dd($id_transaksi);
        // dd($model);

        if ($_POST['submit'] == 'bukti salah') {
            // dd("bukti salah");

            $this->email->setFrom('jackquiledarrent@gmail.com', 'Monday to Friday');

            //EMAIL INVOICE manual
            $this->email->setTo($model->email);

            // $this->email->attach($attachment);
            $this->email->SetSubject('Bukti Pembayaran gagal di verifikasi');

            $this->email->setMessage('Kami mendapati bahwa bukti Pembayaran gagal di verifikasi. silahkan upload bukti pembayaran yang benar'); // Our message above including the link

            if (!$this->email->send()) {
                session()->setFlashdata('gagal', 'Email gagal dikirim, silahkan ulangi aktivitas anda');
                return redirect()->to('admin/daftartransaksi');
            } else {
                $transaksiModel->save([
                    'id_transaksi' => $id_transaksi,
                    'bukti_bayar' => '',
                    'nama_bank' => '',
                    'atas_nama' => '',
                    'status' => 'BUKTI BAYAR SALAH'
                ]);
                session()->setFlashdata('pesan', 'Anda berhasil membatalkan konfirmasi bukti pembayaran');
                return redirect()->to('admin/daftartransaksi');
            }
        } else if ($_POST['submit'] == 'bukti benar') {

            // dd($model->email);
            $this->email->setFrom(EMAIL_PENGIRIM, 'Monday to Friday');

            //EMAIL INVOICE manual
            $this->email->setTo($model->email);

            // $this->email->attach($attachment);
            $this->email->SetSubject('Bukti Pembayaran berhasil di verifikasi');

            $this->email->setMessage('Yeay! bukti pembayaran anda sudah berhasil di verifikasi, produk anda sedang diproses. Harap menunggu ya!'); // Our message above including the link

            if (!$this->email->send()) {
                session()->setFlashdata('gagal', 'Email gagal dikirim, silahkan ulangi aktivitas anda');
                return redirect()->to('admin/daftartransaksi');
            } else {
                $transaksiModel->save([
                    'id_transaksi' => $id_transaksi,
                    'status' => 'TRANSAKSI DIPROSES',
                ]);
                session()->setFlashdata('pesan', 'Pembayaran berhasil di verifikasi!');
                return redirect()->to('admin/daftartransaksi');
            }
        }
    }
    public function simpanResi()
    {
        $id_transaksi = $this->request->uri->getSegment(3);
        $transaksiModel = new \App\Models\TransaksiModel();

        if (!$this->validate([
            'kode_resi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} product harus diisi,',
                ]
            ]
        ])) {
            return redirect()->to('admin/viewtransaksi/' . $id_transaksi);
        }

        $model = $transaksiModel
            ->join('user', 'user.id=transaksi.id_pembeli')
            ->join('barang', 'barang.id_barang=transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id_transaksi)
            ->first();
            // dd($model->email);

        $status = 'DIKIRIM';

        $this->email->setFrom('jackquiledarrent@gmail.com', 'Monday to Friday');

        //EMAIL INVOICE manual
        $this->email->setTo($model->email);

        // $this->email->attach($attachment);
        $this->email->SetSubject('Produk anda sedang dikirim!');

        $this->email->setMessage('Produk anda sedang dikirim menggunakan kurir yang anda pesan. Anda dapat melacak pesanan dengan klik link berikut ini http://localhost:8080/transaksi/user dan klik tombol lacak pesanan');

        if (!$this->email->send()) {
            // dd('gagal');
            session()->setFlashdata('gagal', 'Email gagal dikirim, silahkan ulangi aktivitas anda');
            return redirect()->to('admin/viewtransaksi/' . $id_transaksi);
        } else {
            $transaksiModel->save([
                'id_transaksi' => $id_transaksi,
                'status' => $status,
                'kode_resi' => $this->request->getVar('kode_resi'),
            ]);
            // dd('berhasil');
            session()->setFlashdata('pesan', 'Anda berhasil menginput resi');
            return redirect()->to('admin/viewtransaksi/' . $id_transaksi);
        }
    }

    public function batal(){
        $id_transaksi = $this->request->uri->getSegment(3);
        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksiModel->save([
            'id_transaksi' => $id_transaksi,
            'status' => 'BATAL'
        ]);

        return redirect()->to('/transaksi/user');
    }
    public function batalAdmin(){
        $id_transaksi = $this->request->uri->getSegment(3);
        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksiModel->save([
            'id_transaksi' => $id_transaksi,
            'status' => 'BATAL'
        ]);

        return redirect()->to('admin/daftartransaksi');
    }

    //LIST TRANSAKSI USER
    public function user()
    {
        // if (!$this->session->has('isLogin')) {
        //     return redirect()->to('/login');
        // }

        $id_pembeli = $this->session->get('id');
        $transaksiModel = new \App\Models\TransaksiModel();
        // dd($this->session->get('id'));
        
        $model = $transaksiModel
            ->join('user', 'user.id=transaksi.id_pembeli')
            ->join('barang', 'barang.id_barang=transaksi.id_barang')
            ->where('transaksi.id_pembeli', $id_pembeli)
            ->where('transaksi.status!=', 'Produk sampai di tujuan')
            ->where('transaksi.status!=', 'BATAL')
            ->paginate(10);
        
        // dd($transaksiModel
        // ->join('user', 'user.id=transaksi.id_pembeli')
        // ->join('barang', 'barang.id_barang=transaksi.id_barang'));
        return view('transaksi/user', [
            'model' => $model,
            'pager' => $transaksiModel->pager,
            'username' => $this->session->get('username'),
            'title' => 'List Transaksi | Monday to Friday',
            'statusNav' => 'order',
            'cart' => $cart = \Config\Services::cart()
        ]);
    }

    //LACAK RESI
    public function lacakResi()
    {
        $id = $this->request->uri->getSegment(2);
        $transaksiModel = new \App\Models\TransaksiModel();
        
        $transaksi = $this->transaksiModel->getTransaction($id);
        // dd($transaksi);

        $data = [
            'judul' => 'Lacak Resi | Bunch of Gifts',
            'transaksi' => $transaksi,
            'cart' => $cart = \Config\Services::cart(),
            // 'statusNav' => 'order'
        ];
        return view('transaksi/lacakResi', $data);
    }
}
?>