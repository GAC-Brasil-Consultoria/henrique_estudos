<div class="form-group">
    <label class="form-control-label">Name</label>
    <input type="text" name="name" placeholder="enter full name" class="form-control" value="<?php echo esc($group->name) ?>">
</div>

<div class="form-group">
    <label class="form-control-label">Description</label>
    <textarea name="description" placeholder="Type the group access description" class="form-control" value><?php echo esc($group->description) ?>
    </textarea>
</div>

<div class="custom-control custom-checkbox">
    <input type="hidden" name="show" value="0">
    <input type="checkbox" name="show" value="1" class="custom-control-input" id="show" <?php if($group->show): ?>checked<?php endif; ?>>
    <label class="custom-control-label" for="show">Show group access</label><a tabindex="0" style="text-decoration: none;" role="button" data-toggle="popover"
                        data-trigger="hover" title="Important" data-content="If this group is defined as 
                        <b>Show group access</b> it will be shown as an option when defining 
                        <b>Technical Manager</b> for the Service Order">&nbsp;&nbsp;<i class="fa fa-question-circle fa-lg text-danger"></i></a>

</div>