
<div class='message'>
<?php
if (isset($message)) {
    echo "<div class='message'>";
    echo $message;
    echo "</div>";
}
?>
</div>
<div id="write_post">
 <?php echo form_open('page/post'); ?>
      <span class="label label-default">Share</span>
        <select name="private">
        <option value="0">Pulic</option>
        <option value="1">Private</option>
        <option value="2">Friends</option>
      </select>
        <br>
        <span class="label label-default">Title</span>
        <br>
       <input type="text" name="title" placeholder="Title" required />
        <br><br>
        <span class="label label-default">Content</span>
        <textarea class="ckeditor" name="content" cols="80" rows="100" required>
        </textarea>
        <input type="hidden" name="userid" value="<?php echo $this->session->userdata('userid');?>">
        <input type="submit" value="POST" name="submit"/>

     <?php echo form_close(); ?>
   <script>

          // Replace the <textarea id="editor1"> with an CKEditor
          // instance, using default configurations.
          CKEDITOR.replace( 'editor1', {
              uiColor: '#14B8C4',
              toolbar: [
                  [ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ],
                  [ 'FontSize', 'TextColor', 'BGColor' ]
              ]
          });

      </script>
      <br>
</div>