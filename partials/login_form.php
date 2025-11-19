<h2>Login</h2>

<?php if (!empty($login_error)): ?>
  <div class="alert alert-danger">Username or Password is incorrect</div>
<?php endif; ?>

<!-- form to get login information, and then sets action to login when submitted -->
<form method="post">
  <div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" name="username" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control">
  </div>

  <input type="hidden" name="action" value="login">
  <button class="btn btn-primary">Login</button>
</form>

<p class="mt-3">Need an account? <a href="?view=register">Register</a></p>