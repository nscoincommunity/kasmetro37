<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Master_tabunganmodel extends CI_Model {
	public function getRekTabAll()
	{
		$sql="SELECT n.nasabah_id,t.no_rekening,n.nama_nasabah,n.alamat,t.saldo_akhir 
				from tabung t left join nasabah n on t.nasabah_id = n.nasabah_id 
				order by no_rekening asc";
		$query=$this->db->query($sql);
		return $query->result(); // returning rows, not row
	}
	public function getDeskripsiRekTab($noRekTab){
		$sql ="select t.jenis_tabungan, t.status_aktif, t.no_alternatif,t.suku_bunga,
				t.persen_pph, t.tgl_bunga, t.kode_group1, t.kode_group2, t.kode_group3, 
				t.kode_bi_pemilik, t.kode_bi_metoda, t.kode_bi_hubungan, t.flag_restricted, 
				t.abp, t.minimum, t.adm_per_bln, t.periode_adm, t.setoran_minimum, t.setoran_per_bln, 
				t.jkw, t.transaksi_normal,n.nasabah_id,n.nama_nasabah, n.alamat 
				from tabung t left join nasabah n on t.nasabah_id = n.nasabah_id  
				where no_rekening = '$noRekTab'";
		$query	= $this->db->query($sql);
		return $query->result();
	}
	public function get_rektab_byname($nama_nasabah){
		$this->db->select('t.no_rekening,n.nama_nasabah,n.alamat');
		$this->db->from('nasabah n');
		$this->db->join('tabung t', 't.nasabah_id=n.nasabah_id', 'left');
		$this->db->like( 'n.nama_nasabah', $nama_nasabah );
		
		$query = $this->db->get ();
		return $query->result ();
	}
	public function get_nasabah($nama_nasabah){
		$this->db->select('nasabah_id,nama_nasabah,alamat');
		$this->db->from('nasabah');
		$this->db->like( 'nama_nasabah', $nama_nasabah );
		
		$query = $this->db->get ();
		return $query->result ();
	}
	public function get_deskripsi_nasabah($nasabah_id) {
		$this->db->select('nasabah_id,nama_nasabah,alamat');
		$this->db->from('nasabah');
		$this->db->where( 'nasabah_id', $nasabah_id );
		$query = $this->db->get ();
		if($query->num_rows()== '1'){
			return $query->result ();
		}else{
			return false;
		}
	}
	public function get_jenis_tab() {
		$rows = array(); //will hold all results
		$sql="select * from kodejenistabungan order by KODE_JENIS_TABUNGAN asc ";
		$query=$this->db->query($sql);
		foreach($query->result_array() as $row){    
			$rows[] = $row; //add the fetched result to the result array;
		}
	   return $rows; // returning rows, not row
	}
	public function get_kodegroup1_tab() {
		$rows = array(); //will hold all results
		$sql="select * from kodegroup1tabung order by KODE_GROUP1 asc ";
		$query=$this->db->query($sql);
		foreach($query->result_array() as $row){    
			$rows[] = $row; //add the fetched result to the result array;
		}
	   return $rows; // returning rows, not row
	}
	public function get_kodegroup2_tab() {
		$rows = array(); //will hold all results
		$sql="select * from kodegroup2tabung order by KODE_GROUP2 asc ";
		$query=$this->db->query($sql);
		foreach($query->result_array() as $row){    
			$rows[] = $row; //add the fetched result to the result array;
		}
	   return $rows; // returning rows, not row
	}
	public function get_kodegroup3_tab() {
		$rows = array(); //will hold all results
		$sql="select * from kodegroup3tabung order by KODE_GROUP3 asc ";
		$query=$this->db->query($sql);
		foreach($query->result_array() as $row){    
			$rows[] = $row; //add the fetched result to the result array;
		}
	   return $rows; // returning rows, not row
	}
	public function get_kode_gol_deb_tab() {
		$rows = array(); //will hold all results
		$sql="select * from kodegoldebitur order by KODE_GOL_DEBITUR asc ";
		$query=$this->db->query($sql);
		foreach($query->result_array() as $row){    
			$rows[] = $row; //add the fetched result to the result array;
		}
	   return $rows; // returning rows, not row
	}
	public function get_kode_metoda() {
		$rows = array(); //will hold all results
		$sql="select * from kodemetoda order by deskripsi_metoda asc ";
		$query=$this->db->query($sql);
		foreach($query->result_array() as $row){    
			$rows[] = $row; //add the fetched result to the result array;
		}
	   return $rows; // returning rows, not row
	}
	public function get_kode_hub_tab() {
		$rows = array(); //will hold all results
		$sql="select * from kodehubungantabungan order by KODE_HUBUNGAN asc ";
		$query=$this->db->query($sql);
		foreach($query->result_array() as $row){    
			$rows[] = $row; //add the fetched result to the result array;
		}
	   return $rows; // returning rows, not row
	}
	public function desk_prod_tabungan($kode) {
		$this->db->select ( 'SUKU_BUNGA_DEFAULT,ADM_PER_BLN_DEFAULT,PERIODE_ADM_DEFAULT,SETORAN_MINIMUM_DEFAULT,MINIMUM_DEFAULT,PPH_DEFAULT' );
		$this->db->from('kodejenistabungan');
		$this->db->where ( 'KODE_JENIS_TABUNGAN', $kode );
		$query = $this->db->get ();
		if($query->num_rows()== '1'){
			return $query->result ();
		}else{
			return false;
		}
	}
	function lastNoRek($kode){
		$query	= "select no_rekening from tabung where tgl_registrasi = (select max(tgl_registrasi) from tabung where jenis_tabungan='$kode')  order by no_rekening desc limit 1";
		$query=$this->db->query($query);
		if($query){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function get_data_nasabah2(){
		$rows = array(); //will hold all results
		$sql="select nasabah_id,nama_nasabah,alamat from nasabah order by nasabah_id asc ";
		$query=$this->db->query($sql);
		foreach($query->result_array() as $row){    
			$rows[] = $row; //add the fetched result to the result array;
		}
	   return $rows; // returning rows, not row
	}
	function get_data_nasabah3(){
		$this->db->select('nasabah_id', 'nama_nasabah','alamat');
		$this->db->order_by('nasabah_id', 'desc');
		$nasabah3 = $this->db->get('nasabah');
	
		if($nasabah3->num_rows() > 0){
			return $nasabah3->result_array();
		} else {
			return false;
		}
	}
	public function get_data_nasabah(){
		/*
		//aslinya
		$this->db->select ( 'nasabah_id,nama_nasabah,alamat' );
		$this->db->from ( 'nasabah' );
		$this->db->order_by ( 'nasabah_id','asc' );
		return $this->db->get ();
		*/
		/*
		$this->db->select ( 'nasabah_id,nama_nasabah,alamat' );
		$this->db->from ( 'nasabah' );
		$this->db->order_by ( 'nasabah_id','asc' );
		$this->db->where('nasabah_id',$nas_id);
		$query= $this->db->get ();
		return $query->result ();
		*/
		
		$rows = array(); //will hold all results
		$sql="select nasabah_id,nama_nasabah,alamat from nasabah order by nasabah_id asc ";
		$query=$this->db->query($sql);
		foreach($query->result_array() as $row){    
			$rows[] = $row; //add the fetched result to the result array;
		}
	   return $rows; // returning rows, not row
	   
	}
	function insert_tabungan($data){
	   $query=$this->db->insert('tabung',$data);
	   if($query){
	   	return true;
	   }else{
	   	return false;
	   }
	}
	function ajaxUpdateRekTab($data,$noRekTab){
		$query1 = $this->db->where('no_rekening', $noRekTab);
		$query2 = $this->db->update('tabung', $data);
		if($query1 && $query2){
			return true;
		}else{
			return false;
		}
	}
	function ajaxHapusRekTab($noRekTab){
		$query1	=	$this->db->where('no_rekening',$noRekTab);
		$query2	=   $this->db->delete('tabung');
		if($query1 && $query2){
			return true;
		}else{
			return false;
		}
	}
}

/* End of file master_nasabahmodel.php */
/* Location: ./application/models/master_nasabahmodel.php */