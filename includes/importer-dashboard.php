

<?php
echo "</br></br>";

global $table_prefix;
if(isset($_POST['users'])){
    $data="";
    if(isset($_FILES['userfile']['tmp_name']) && !empty($_FILES['userfile']['tmp_name'])) {
        if( $_FILES['userfile']['type']=="text/csv") {
         
            $file = fopen($_FILES['userfile']['tmp_name'], "r");
            $data = array();
            while (!feof($file)) {
                $data = array_merge($data, fgetcsv($file));
            }
            fclose($file);
            $data = implode(',', $data);
        }
        else{
            echo "<b style='color:red;' >File should be in .csv format :( </b></br> ";
        }
    }
    if ($_POST['users']!="" ){
        $data=$_POST['users'];
    }
    if($data==""){
        echo "<b style='color:red;' >No username found :(</b></br> ";
    }
    else if($_POST['groups']=="none" ){
        echo "<b style='color:red;' >Choose one Group :(</b></br> ";
    }
    else {
        $groupid = $_POST['groups'];
        $userarr = explode(',', $data);
      
        for($i=0;$i<sizeof($userarr);$i++){
          $idarr=get_user_id(trim($userarr[$i]));
          if(sizeof($idarr)==0){
              echo "<b style='color:red;' >".$userarr[$i]." is invalid username :( </b></br> ";
          }
          else{
            $id=$idarr[0][0];
            global $wpdb;
            $results2 = $wpdb->get_results( "insert into ".$table_prefix."_groups_user_group values (".$id.",".$groupid.")", ARRAY_N );
            echo "<b style='color:green;' >".$userarr[$i]." has been added :)</b></br> ";
          
          }

        }

    }
}

function get_user_id($username){
  global $wpdb;
  $results1 = $wpdb->get_results( "select ID from ".$table_prefix."_users where user_login='".$username."'", ARRAY_N );
  return $results1;              
}
?>




<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" name="user_form" id="user_form" enctype="multipart/form-data">
    <table width="1004" class="form-table">
      <tbody>
         <tr>
            <th><?php esc_html_e('User Names file:')?> </th>
             <td>
                <input type="file" name="userfile" id="userfile" accept=".csv" style="width:250px;"   />
            </td>
         </tr>
         <tr> <th>OR</th></tr>
         <tr>
              <th><?php esc_html_e('User Names:')?> </th>
              <td>
                <input type="text" name="users" value="" style="width:850px;"/>
              </td>
        </tr>
        <tr>
          <th width="115"><?php esc_html_e( 'Group Name:' )?></th>
              <td width="877">
                  <select  name="groups">
                      <?php
                      global $wpdb;
                      echo '<option value="none">Choose Group</option>';
                      $results = $wpdb->get_results( 'select name,group_id from '.$table_prefix.'_groups_group', ARRAY_N );
                      for($i=0;$i<sizeof($results);$i++){
                          $groupname=$results[$i][0];
                          $groupid=$results[$i][1];
                          echo '<option value="'.$groupid.'">'.$groupname.'</option>';
                      }
                      ?>
                  </select>
              </td>
        </tr>
        
        <tr>
          
          <td>
            <p class="submit">
              <input type="submit" class="button-primary" value = "Save Changes" name = "save_code" />
            </p>
          </td>
        </tr>
     
      </tbody>
    </table>
  </form>
