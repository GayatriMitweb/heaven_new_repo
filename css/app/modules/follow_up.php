<?php 
header("Content-type: text/css");

?>

ul.color_identity li {
    display: inline-block;
    min-width: 90px;
    font-size: 15px;
    font-weight: 300;
    line-height: 30px;
    list-style-type: none;
}
ul.color_identity li span {
    display: inline-block;
}
ul.color_identity li span.identity_color {
    width: 15px;
    height: 15px;
    margin-right: 2px;
    border-radius: 50%;
    margin-bottom: -2px;
}
ul.color_identity li span.identity_color.cold, ul.followup_entries li.Cold:after{
    background: #7cc7ec;
}
ul.color_identity li span.identity_color.hot, ul.followup_entries li.Hot:after{
    background: #f2e187;
}
ul.color_identity li span.identity_color.strong, ul.followup_entries li.Strong:after{
    background: #98ee75;
}


ul.followup_entries li {
    list-style-type: none;
    position: relative;
}
ul.followup_entries li:after {
    position: absolute;
    content: '';
    height: 25px;
    width: 25px;
    left: -40px;
    border-radius: 50%;
}
ul.followup_entries li:before {
    position: absolute;
    content: '';
    width: 1px;
    height: 100%;
    border-left: 1px dashed #ababab;
    left: -28px;
    top: 0;
}
ul.followup_entries li:last-child:before {
    display:none !important;
}
.single_folloup_entry {
    border: 1px solid #f5f5f5;
    border-radius: 3px;
    overflow: hidden;
}
.single_folloup_entry .entry_detail {
    background: #f5f5f5;
    padding: 10px 0 10px 15px;
    font-size: 14px;
    text-transform: capitalize;
    font-weight: 400;
    color: #009898;
    min-height: 40px;
}
.single_folloup_entry .entry_discussion {
    padding: 10px 15px;
}
.single_folloup_entry .entry_discussion p {
    margin: 0;
}
ul.followup_entries li:last-child .single_folloup_entry.mg_bt_20 {
    margin-bottom: 5px;
}
