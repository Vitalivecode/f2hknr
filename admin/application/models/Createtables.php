<?php 
class Createtables extends CI_Model{
	function __construct() {
		parent::__construct();
		$this->load->dbforge();
	}
	function tablecreate() {
			$tablename = $this->input->post('tablename');
			if($this->db->table_exists($tablename)) {
				return false;			
			}
			else {
				$this->dbforge->add_field('id');
				$attributes = array('ENGINE' => 'InnoDB');
				$this->dbforge->create_table($tablename, FALSE, $attributes);
				return true;
				}
							}
	function tableedit() {
			$oldtablename = lcfirst($this->uri->segment(3));
			$tablename = $this->input->post('tablename');
			if($this->db->table_exists($tablename)) {
				return false;			
			}
			else {
				$this->dbforge->rename_table($oldtablename, $tablename);
				return true;
				}
							}
	function rename_column() {
			$tablename = $this->input->post('tablename');
			if($this->db->table_exists($tablename)) {
			$columnname = $this->input->post('columnname');
			$rename = $this->input->post('rename');
			$type = $this->input->post('type');
			$lenght = $this->input->post('lenght');
					if(! $this->db->field_exists($rename , $tablename))
					{
						$fields[$columnname]['name'] = $rename;
						$fields[$columnname]['type'] = $type;
						$fields[$columnname]['constraint'] = $lenght;	
						$this->dbforge->modify_column($tablename , $fields);
						return true; 
					}
					else
						return false; 
				//print_r($fields);
				return true;
			}
			else 
				return false;
							}
	function edit_column() {
			$oldtablename = lcfirst($this->uri->segment(3));
			$tablename = $this->input->post('tablename');
			if($this->db->table_exists($tablename)) {
				$column = $this->input->post('column');
				$type = $this->input->post('type');
				$lenght = $this->input->post('lenght');
				$default = $this->input->post('default');
				$null = $this->input->post('null');
				$primary = $this->input->post('primary');
				$auto = $this->input->post('auto');
				$p = count($this->input->post('column'));
				for($i=0;$i<$p;$i++)
            	{
					$columns = $column[$i];
						if(!empty($lenght[$i])) {
							if($type[$i] == 'TEXT' || $type[$i] == 'MEDIUMTEXT' || $type[$i] == 'LONGTEXT')
								$lenghts = '';
							else if($lenght[$i] >= 255)
								$lenghts = 255;
							else
								$lenghts = $lenght[$i];
						}
						else {
							if($type[$i] == 'TEXT' || $type[$i] == 'MEDIUMTEXT' || $type[$i] == 'LONGTEXT')
								$lenghts = '';
							else
								$lenghts = 255;
						}
						if(!empty($null[$i]))
							$fields[$columns]['null'] = 'TRUE';
						else
							$fields[$columns]['null'] = 'FLASE';
						$fields[$columns]['type'] = $type[$i];
						$fields[$columns]['constraint'] = $lenghts;	
						if(!empty($primary[$i]))
							$this->dbforge->add_key(array($tablename , $columns));
						
						if(!empty($auto[$i]))
							$fields[$columns]['auto_increment'] = 'TRUE';
						else
							$fields[$columns]['auto_increment'] = 'FLASE';
						$this->dbforge->modify_column($tablename , $fields);
				}
				//print_r($fields);
				return true;
			}
			else 
				return false;
							}
	function add_column() {
			$tablename = $this->input->post('tablename');
			$column = $this->input->post('column');
			if($this->db->table_exists($tablename)) {
				if (! $this->db->field_exists($column, $tablename))
				{
					$column = $this->input->post('column');
					$position = $this->input->post('position');
					$type = $this->input->post('type');
					$lenght = $this->input->post('lenght');
					$default = $this->input->post('default');
					$null = $this->input->post('null');
					$primary = $this->input->post('primary');
					$auto = $this->input->post('auto');
						$columns = $column;
						if(!empty($lenght)) {
							if($type == 'TEXT' || $type == 'MEDIUMTEXT' || $type == 'LONGTEXT')
								$lenghts = '';
							else if($lenght >= 255)
								$lenghts = 255;
							else
								$lenghts = $lenght;
						}
						else {
							if($type == 'TEXT' || $type == 'MEDIUMTEXT' || $type == 'LONGTEXT')
								$lenghts = '';
							else
								$lenghts = 255;
						}
						if($position == 'first')
							$fields[$columns]['first'] = 'TRUE';
						else
							$fields[$columns]['after'] = $position;
						$fields[$columns]['type'] = $type;
						$fields[$columns]['constraint'] = $lenghts;	
						if(!empty($auto)) {
							$fields[$columns]['unsigned'] = 'TRUE';
							$fields[$columns]['auto_increment'] = 'TRUE'; }
						else
							$fields[$columns]['auto_increment'] = 'FLASE';
						if(!empty($null))
							$fields[$columns]['null'] = 'TRUE';
						else
							$fields[$columns]['null'] = 'FLASE';
						$this->dbforge->add_column($tablename , $fields);
						if(!empty($primary))
							$this->dbforge->add_key(array($tablename , $columns));
					//print_r($fields);
					return true;
				}
				else
					return false;
			}
			else 
				return false;
							}
	function tabledelete($tname) {
			$this->db->select("cid");
			$this->db->from("create_table");
			$this->db->where("table_name",$tname);
			$query = $this->db->get();
			if ($query->num_rows() > 0)
			{
				$tid = $query->result_array()[0]['cid'];
				$changeType = array('tid' => $tid);
				$this->db->delete('change_type',$changeType);
			}
			$delete = array('table_name' => $tname);
			$this->db->delete('menu',$delete);
			$this->db->delete('create_table',$delete);
			$this->dbforge->drop_table($tname,TRUE);
	}
	function columndelete($tname,$column) {
			if(count($this->db->list_fields($tname))>1){
				$this->dbforge->drop_column($tname , $column);
				return true ;
			}
			else {
				$this->dbforge->drop_table($tname,TRUE);
				return false; 
			}
	}
    
}

?>
