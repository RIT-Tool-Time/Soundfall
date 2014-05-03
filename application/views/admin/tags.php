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
echo validation_errors();

$add_form = form_open('admin/tags/create', array('role' => 'form', 'class' => 'form-inline'));
$add_form .= form_fieldset(lang('tags_add'));
$add_form .= form_input(array('class' => 'form-control', 'placeholder' => lang('tags_name'), 'name' => 'tag_name'));
$add_form .= form_submit(array('class' => 'btn btn-success'), lang('tags_add'));
$add_form .= form_fieldset_close();
$add_form .= form_close();
echo $add_form;

if(count($tags) > 0): ?>
<table class="table table-condensed table-hover">
    <thead>
        <tr>
            <th><?php echo lang('tags_name'); ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tags as $tag): ?>
        <tr>
            <?php echo form_open('admin/tags/update/', array('role' => 'form'), array('tag_id' => $tag->id)); ?>
            <th><?php echo form_input(array('class' => 'form-control', 'name' => 'tag_name'), $tag->name); ?></th>
            <th><?php echo form_submit(array('class' => 'btn btn-warning'), lang('tags_update')) ?></th>
            <?php echo form_close(); ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>