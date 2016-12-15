

<script src="<?php echo base_url(); ?>/ckeditor/ckeditor.js"></script>
<style>
    .morectnt span {

        display: none;

    }

</style>
<?php
foreach($post as $p) {

    ?>
    <div class="onepost" id="post_<?php echo $p->post_id; ?>" >
    <hr class="noscreen" />
    <div class="article" >

        <h2>
                    <div class="title" id="title_<?php echo $p->post_id; ?>" style="text-align: center" contenteditable="false">
                <?php echo $p->title; ?>
                    </div>
        </h2>
        <p class="info noprint"><span class="date"><?php echo $p->post_time; ?></span><span class="noscreen">,</span>
            <span class="cat"><a href="##" class="editable" id="<?php echo $p->post_id; ?>" >Editable</a></span>
            <span class="noscreen">,</span> <span class="user"><a
                    href="#"><?php
                    switch ($p->private){
                        case 0:echo("public");break;
                        case 1:echo("private");break;
                        case 2:echo("friends");break;
                    }
                    ?></a></span><span class="noscreen">,</span> <span id="<?php echo $p->post_id; ?>" class="delete_post_lnk"><a href="#">Delete</a></span>
        </p>

        <div class="show" id="show_<?php echo $p->post_id; ?>" contenteditable="false">
            <?php echo $p->content; ?>
        </div>

        </p>

<!--        <p class="btn-more box noprint"><strong><a href="#">Continue</a></strong></p>-->
    </div>
    <hr class="noscreen"/>
    </div>
    <?php
}?>

<script src="<?php echo base_url(); ?>/js/more-less/jquery.expander.js"></script>
<script type="text/javascript">
    var editor1;
    var editor2;
    var flag_for_readmore=1;
    $(document).ready(function() {

        //##### Send delete Ajax request to response.php #########
        $(".delete_post_lnk").click(function(e) {
            e.preventDefault();
            var postid = $(this).attr('id');

            //$('#post_'+postid).hide(); //change background of this element by adding class


            jQuery.ajax({
                type: "POST", // HTTP method POST or GET
                url: "<?php echo base_url() ?>index.php/page/delete_post", //Where to make Ajax calls
                dataType:"text", // Data type, HTML, json etc.
                data:{post_id:$(this).attr('id')}, //Form variables
                success:function(response){
                    //on success, hide  element user wants to delete.
                    $('#post_'+postid).fadeOut();
                },
                error:function (xhr, ajaxOptions, thrownError){
                    //On error, we alert user
                    alert(thrownError);
                }
            });
        });
        $(".editable").click(function (e) {
            var id=$(this).attr('id');
            if($(this).attr("class")=="editable"){
                $(this).attr("class","save");
                $(this).text("save");
                $('#title_'+id).attr("contenteditable","true");
                $('#show_'+id).attr("contenteditable","true");
                 CKEDITOR.disableAutoInline = true;
                 editor1=CKEDITOR.inline( 'title_'+id );
                 editor2=CKEDITOR.inline( 'show_'+id );
            }
            else{
                $this=$(this);
                $title=$('#title_'+id);
                $show=$('#show_'+id);
                jQuery.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "<?php echo base_url() ?>index.php/page/update_post", //Where to make Ajax calls
                    dataType:"text", // Data type, HTML, json etc.
                    data:{
                    post_id:id,
                    title:$('#title_'+id).html(),
                    content:$('#show_'+id).html()
                    }, //Form variables
                    success:function(response){
                        $this.attr("class","editable");
                        $this.text("editable");
                        $title.attr("contenteditable","false");
                        $show.attr("contenteditable","false");
                        editor1.destroy();
                        editor2.destroy();
                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        //On error, we alert user
                        alert(thrownError);
                    }
                });


            }

        });
/*Read more-read less
* */
        $('div.show_content').expander({
            slicePoint: 300, //It is the number of characters at which the contents will be sliced into two parts.
            widow: 2,
            expandSpeed: 0, // It is the time in second to show and hide the content.
            userCollapseText: '' // Specify your desired word default is Less.
        });

        $('div.show').expander();

    });

</script>
