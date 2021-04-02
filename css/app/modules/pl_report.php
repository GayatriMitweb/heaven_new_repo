<?php 
header("Content-type: text/css");
?>

.panel-default .panel-heading {
    background-color: #eaeaea;
}
.panel-heading strong {
    color: #333;
    font-size: 18px;
    font-weight: 400;
}

.list_heading {
    background: #f7f7f7;
    padding: 10px 15px;
    font-size: 16px;
}
.list_heading h4{
    font-size: 17px;
    font-weight: 400;
}
.list_heading_count{
    font-weight: 500;
}

.part_heading {
    background: #fff;
    border-bottom: 1px dashed #e6e6e6;
}
.part_heading h4 {
    padding: 10px 15px;
    font-size: 14px;
    font-weight: 400;
}
.part_heading a{
    text-decoration:none !important;
    color: #717171;
    font-size: 10px;
    margin-right: 8px;
}

.part_entry {
    background: #ffffff !important;
    font-size: 13px;
    padding: 10px 15px;
    border-radius: 0 !important;
}
.part_entry_m_count {
    font-weight: 500;
}

.panel-body.less_text {
    padding: 7px 15px;
}

.result_entry_block {
    background: #ebebeb;
    font-size: 13px;
    padding: 10px 15px;
    height: 38px;
}
.result_entry_text {
    font-style: italic;
}


.quadrant.main_block {
    height: 645px;
    overflow-y: scroll;
    background : #ffffff;
}

/* Table Scrollbar */
.quadrant::-webkit-scrollbar {
    height: 1px;
    width: 5px;
}
.quadrant::-webkit-scrollbar-track {
      background-color: #b3b3b3;
} /* the new scrollbar will have a flat appearance with the set background color */
 
.quadrant::-webkit-scrollbar-thumb {
      background-color: #ececec; 
} /* this will style the thumb, ignoring the track */
 
.quadrant::-webkit-scrollbar-button {
      background-color: #000;
      width:5px;
      height: 0px;
} /* optionally, you can style the top and the bottom buttons (left and right for horizontal bars) */
 
.quadrant::-webkit-scrollbar-corner {
      background-color: black;
      border-radius:25px;
}

.panel-footer strong {
    font-weight: 500;
    color: #333;
}