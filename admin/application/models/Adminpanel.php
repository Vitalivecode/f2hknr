<?php class Adminpanel extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	function settings() {
             $this->db->select('s.theme, s.button, s.title, s.logo, s.favicon, s.menu, s.loginbg, s.sentmail, s.footer_left, s.footer_right, s.display, s.maintenance, s.ipaddress, s.display_errors, c.c_links, c.css, j.j_links, j.js');
			 $this->db->from('settings s, css c, js j');
			$query = $this->db->get();
			if ($query->num_rows() > 0)
			{
				$result = $query->result();
				return $result;
			}
			else
			{
				return false;
			}
							}
    function update_theme($theme) {
        $this->db->update('settings',$theme);
        return true;
    }
    function update_menu($menu) {
        $this->db->update('settings',$menu);
        return true;
    }
    function update_css($css) {
        $this->db->update('css',$css);
        return true;
    }
    function update_js($js) {
        $this->db->update('js',$js);
        return true;
    }
    function update($updatedata) {
			$this->db->update('settings', $updatedata);
			return true;
							}
	function visit_count() {
			$query = $this->db->get('admin_sessions');
			return $query->result();
    }
    function visit($limit, $start) {
			$this->db->order_by('id','desc');
			$query = $this->db->get('admin_sessions', $limit, $start);
			return $query->result();
	}
	function online($id) {
			$userdata = array('user_data' => '');
			$this->db->where('id', $id);
			$this->db->update('admin_sessions', $userdata);
			return true;
    }
	function block($id) {
			$block = array('block' => 'active');
			$this->db->where('id', $id);
			$this->db->update('admin_sessions', $block);
			return true;
    }
	function inblock($id) {
			$inblock = array('block' => 'inactive');
			$this->db->where('id', $id);
			$this->db->update('admin_sessions', $inblock);
			return true;
    }
	function tables() {
			$this->db->order_by('menu_order','asc');
			$query = $this->db->get('create_table');
			return $query->result();
	}
    function createtable() {
			$this->db->select('name as cttitle,table_name,parent_id,child_id,icon,menu_order');
			$this->db->order_by('menu_order','asc');
			$this->db->from('menu');
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				$results = $query->result();
				return $results;
			}
			else
			{
				return false;
			}
							}
    function get_tables() {
			$result = $this->db->list_tables();
			return $result;
							}
    function gettable($table) {
			$this->db->select('cttitle');
			$this->db->where('table_name',$table);
			$query = $this->db->get('create_table');
			if($query->num_rows() > 0)
			{
				$results = $query->result();
				return $results;
			}
			else
			{
				$results = array((object)['cttitle' => 'empty']);
				return $results;
			}
							}
    
    function insert($insert) {
            $table = $insert['table_name'];
            $this->db->select('table_name');
            $this->db->from('create_table');
            $this->db->where('table_name',$table);
			$query = $this->db->get();
			if ($query->num_rows() == 0)
			{
				$query = $this->db->insert('create_table',$insert);
				$this->db->select_max('menu_order');
				$query = $this->db->get('menu');
				$menu = array(
						"name" => $insert['cttitle'],
						"table_name" => $insert['table_name'],
						"icon" => $insert['icon'],
						"menu_order" => $query->result()[0]->menu_order+1,
						);
				$this->db->insert('menu',$menu);
			    return true;
			}
			else
			{
				return false;
			}
							}
    function delete($tname) {
			$this->db->select('cid');
            $this->db->from('create_table');
            $this->db->where('table_name',$tname);
			$query = $this->db->get();
			if ($query->num_rows() > 0)
			{
				$row = $query->row();
				$cid = $row->cid;
                $ctname = array('table_name' => $tname);
				$this->db->delete('create_table',$ctname);
				$this->db->delete('change_type',array('tid' => $cid));
				$this->db->delete('menu',$ctname);
				return true;
			}
			else
			{
				return false;
			}
							}
    function createtable_edit($tname) {
            $this->db->from('create_table');
            $this->db->where('table_name',$tname);
            $query = $this->db->get();
			if ($query->num_rows() == 1)
			{
			    return $query->result();
			}
			else
			{
				return false;
			}
							}
    function createtable_edit_update($id,$update) {
			$tablename = $update['table_name'];
            $this->db->from('create_table');
            $this->db->where_not_in('cid',$id);
			$this->db->where('table_name',$tablename);
			$query = $this->db->get();
			if ($query->num_rows() != 1)
			{
				$this->db->from('create_table');
				$this->db->where('cid',$id);
				$query = $this->db->get();
				if ($query->num_rows() == 1)
				{
					$this->db->where('cid',$id);
					$this->db->update('create_table',$update);
					$menu = array(
						"name" => $update['cttitle'],
						"icon" => $update['icon'],
						);
					$this->db->where('table_name',$tablename);
					$this->db->update('menu',$menu);
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
							}
    function perm($table) {
            $this->db->select('*');
            $this->db->from('create_table');
            $this->db->where('table_name',$table);
			$query = $this->db->get();
			if ($query->num_rows() > 0)
			{
				$result = $query->result_array();
				return $result;
			}
			else
			{
				return false;
			}
							}
    
    function manage($tname) {
			$result = $this->db->list_fields($tname);
            return $result;
							}
    function mnge($cid) {
            $this->db->select('changetype');
            $this->db->from('change_type');
            $this->db->where('tid',$cid);
			$query = $this->db->get();
			if ($query->num_rows() > 0)
			{
				$result = $query->result_array();
				return $result;
			}
			else
			{
				return false;
			}
							}
    function createtable_manage_update($tname,$update) {
            $this->db->from('create_table');
            $this->db->where('table_name',$tname);
			$query = $this->db->get();
			if ($query->num_rows() == 1)
			{
                $this->db->where('table_name',$tname);
				$this->db->update('create_table',$update);
				return true;
			}
			else
			{
				return false;
			}
							}
    function changetype($insert) {
            $this->db->from('change_type');
            $this->db->where('colname',$insert['colname']);
            $this->db->where('tid',$insert['tid']);
            $query = $this->db->get();
			if ($query->num_rows() == 1)
			{
                $this->db->where('colname',$insert['colname']);
				$this->db->where('tid',$insert['tid']);
                $this->db->update('change_type',$insert);
            }
            else
				$query = $this->db->insert('change_type',$insert);
            return true;
	}
    function insertMenu() {
            $this->db->from('menu');
            $this->db->where('name',$_POST['parent']);
            $query = $this->db->get();
			if ($query->num_rows() == 1)
			{
                return false;
            }
            else
			{
				$this->db->select_max('menu_order');
				$query = $this->db->get('menu');
				$insert = array("name" => $_POST['parent'], "menu_order" => $query->result()[0]->menu_order+1,);
				$query = $this->db->insert('menu',$insert);
				return true;
			}
	}
    function editMenu($parent_id) {
            $this->db->from('menu');
            $this->db->where('parent_id',$parent_id);
            $query = $this->db->get();
			if ($query->num_rows() == 1)
			{
                $result = $query->result();
				return $result;
            }
            else
			{
				return false;
			}
	}
    function updateMenu($parent_id) {
            $this->db->from('menu');
			if(isset($_POST['parent']))
				$this->db->where('name',$_POST['parent']);
            $this->db->where_not_in('parent_id',$parent_id);
            $query = $this->db->get();
			if ($query->num_rows() == 0)
			{
				$update = array("menu_order" => $this->input->post('position'), 'child_id' => $this->input->post('child_id'),);
				if(isset($_POST['parent']))
					$update['name'] = $this->input->post('parent');
				$this->db->where('parent_id',$parent_id);
				$query = $this->db->update('menu',$update);
                return true;
            }
            else
			{
				
				return false;
			}
	}
    function childMenu($parent_id) {
            $this->db->from('menu');
            $this->db->where('child_id',$parent_id);
			$this->db->order_by('menu_order','asc');
            $query = $this->db->get();
			if ($query->num_rows() > 0)
			{
                $result = $query->result();
				return $result;
            }
            else
			{
				return false;
			}
	}
    function previousdata() {
			$this->db->select('changetype');
            $this->db->from('change_type');
            $this->db->where('tid',$_POST['tableid']);
            $this->db->where('colname',$_POST['colname']);
            $query = $this->db->get();
			if ($query->num_rows() == 1)
			{
				$results = $query->result_array()[0]['changetype'];
                return $results;
            }
            else
			{
				return false;
			}
	}
    function menuDelete($parent_id) {
			$this->db->select('child_id');
            $this->db->from('menu');
            $this->db->where('child_id',$parent_id);
            $query = $this->db->get();
			if ($query->num_rows() > 0)
			{
				$update = array("child_id" => "0");
				$this->db->where('child_id',$parent_id);
				$this->db->update('menu',$update);
				$delete = array('parent_id' => $parent_id);
				$this->db->delete('menu',$delete);
            }
            else
			{
				$delete = array('parent_id' => $parent_id);
				$this->db->delete('menu',$delete);
			}
	}
    function getTableType($val)
    {
            $this->db->select('table_type');
            $this->db->where('table_name',$val);
            $this->db->from('create_table');
            $query = $this->db->get();
            if ($query->num_rows() > 0)
			{
			    $result = $query->result();
				return $result;
            }
            else
			{
				return false;
			}
    }
}

?>
