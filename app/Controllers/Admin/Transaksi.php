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

        // $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $this->transaksiModel  ->select('*', 'transaksi.id AS id_transaksi')
                                            ->join('barang','barang.id=transaksi.id_barang')
                                            ->join('user','user.id=transaksi.id_pembeli')
                                            ->where('transaksi.id',$id_transaksi)
                                            ->first();

        echo view('admin/template_header',$data);
        echo view('admin/view_transaksi', ['transaksi' => $transaksi,]); 
        echo view('admin/template_footer',$data);  
             
    }

    public function daftarTransaksi(){
        $data=[];
        $data['judul'] = "Daftar Transaksi";

        // $transaksiModel = new \App\Models\TransaksiModel();
        $model = $this->transaksiModel->findAll();

        echo view('admin/template_header',$data);
        echo view('admin/daftar_transaksi',['model' => $model]);
        echo view('admin/template_footer',$data); 
    }

    public function laporan(){
        $data=[];
        $data['judul'] = "Laporan Transaksi";

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
            ->join('barang', 'barang.id=transaksi.id_barang')
            ->where('transaksi.id', $id_transaksi)
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
            'id' => $id_transaksi,
            'bukti_bayar' => $namaGambar,
            'metode_pembayaran' => $this->request->getVar('nama_bank'),
            // 'atas_nama' => $this->request->getVar('atas_nama'),
            'status' => 'MENUNGGU KONFIRMASI PEMBAYARAN'
        ]);

        session()->setFlashdata('pesan', 'Kamu berhasil membayar, silahkan tunggu konfirmasi dari kami');

        return redirect()->to('/transaksi/user');
    }

    public function user()
    {
        // if (!$this->session->has('isLogin')) {
        //     return redirect()->to('/login');
        // }

        $id = $this->session->get('id');
        $transaksiModel = new \App\Models\TransaksiModel();

        $model = $transaksiModel->join('user', 'user.id=transaksi.id_pembeli')
            ->join('barang', 'barang.id=transaksi.id_barang')
            ->where('transaksi.id_pembeli', $id)
            ->where('transaksi.status!=', 'Produk sampai di tujuan')
            ->paginate(10);

        return view('transaksi/user', [
            'model' => $model,
            'pager' => $transaksiModel->pager,
            'username' => $this->session->get('username'),
            'title' => 'List Transaksi | Bunch of Gifts',
            'statusNav' => 'order',
            'cart' => $cart = \Config\Services::cart()
        ]);
    }
}
?>