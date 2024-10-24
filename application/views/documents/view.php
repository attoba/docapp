
<br><br>
<h2><?php echo $document['title']; ?></h2>
    <small class="creation-date">created at: <?php echo $document['created_at']; ?></small><br>
    <?php echo $document['description']; ?>
    <br><hr>
    <?php echo form_open('/documents/delete/'.$document['id']); ?>
          <input type="submit" value="delete" class="btn btn-danger">
          <a class="btn btn-primary" href="<?php echo base_url(); ?>documents/edit/<?php echo $document['id']; ?>">Edit</a>