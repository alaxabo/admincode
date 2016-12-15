<script type="text/javascript">
    $(document).ready(function()
    {

        //khi thực hiện kích vào nút Login
        $("button").click(function()
        {
            if($(this).text()=='make friend') {
                $(this).text("friend");
            }
            if($(this).text()=='follow'){
                $(this).text("followed")
            }
            $(this).attr('disabled','disabled');
            //lay tat ca du lieu trong form
            //su dung ham $.ajax()
            $.ajax({
                type : 'POST', //kiểu post
                url  : '<?php echo base_url() ?>index.php/page/follow', //gửi dữ liệu sang trang submit.php
                data : {user_id:$(this).val()},
                success :  function(data)
                {
                }
            });
        });
    });
</script>
<table>
<?php
foreach ($users as $u){
    if($this->session->userdata['userid']==$u->user_id)continue;
?>
    <tr>
        <td><label><?php echo $u->user_name?></label></td>
        <td>
    <?php if($this->User->relationship($this->session->userdata['userid'],$u->user_id)==0){?>
    <button value="<?php echo $u->user_id?>">follow</button>
    <?php }?>
    <?php if($this->User->relationship($this->session->userdata['userid'],$u->user_id)==1){?>
        <button value="<?php echo $u->user_id?>">make friend</button>
    <?php }?>
    <?php if($this->User->relationship($this->session->userdata['userid'],$u->user_id)==10){?>
        <button value="<?php echo $u->user_id?>" disabled>followed</button>
    <?php }?>
    <?php if($this->User->relationship($this->session->userdata['userid'],$u->user_id)==11){?>
        <button value="<?php echo $u->user_id?>" disabled>friend</button>
    <?php }?>
        </td>
    </tr>
<?php
}
?>
</table>