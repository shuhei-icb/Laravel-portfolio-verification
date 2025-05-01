<template>
  <footer class="bg-light text-dark py-4 mt-auto border-top">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-3">
          <h5>MyApp</h5>
          <p class="small">あなたの暮らしをもっと便利に。</p>
          <p class="small text-muted mb-0">&copy; 2025 MyCompany Inc.</p>
        </div>
        <div class="col-md-4 mb-3">
          <h6>メニュー</h6>
          <ul class="list-unstyled">
            <li><router-link class="text-decoration-none text-dark" to="/about">会社情報</router-link></li>
            <li><router-link class="text-decoration-none text-dark" to="/terms">利用規約</router-link></li>
            <li><router-link class="text-decoration-none text-dark" to="/privacy">プライバシーポリシー</router-link></li>
            <li><router-link class="text-decoration-none text-dark" to="/contact">お問い合わせ</router-link></li>
          </ul>
        </div>
        <div class="col-md-4 mb-3">
          <h6>フォローする</h6>
          <a href="https://twitter.com" target="_blank" class="text-dark me-3"><i class="bi bi-twitter"></i> Twitter</a><br />
          <a href="https://github.com" target="_blank" class="text-dark"><i class="bi bi-github"></i> GitHub</a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
// 特にロジックなし
</script>
