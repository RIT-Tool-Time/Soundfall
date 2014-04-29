<div class="page-header">
    <h1><?php echo lang('tags_admin_title'); ?></h1>
</div>
<?php
if(isset($message))
{
    switch($message)
    {
        case 'fail':
            echo '<div class="alert alert-warning">'.lang('tags_fail').'</div>';
            break;
        case 'update_success':
            echo '<div class="alert alert-success">'.lang('tags_update_success').'</div>';
            break;
        case 'add_success':
            echo '<div class="alert alert-success">'.lang('tags_add_success').'</div>';
            break;
    }
}
?>
<?php if(count($tags) > 0): ?>
<table class="table table-condensed table-hover">
    <thead>
        <tr>
            <th><?php echo lang('tags_name'); ?></th>
            <th><?php echo anchor('', lang('tags_add'), array('class' => "btn btn-success")); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tags as $tag): ?>
        <tr>
            <?php echo form_open('admin/tags/update/', array('role' => 'form'), array('tag_id' => $tag->id)); ?>
            <th><?php echo form_input(array('class' => 'form-input', 'name' => 'tag_name'), $tag->name); ?></th>
            <th><?php echo form_submit(array('class' => 'btn btn-warning'), lang('tags_update')) ?></th>
            <?php echo form_close(); ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>