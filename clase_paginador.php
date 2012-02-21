<?php
class Paginator
    {
    var $items_per_page;
    var $items_total;
    var $current_page;
    var $num_pages;	
    var $low;
    var $limit;
    var $return;
    var $default_ipp;
    var $querystring;
    var $ipp_array;

    function Paginator()
        {
        $this->current_page = 1;		
        $this->ipp_array =array(10,15,20,25);
        $this->items_per_page = (!empty($_GET['ipp'])) ? $_GET['ipp']:$this->default_ipp;
        }

    function paginate()
        {
        if(!isset($this->default_ipp)) $this->default_ipp=$this->ipp_array[0];
        if($_GET['ipp'] == 'All')
            {
            $this->num_pages =$this->ipp_array[0];
            }
        else
            {
            if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0)
                {
                $this->items_per_page = $this->default_ipp;
                }
            $this->num_pages = ceil($this->items_total/$this->items_per_page);
            }
        $this->current_page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1 ;
        if($_GET)
            {
            $args = explode("&",$_SERVER['QUERY_STRING']);
            foreach($args as $arg)
                {
                $keyval = explode("=",$arg);
                if($keyval[0] != "page" And $keyval[0] != "ipp")
                    {
                    $this->querystring .= "&" . $arg;
                    }
                }
            }
        if($_POST)
            {
            foreach($_POST as $key=>$val)
                {
                if($key != "page" And $key != "ipp")
                    {
                    $this->querystring .= "&$key=$val";
                    }
                }
            }
        $this->low = ($this->current_page <= 0) ? 0:($this->current_page-1) * $this->items_per_page;
        if($this->current_page <= 0) $this->items_per_page = 0;
        $this->limit = ($_GET['ipp'] == 'All') ? "":" LIMIT $this->low,$this->items_per_page";
        }
        
    function display_items_per_page()
        {
        $items = '';                
        foreach($this->ipp_array as $ipp_opt) $items .= ($ipp_opt == $this->items_per_page)? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";
        return "<span>Nº de Registros por pagina: </span><select onchange=\"window.location='$_SERVER[PHP_SELF]?page=1&ipp='+this[this.selectedIndex].value+'$this->querystring';return false\">$items</select>\n";
        }
        
    function display_jump_menu()
        {
        $option='';
        for($i=1;$i<=$this->num_pages;$i++)
            {
            $option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";
            }
        return "<span>Paginas: </span><select onchange=\"window.location='$_SERVER[PHP_SELF]?page='+this[this.selectedIndex].value+'&ipp=$this->items_per_page$this->querystring';return false\">$option</select>\n";
        }
        
    function display_pages()
        {
        return $this->return;
        }
    }