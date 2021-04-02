<?php
class b2b_operations{

    function search_session_save(){
        $_SESSION['pick_drop_array'] = json_encode($_POST['pick_drop_array']);
    }
}
?>