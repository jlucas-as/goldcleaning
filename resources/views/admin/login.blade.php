<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Entrar no painel | Gold Cleaning</title>
    <style>
        :root { color-scheme:light; --gold:#b88928; --gold-dark:#8b641d; --ink:#171a1f; --muted:#667085; --line:#dfe4ea; --soft:#f5f7fa; --danger:#b42318; }
        * { box-sizing:border-box; }
        html, body { min-height:100%; }
        body { margin:0; padding:20px; background:#edf1f5; color:var(--ink); font-family:Inter,Arial,sans-serif; }
        button, input { font:inherit; }
        .login-shell { width:min(1500px,100%); min-height:calc(100vh - 40px); margin:0 auto; display:grid; grid-template-columns:minmax(420px, .9fr) minmax(520px, 1.35fr); overflow:hidden; border-radius:24px; background:#fff; box-shadow:0 22px 70px rgba(24,31,45,.12); }
        .visual { position:relative; display:flex; flex-direction:column; min-height:680px; padding:54px 64px; overflow:hidden; color:#fff; background:#11151c url('{{ url('public/img/hero-clean.webp') }}') center/cover no-repeat; isolation:isolate; }
        .visual::before { content:""; position:absolute; inset:0; z-index:-2; background:linear-gradient(145deg,rgba(8,12,19,.97) 5%,rgba(18,22,30,.9) 50%,rgba(105,75,18,.76)); }
        .visual::after { content:""; position:absolute; z-index:-1; width:540px; height:540px; right:-250px; bottom:-260px; border:1px solid rgba(212,177,101,.28); border-radius:50%; box-shadow:0 0 0 90px rgba(184,137,40,.04),0 0 0 180px rgba(184,137,40,.035); }
        .brand { display:inline-flex; align-items:center; width:fit-content; padding:13px 16px; border-radius:8px; background:rgb(254 254 254); }
        .brand img { width:190px; height:auto; display:block; }
        .visual-copy { max-width:570px; margin:auto 0; padding:72px 0 48px; }
        .eyebrow { display:flex; align-items:center; gap:12px; margin:0 0 22px; color:#e4c781; font-size:12px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }
        .eyebrow::before { content:""; width:34px; height:1px; background:currentColor; }
        .visual h1 { margin:0; font-family:Georgia,serif; font-size:clamp(45px,4.2vw,72px); line-height:1.06; letter-spacing:0; }
        .visual h1 span { display:block; color:#e3bf69; }
        .visual-copy > p { max-width:510px; margin:24px 0 0; color:#e5e7eb; font-size:17px; line-height:1.7; }
        .benefits { display:flex; flex-wrap:wrap; gap:10px; margin-top:30px; }
        .benefit { display:flex; align-items:center; gap:8px; padding:9px 12px; border:1px solid rgba(255,255,255,.17); border-radius:999px; background:rgba(255,255,255,.07); color:#f4f4f5; font-size:12px; font-weight:700; }
        .benefit svg { width:15px; height:15px; color:#e3bf69; }
        .visual-footer { color:#cbd1da; font-size:12px; }
        .form-side { position:relative; display:grid; place-items:center; padding:64px; background:radial-gradient(circle at 100% 0, #f3f6fa 0, transparent 35%),#fff; }
        .back-home { position:absolute; top:32px; right:36px; display:inline-flex; align-items:center; gap:8px; color:#657083; text-decoration:none; font-size:13px; font-weight:700; }
        .back-home:hover { color:var(--gold-dark); }
        .form-wrap { width:min(100%,520px); }
        .form-kicker { margin:0 0 13px; color:var(--gold-dark); font-size:12px; font-weight:900; letter-spacing:.14em; text-transform:uppercase; }
        h2 { margin:0; font-size:39px; line-height:1.15; letter-spacing:0; }
        .intro { margin:10px 0 34px; color:var(--muted); line-height:1.55; }
        .notice { margin:0 0 20px; padding:12px 14px; border:1px solid; border-radius:8px; font-size:14px; line-height:1.45; }
        .notice.error { border-color:#fecdca; background:#fef3f2; color:var(--danger); }
        .notice.success { border-color:#abefc6; background:#ecfdf3; color:#027a48; }
        .field { margin-bottom:20px; }
        label { display:flex; justify-content:space-between; align-items:center; gap:15px; margin-bottom:8px; font-size:13px; font-weight:800; }
        .field-control { position:relative; }
        .field-control > svg { position:absolute; left:16px; top:50%; width:19px; height:19px; color:#98a2b3; transform:translateY(-50%); pointer-events:none; }
        input { width:100%; height:54px; padding:0 48px; border:1px solid var(--line); border-radius:8px; outline:none; background:var(--soft); color:var(--ink); transition:border-color .2s,box-shadow .2s,background .2s; }
        input::placeholder { color:#98a2b3; }
        input:focus { border-color:var(--gold); background:#fff; box-shadow:0 0 0 4px rgba(184,137,40,.12); }
        .password-toggle { position:absolute; right:8px; top:50%; width:40px; height:40px; display:grid; place-items:center; padding:0; border:0; border-radius:7px; background:transparent; color:#8590a3; cursor:pointer; transform:translateY(-50%); }
        .password-toggle:hover { background:#e9edf2; color:#394150; }
        .password-toggle svg { width:19px; height:19px; }
        .submit { width:100%; min-height:54px; margin-top:8px; display:flex; align-items:center; justify-content:center; gap:10px; border:0; border-radius:8px; background:var(--gold); box-shadow:0 12px 26px rgba(184,137,40,.24); color:#fff; font-weight:900; cursor:pointer; transition:background .2s,transform .2s; }
        .submit:hover { background:var(--gold-dark); transform:translateY(-1px); }
        .submit svg { width:18px; height:18px; }
        .help { margin:22px 0 0; text-align:center; color:var(--muted); font-size:13px; line-height:1.6; }
        .secure { position:absolute; bottom:30px; display:flex; align-items:center; gap:7px; color:#7b8494; font-size:12px; }
        .secure svg { width:14px; height:14px; }
        @media (max-width:980px) {
            body { padding:0; background:#fff; }
            .login-shell { min-height:100vh; grid-template-columns:1fr; border-radius:0; box-shadow:none; }
            .visual { min-height:280px; padding:28px 32px; }
            .brand img { width:155px; }
            .visual-copy { margin:42px 0 0; padding:0; }
            .visual h1 { font-size:42px; }
            .visual-copy > p,.benefits,.visual-footer { display:none; }
            .form-side { padding:64px 28px 80px; place-items:start center; }
            .back-home { top:24px; right:28px; }
            .secure { bottom:24px; }
        }
        @media (max-width:540px) {
            .visual { min-height:225px; padding:22px; }
            .visual-copy { margin-top:30px; }
            .eyebrow { margin-bottom:13px; font-size:10px; }
            .visual h1 { max-width:340px; font-size:34px; }
            .form-side { padding:56px 20px 72px; }
            .back-home { top:20px; right:20px; }
            h2 { font-size:31px; }
            .intro { margin-bottom:26px; }
        }
    </style>
</head>
<body>
    <main class="login-shell">
        <section class="visual" aria-label="Gold Cleaning">
            <a class="brand" href="{{ url('/') }}" aria-label="Voltar para o site">
                <img src="{{ url('public/img/logo.png') }}" alt="Gold Cleaning">
            </a>

            <div class="visual-copy">
                <p class="eyebrow">Gestao simples e organizada</p>
                <h1>Seu site em ordem. <span>Seu conteudo no controle.</span></h1>
                <p>Acesse o painel para atualizar paginas, servicos, areas atendidas e resultados de antes e depois.</p>
                <div class="benefits" aria-label="Recursos do painel">
                    <span class="benefit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="m9 12 2 2 4-4"/></svg>Acesso protegido</span>
                    <span class="benefit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>Edicao visual</span>
                    <span class="benefit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18M9 21V9"/></svg>Tudo em um lugar</span>
                </div>
            </div>

            <div class="visual-footer">Gold Cleaning &copy; {{ date('Y') }}</div>
        </section>

        <section class="form-side">
            <a class="back-home" href="{{ url('/') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                Voltar ao site
            </a>

            <div class="form-wrap">
                <p class="form-kicker">Painel administrativo</p>
                <h2>Bem-vindo de volta.</h2>
                <p class="intro">Entre com seus dados para gerenciar o conteudo do site.</p>

                @if ($error)
                    <div class="notice error" role="alert">{{ $error }}</div>
                @elseif ($credentialsMissing)
                    <div class="notice error" role="alert">Configure ADMIN_USERNAME e ADMIN_PASSWORD no arquivo .env antes de entrar.</div>
                @elseif ($loggedOut)
                    <div class="notice success" role="status">Voce saiu do painel com seguranca.</div>
                @elseif ($expired)
                    <div class="notice error" role="alert">Sua sessao expirou. Entre novamente para continuar.</div>
                @endif

                <form method="post" action="{{ url('/admin/login') }}">
                    <input type="hidden" name="_token" value="{{ $csrfToken }}">

                    <div class="field">
                        <label for="username">Usuario</label>
                        <div class="field-control">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
                            <input id="username" name="username" value="{{ $username }}" autocomplete="username" placeholder="Digite seu usuario" required autofocus>
                        </div>
                    </div>

                    <div class="field">
                        <label for="password">Senha</label>
                        <div class="field-control">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Digite sua senha" required>
                            <button class="password-toggle" type="button" aria-label="Mostrar senha" aria-pressed="false" data-password-toggle>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.1 12a11 11 0 0 1 19.8 0 11 11 0 0 1-19.8 0Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>

                    <button class="submit" type="submit" @if ($credentialsMissing) disabled @endif>
                        Entrar no painel
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </button>
                </form>

                <p class="help">O acesso e exclusivo para administradores da Gold Cleaning.</p>
            </div>

            <div class="secure">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Ambiente administrativo protegido
            </div>
        </section>
    </main>

    <script>
        const toggle = document.querySelector('[data-password-toggle]');
        const password = document.querySelector('#password');

        toggle?.addEventListener('click', () => {
            const revealing = password.type === 'password';
            password.type = revealing ? 'text' : 'password';
            toggle.setAttribute('aria-pressed', String(revealing));
            toggle.setAttribute('aria-label', revealing ? 'Ocultar senha' : 'Mostrar senha');
        });
    </script>
</body>
</html>
