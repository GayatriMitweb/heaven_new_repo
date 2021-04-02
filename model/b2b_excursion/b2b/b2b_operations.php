<?php
class b2b_operations{

    function search_session_save(){
        $_SESSION['activity_array'] = json_encode($_POST['activity_array']);
    }
}
?>