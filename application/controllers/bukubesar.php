<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bukubesar extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('homemodel');
		$this->load->model('bukubesarM');
		session_start ();
	}

	public function index()
	{
		if($this->auth->is_logged_in () == false)
		{
			$this->login();
		}
		else
		{
			$data['multilevel'] = $this->usermodel->get_data(0,$this->session->userdata('level'));
			$data ['nama'] = $this->homemodel->get_nama_kantor ();
			$this->template->set ( 'title', 'Home' );
			$this->template->load ( 'tempDataTable', 'admin/index',$data );
		}
	}

	public function home()
	{
		$this->auth->restrict ();
		$this->auth->cek_menu ( 48 );
		if(isset($_POST["btnPreview"])){
			$this->viewReport();
		}else{
			$data ['multilevel'] = $this->usermodel->get_data(0,$this->session->userdata('level'));

			$this->template->set ( 'title', 'Buku Besar' );
			$this->template->load ( 'tempDataTable', 'admin/bukubesarV', $data );
		}
	}
    public function viewReport()
    {
        $tgl1       = trim($this->input->post('txtTGlTrans1'));
        $timestamp  = strtotime($tgl1);
        $tglTrans1  = date('Y-m-d', $timestamp);

        $tgl2       = trim($this->input->post('txtTGlTrans2'));
        $timestamp  = strtotime($tgl2);
        $tglTrans2  = date('Y-m-d', $timestamp);

        $kodePerk   = trim($this->input->post('txtKodePerk'));
        $data['namaPerk']   = trim($this->input->post('txtNamaPerk'));
        $data['kodePerk']   = $kodePerk;

        if(substr($kodePerk,0,1)=='1' || substr($kodePerk,0,1)=='5'){
            $saldoAwalBB            = $this->bukubesarM->getSaldoAwalBB15($kodePerk,$tglTrans1);
            $data['saldoAwalBB']    = $saldoAwalBB[0]->saldo_awal;
            $data['saldobukubesar'] = $this->bukubesarM->getSaldoPerk15($kodePerk,$tglTrans1,$tglTrans2);
            //
        }else{
            $saldoAwalBB            = $this->bukubesarM->getSaldoAwalBB234($kodePerk,$tglTrans1);
            $data['saldoAwalBB']    = $saldoAwalBB[0]->saldo_awal;
            $data['saldobukubesar'] = $this->bukubesarM->getSaldoPerk234($kodePerk,$tglTrans1,$tglTrans2);
        }
        $data['tgl1'] =$tgl1;
        $data['tgl2'] =$tgl2;
        $data ['multilevel'] = $this->usermodel->get_data(0,$this->session->userdata('level'));
        $this->template->set ( 'title', 'Laporan Buku Besar' );
        $this->template->load ( 'tempDataTable', 'admin/resultBukuBesarV', $data );
    }

	


}

/* End of file main.php */
/* Location: ./application/controllers/kasumum.php */
