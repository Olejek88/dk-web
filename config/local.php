<?php 
 $sqldriver="mysql";
 $is_bit=0;
 $is_2ip=0;
 $is_mee=0;
 $is_tekon=0;
 
 error_reporting (0);
 
 $mysql_host = "37.113.131.246";
 $mysql_user = "root";
 $mysql_password = "root88root";
 if ($_GET["obj"]=='') $_GET["obj"]='';

 if ($_GET["obj"]=='' || $_GET["obj"]=='1') 
    {
     $mysql_db_name = "es_cek_pa7"; 
     $is_bit=1; $is_2ip=1; $is_mee=1; $is_tekon=1;
    }
 if ($_GET["obj"]=='2') 
    {
     $mysql_db_name = "es_cek_v53";
     $is_bit=1; $is_2ip=1; $is_mee=1; $is_tekon=1;
    }
 if ($_GET["obj"]=='3') 
    {
     $mysql_db_name = "es_cek_gt59"; 
     $is_bit=1; $is_2ip=1; $is_mee=1; $is_tekon=1;
    }
 if ($_GET["obj"]=='4') 
    {
     $mysql_db_name = "es_cek_ro2"; 
     $is_bit=1; $is_2ip=0; $is_mee=0; $is_tekon=1;
    }
 if ($_GET["obj"]=='5') 
    {
     $mysql_db_name = "es_cek_elt51"; 
     $is_bit=1; $is_2ip=0; $is_mee=0; $is_tekon=1;
    }
 if ($_GET["obj"]=='6') 
    {
     $mysql_db_name = "es_msk_myt14"; 
     $is_bit=1; $is_2ip=1; $is_mee=0; $is_tekon=0;
    }
 if ($_GET["obj"]=='7') 
    {
     $mysql_db_name = "es_riga_dz22"; 
     $is_bit=1; $is_2ip=1; $is_mee=0; $is_tekon=1;
    }
 if ($_GET["obj"]=='8') 
    {
     $mysql_db_name = "es_cek_gt9"; 
     $is_bit=1; $is_2ip=0; $is_mee=0; $is_tekon=1;
    }
 if ($_GET["obj"]=='9') 
    {
     $mysql_db_name = "es_cek_el23"; 
     $is_bit=1; $is_2ip=0; $is_mee=0; $is_tekon=1;
    }
 if ($_GET["obj"]=='10') 
    {
     $mysql_db_name = "es_msk_mir1"; 
     $is_bit=1; $is_2ip=1; $is_mee=0; $is_tekon=0;
    }
 if ($_GET["obj"]=='11') 
    {
     $mysql_db_name = "es_msk_myt22"; 
     $is_bit=1; $is_2ip=1; $is_mee=0; $is_tekon=1;
    }
 if ($_GET["obj"]=='12') 
    {
     $mysql_db_name = "es_msk_myt23"; 
     $is_bit=1; $is_2ip=1; $is_mee=0; $is_tekon=1;
    }
 if ($_GET["obj"]=='14') 
    {
     $mysql_db_name = "es_msk_mir2"; 
     $is_bit=1; $is_2ip=1; $is_mee=0; $is_tekon=0;
    }
 if ($_GET["obj"]=='13') 
    {
     $mysql_db_name = "es_cek_el21"; 
     $is_bit=1; $is_2ip=0; $is_mee=0; $is_tekon=1;
    }
 if ($_GET["obj"]=='15') 
    {
     $mysql_db_name = "es_kog_rm56"; 
     $is_bit=1; $is_2ip=0; $is_mee=0; $is_tekon=1;
    }
 if ($_GET["obj"]=='16') 
    {
     $mysql_db_name = "es_kog_rm59"; 
     $is_bit=1; $is_2ip=0; $is_mee=0; $is_tekon=1;
    }
 if ($_GET["obj"]=='17') 
    {
     $mysql_db_name = "es_cek_el23_old"; 
     $is_bit=1; $is_2ip=0; $is_mee=0; $is_tekon=1;
    }
 if ($_GET["obj"]=='51') 
    {
     $mysql_db_name = "es_ufa_kot"; 
     $is_bit=0; $is_2ip=0; $is_mee=0; $is_tekon=1;
    }
 if ($_GET["obj"]=='50') 
    {
     $mysql_db_name = "es_vld_mal"; 
     $is_bit=1; $is_2ip=1; $is_mee=0; $is_tekon=0;
    }

?>