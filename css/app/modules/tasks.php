<?php 
header("Content-type: text/css");

?>
#div_tasks_list .tasks_item{
    padding: 10px 5px 15px 5px;
    border-bottom: 1px solid #ddd;
}
#div_tasks_list .tasks_item:hover{
	background: #f5f5f5;
}

#div_tasks_list .task_content{
    border-left: 4px solid #b7b7b7;
    padding-left: 15px;
    font-size: 16px;
}
#div_tasks_list .content_footer ul{
	margin:0;
	padding:0;
}
#div_tasks_list .content_footer li{
    list-style-type: none;
    display: inline-block;
    border-right: 1px solid #c5c3c3;
    padding: 0 5px;
    color: #8a8a8a;
    font-size: 13px;
}
#div_tasks_list .content_footer li:last-child{
	border-right: 0;
}

#div_tasks_list .tasks_item.created .task_content{
	border-left: 4px solid #33b5e5;
}
#div_tasks_list .tasks_item.danger .task_content{
	border-left: 4px solid #ff5b5b;
}
#div_tasks_list .tasks_item.warning .task_content{
    border-left: 4px solid #ffff00;
}
#div_tasks_list .tasks_item.completed .task_content{
	border-left: 4px solid #449d44;
}

.tasks_item i {
    border-radius: 50%;
    height: 32px;
    width: 32px;
    text-align: center;
    line-height: 32px;
    background: transparent;
    color: #009898;
    transition: 0.5s;
    font-size: 16px;
}
.tasks_item i:hover{
    background: #009898;
    color: #fff;
}