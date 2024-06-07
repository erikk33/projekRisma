<section class="container">
    <div class="login-container">
        <div class="circle circle-one"></div>
        <div class="form-container">
            <img src="https://raw.githubusercontent.com/hicodersofficial/glassmorphism-login-form/master/assets/illustration.png" alt="illustration" class="illustration" />
            <h1 class="opacity">REGISTER</h1>
            <?php if (!empty($message)): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form action="index.php?page=register" method="POST">
                <input type="text" name="username" placeholder="USERNAME" required />
                <input type="password" name="password" placeholder="PASSWORD" required />
                <button class="opacity">SUBMIT</button>
            </form>
            <div class="register-forget opacity">
                <a href="index.php?page=login">LOGIN</a>
                <a href="#">FORGOT PASSWORD</a>
            </div>
        </div>
        <div class="circle circle-two"></div>
    </div>
    <div class="theme-btn-container"></div>
</section>
