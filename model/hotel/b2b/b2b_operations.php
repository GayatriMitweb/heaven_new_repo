<?php
class b2b_operations{

    function search_session_save(){
        $_SESSION['hotel_array'] = json_encode($_POST['hotel_array']);
    }
}
?>