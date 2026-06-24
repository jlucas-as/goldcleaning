<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Painel Admin | Gold Cleaning</title>
    <style>
        :root { color-scheme: light; --gold: #b88928; --ink: #1f2933; --muted: #667085; --line: #e4e7ec; --bg: #f6f7f9; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: var(--bg); color: var(--ink); }
        header { background: #fff; border-bottom: 1px solid var(--line); padding: 18px 24px; display: flex; justify-content: space-between; gap: 16px; align-items: center; }
        main { max-width: 1120px; margin: 0 auto; padding: 24px; }
        h1 { margin: 0; font-size: 24px; }
        p { color: var(--muted); line-height: 1.5; }
        .panel { background: #fff; border: 1px solid var(--line); border-radius: 8px; padding: 18px; }
        textarea { width: 100%; min-height: 68vh; resize: vertical; border: 1px solid var(--line); border-radius: 8px; padding: 14px; font: 14px/1.5 Consolas, monospace; }
        .actions { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-top: 14px; flex-wrap: wrap; }
        .btn { appearance: none; border: 1px solid var(--gold); background: var(--gold); color: #fff; border-radius: 6px; padding: 11px 16px; font-weight: 700; cursor: pointer; text-decoration: none; }
        .btn.secondary { background: #fff; color: var(--ink); border-color: var(--line); }
        .notice { border-radius: 8px; padding: 12px 14px; margin-bottom: 14px; }
        .success { background: #ecfdf3; color: #027a48; border: 1px solid #abefc6; }
        .error { background: #fef3f2; color: #b42318; border: 1px solid #fecdca; }
        code { background: #eef2f6; border-radius: 4px; padding: 2px 5px; }
        .help { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; margin-bottom: 14px; }
        .help div { background: #fff; border: 1px solid var(--line); border-radius: 8px; padding: 14px; }
        .help strong { display: block; margin-bottom: 6px; }
        @media (max-width: 760px) { .help { grid-template-columns: 1fr; } header { align-items: flex-start; flex-direction: column; } }
    </style>
</head>
<body>
    <header>
        <div>
            <h1>Painel Admin</h1>
            <p style="margin:6px 0 0">Edite o conteúdo salvo em <code>{{ $path }}</code>.</p>
        </div>
        <a class="btn secondary" href="{{ url('/') }}" target="_blank" rel="noreferrer">Ver site</a>
    </header>

    <main>
        @if ($saved)
            <div class="notice success">Conteúdo salvo com sucesso.</div>
        @endif

        @if ($error)
            <div class="notice error">{{ $error }}</div>
        @endif

        <div class="help">
            <div><strong>settings</strong><p>Dados globais: marca, telefone, WhatsApp, email, cidade, URL base e Google tags.</p></div>
            <div><strong>services / areas</strong><p>Use a mesma chave do serviço ou cidade para trocar nomes, textos, listas e SEO.</p></div>
            <div><strong>pages / faqs</strong><p>Substitui títulos, descrições e perguntas usados pelas páginas principais.</p></div>
        </div>

        <form class="panel" method="post" action="{{ url('/admin') }}">
            <textarea name="content" spellcheck="false">{{ $content ?: "{}" }}</textarea>
            <div class="actions">
                <p style="margin:0">Dica: salve JSON válido. Para remover uma alteração, apague a chave correspondente.</p>
                <button class="btn" type="submit">Salvar alterações</button>
            </div>
        </form>
    </main>
</body>
</html>
