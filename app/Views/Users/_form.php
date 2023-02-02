<div class="form-group">
    <label class="form-control-label">Name</label>
    <input type="text" name="name" placeholder="enter full name" class="form-control" value="<?php echo esc($user->name) ?>">
</div>

<div class="form-group">
    <label class="form-control-label">Email</label>
    <input type="email" placeholder="Email Address" class="form-control">
</div>

<div class="form-group">       
    <label class="form-control-label">Password</label>
    <input type="password" name="password" placeholder="Password" class="form-control">
</div>

<div class="form-group">       
    <label class="form-control-label">Password confirmation</label>
    <input type="password" name="password" placeholder="Password confirmation" class="form-control">
</div>

<div class="custom-control custom-checkbox">
    <input type="hidden" name="active" value="0">
    <input type="checkbox" name="active" value="1" class="custom-control-input" id="active" <?php if($user->active): ?>checked<?php endif; ?>>
    <label class="custom-control-label" for="active">User active</label>
</div>