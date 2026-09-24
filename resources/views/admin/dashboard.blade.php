<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Painel Admin | Gold Cleaning</title>
    <style>
        :root { color-scheme: light; --gold:#b88928; --gold-dark:#8d641d; --ink:#17202a; --muted:#667085; --line:#e4e7ec; --soft:#f6f7f9; --white:#fff; }
        * { box-sizing: border-box; }
        body { margin:0; font-family:Arial,sans-serif; background:var(--soft); color:var(--ink); }
        a { color:inherit; }
        .shell { min-height:100vh; display:grid; grid-template-columns:260px 1fr; }
        .sidebar { background:#111827; color:#fff; padding:22px; position:sticky; top:0; height:100vh; }
        .brand { font-size:20px; font-weight:900; margin-bottom:6px; }
        .sidebar p { color:#cbd5e1; margin:0 0 22px; line-height:1.45; }
        .nav { display:grid; gap:8px; }
        .nav button { border:0; border-radius:8px; background:transparent; color:#e5e7eb; padding:11px 12px; display:flex; align-items:center; justify-content:space-between; gap:10px; text-align:left; font-weight:700; cursor:pointer; }
        .nav button.active, .nav button:hover { background:rgba(184,137,40,.18); color:#fff; }
        .nav-count { min-width:24px; padding:3px 7px; border-radius:999px; background:var(--gold); color:#fff; font-size:11px; text-align:center; }
        .content { min-width:0; }
        .topbar { background:var(--white); border-bottom:1px solid var(--line); padding:18px 26px; display:flex; align-items:center; justify-content:space-between; gap:16px; position:sticky; top:0; z-index:2; }
        h1 { margin:0; font-size:24px; }
        h2 { margin:0 0 14px; font-size:20px; }
        h3 { margin:0; font-size:16px; }
        p { color:var(--muted); line-height:1.5; }
        main { max-width:1180px; margin:0 auto; padding:26px; }
        .section { display:none; }
        .section.active { display:block; }
        .card { background:var(--white); border:1px solid var(--line); border-radius:8px; padding:20px; margin-bottom:18px; }
        .grid { display:grid; gap:14px; }
        .grid-2 { grid-template-columns:repeat(2,minmax(0,1fr)); }
        .grid-3 { grid-template-columns:repeat(3,minmax(0,1fr)); }
        label { display:block; font-size:13px; font-weight:800; margin-bottom:6px; }
        input, textarea, select { width:100%; border:1px solid var(--line); border-radius:7px; padding:10px 11px; font:inherit; color:var(--ink); background:#fff; }
        textarea { min-height:96px; resize:vertical; line-height:1.45; }
        .large textarea { min-height:150px; }
        .hint { font-size:12px; color:var(--muted); margin:6px 0 0; }
        .btn { appearance:none; border:1px solid var(--gold); background:var(--gold); color:#fff; border-radius:7px; padding:11px 16px; font-weight:800; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:8px; }
        .btn:hover { background:var(--gold-dark); }
        .btn.secondary { background:#fff; color:var(--ink); border-color:var(--line); }
        .btn.secondary:hover { background:#f9fafb; }
        .actions { display:flex; justify-content:flex-end; gap:10px; align-items:center; }
        .logout-btn { color:#b42318; }
        .notice { border-radius:8px; padding:12px 14px; margin-bottom:16px; }
        .success { background:#ecfdf3; color:#027a48; border:1px solid #abefc6; }
        .error { background:#fef3f2; color:#b42318; border:1px solid #fecdca; }
        .summary { display:flex; justify-content:space-between; gap:12px; align-items:center; cursor:pointer; }
        details.card { padding:0; overflow:hidden; }
        details.card > summary { list-style:none; padding:18px 20px; }
        details.card > summary::-webkit-details-marker { display:none; }
        .details-body { border-top:1px solid var(--line); padding:20px; }
        .pill { display:inline-flex; border-radius:999px; background:#fef7e7; color:#8d641d; padding:5px 10px; font-size:12px; font-weight:900; }
        .pair-list { display:grid; gap:12px; }
        .pair-row { display:grid; grid-template-columns:minmax(180px,.75fr) minmax(240px,1fr) auto; gap:10px; align-items:start; padding:12px; border:1px solid var(--line); border-radius:8px; background:#fcfcfd; }
        .media-list { display:grid; gap:16px; }
        .media-item { display:grid; gap:14px; padding:16px; border:1px solid var(--line); border-radius:8px; background:#fcfcfd; }
        .media-head { display:flex; justify-content:space-between; gap:12px; align-items:center; }
        .media-preview { width:100%; height:135px; object-fit:cover; border-radius:8px; border:1px solid var(--line); background:#eef2f6; margin-bottom:8px; }
        .remove-row { border-color:#fecdca; color:#b42318; background:#fff; padding:10px 12px; }
        .subtle { color:var(--muted); font-size:13px; margin:0; }
        .section-heading { display:flex; align-items:flex-start; justify-content:space-between; gap:20px; margin-bottom:18px; }
        .section-heading h2 { margin-bottom:5px; font-size:24px; }
        .lead-stats { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; margin-bottom:18px; }
        .lead-stat { padding:18px 20px; border:1px solid var(--line); border-radius:8px; background:#fff; }
        .lead-stat strong { display:block; margin-bottom:4px; font-size:29px; line-height:1; }
        .lead-stat span { color:var(--muted); font-size:13px; font-weight:700; }
        .lead-list { display:grid; gap:14px; }
        .lead-card { padding:0; overflow:hidden; }
        .lead-card-head { display:flex; align-items:center; justify-content:space-between; gap:18px; padding:18px 20px; border-bottom:1px solid var(--line); }
        .lead-person { display:flex; align-items:center; gap:12px; min-width:0; }
        .lead-avatar { width:42px; height:42px; flex:0 0 42px; display:grid; place-items:center; border-radius:50%; background:#fef7e7; color:var(--gold-dark); font-size:17px; font-weight:900; }
        .lead-person h3 { margin-bottom:3px; }
        .lead-person p { margin:0; font-size:12px; }
        .lead-contact { display:flex; flex-wrap:wrap; justify-content:flex-end; gap:8px; }
        .lead-action { min-height:36px; padding:8px 11px; border:1px solid var(--line); border-radius:7px; background:#fff; color:var(--ink); font-size:12px; font-weight:800; text-decoration:none; }
        .lead-action:hover { border-color:var(--gold); color:var(--gold-dark); }
        .lead-action.primary { border-color:var(--gold); background:var(--gold); color:#fff; }
        .lead-details { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:16px; padding:18px 20px; }
        .lead-detail span { display:block; margin-bottom:5px; color:var(--muted); font-size:11px; font-weight:800; letter-spacing:.04em; text-transform:uppercase; }
        .lead-detail strong { display:block; font-size:14px; line-height:1.4; overflow-wrap:anywhere; }
        .lead-tracking { border-top:1px solid var(--line); background:#fcfcfd; }
        .lead-tracking summary { padding:12px 20px; color:var(--muted); font-size:12px; font-weight:800; cursor:pointer; }
        .lead-tracking-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; padding:0 20px 18px; }
        .empty-leads { padding:54px 24px; text-align:center; }
        .empty-leads h3 { margin-bottom:8px; }
        .empty-leads p { max-width:520px; margin:0 auto; }
        .savebar { position:sticky; bottom:0; border-top:1px solid var(--line); background:rgba(255,255,255,.96); padding:14px 26px; display:flex; justify-content:space-between; gap:14px; align-items:center; }
        body.viewing-leads .savebar, body.viewing-leads [data-save-action] { display:none; }
        @media (max-width:980px) { .shell { grid-template-columns:1fr; } .sidebar { position:static; height:auto; } .nav { grid-template-columns:repeat(2,minmax(0,1fr)); } .grid-2,.grid-3 { grid-template-columns:1fr; } .pair-row { grid-template-columns:1fr; } .topbar,.savebar { position:static; } .lead-details { grid-template-columns:repeat(2,minmax(0,1fr)); } }
        @media (max-width:640px) { main { padding:18px 14px; } .section-heading,.lead-card-head { align-items:stretch; flex-direction:column; } .lead-stats { grid-template-columns:1fr; } .lead-stat { display:flex; align-items:center; justify-content:space-between; } .lead-stat strong { margin:0; font-size:24px; } .lead-contact { justify-content:flex-start; } .lead-action { flex:1; text-align:center; } .lead-details,.lead-tracking-grid { grid-template-columns:1fr; } .actions { flex-wrap:wrap; } }
    </style>
</head>
<body>
    <form method="post" action="{{ url('/admin') }}" class="shell" enctype="multipart/form-data">
        <input type="hidden" name="_admin_csrf" value="{{ $adminCsrfToken }}">
        <aside class="sidebar">
            <div class="brand">{{ $settings['brand'] ?? 'Gold Cleaning' }}</div>
            <p>Painel de conteudo do site. Edite os campos e clique em salvar.</p>
            <nav class="nav" aria-label="Navegacao do admin">
                <button type="button" class="active" data-tab-button="settings">Configuracoes</button>
                <button type="button" data-tab-button="leads"><span>Leads</span><span class="nav-count">{{ $leadStats['total'] }}</span></button>
                <button type="button" data-tab-button="pages">Paginas</button>
                <button type="button" data-tab-button="services">Servicos</button>
                <button type="button" data-tab-button="areas">Areas</button>
                <button type="button" data-tab-button="faqs">FAQs</button>
                <button type="button" data-tab-button="before-after">Antes e Depois</button>
            </nav>
        </aside>

        <div class="content">
            <header class="topbar">
                <div>
                    <h1>Painel Admin</h1>
                    <p class="subtle">Edicao visual do conteudo salvo em {{ $path }}.</p>
                </div>
                <div class="actions">
                    <a class="btn secondary" href="{{ url('/') }}" target="_blank" rel="noreferrer">Ver site</a>
                    <button class="btn secondary logout-btn" type="submit" form="admin-logout-form">Sair</button>
                    <button class="btn" type="submit" data-save-action>Salvar alteracoes</button>
                </div>
            </header>

            <main>
                @if ($saved)
                    <div class="notice success">Conteudo salvo com sucesso.</div>
                @endif

                @if ($error)
                    <div class="notice error">{{ $error }}</div>
                @endif

                <section class="section" data-tab="leads">
                    <div class="section-heading">
                        <div>
                            <h2>Leads recebidos</h2>
                            <p class="subtle">Solicitacoes enviadas pelo formulario do site, das mais recentes para as mais antigas.</p>
                        </div>
                        <span class="pill">Horario de Atlanta</span>
                    </div>

                    <div class="lead-stats">
                        <div class="lead-stat"><strong>{{ $leadStats['total'] }}</strong><span>Total de leads</span></div>
                        <div class="lead-stat"><strong>{{ $leadStats['today'] }}</strong><span>Recebidos hoje</span></div>
                        <div class="lead-stat"><strong>{{ $leadStats['last_seven_days'] }}</strong><span>Ultimos 7 dias</span></div>
                    </div>

                    @if (empty($leads))
                        <div class="card empty-leads">
                            <h3>Nenhum lead recebido ainda</h3>
                            <p>Assim que alguem enviar o formulario de orcamento, os dados aparecerao aqui automaticamente.</p>
                        </div>
                    @else
                        <div class="lead-list">
                            @foreach ($leads as $lead)
                                <article class="card lead-card">
                                    <header class="lead-card-head">
                                        <div class="lead-person">
                                            <span class="lead-avatar">{{ mb_strtoupper(mb_substr($lead['name'] ?? '?', 0, 1)) }}</span>
                                            <div>
                                                <h3>{{ $lead['name'] ?? 'Sem nome' }}</h3>
                                                <p>{{ $lead['created_at_formatted'] }} · Prefere {{ $lead['contact_method_label'] }}</p>
                                            </div>
                                        </div>
                                        <div class="lead-contact">
                                            @if (!empty($lead['phone_digits']))
                                                <a class="lead-action" href="tel:+{{ $lead['whatsapp_digits'] }}">Ligar</a>
                                                <a class="lead-action primary" href="https://wa.me/{{ $lead['whatsapp_digits'] }}" target="_blank" rel="noreferrer">WhatsApp</a>
                                            @endif
                                            @if (!empty($lead['email']))
                                                <a class="lead-action" href="mailto:{{ $lead['email'] }}">E-mail</a>
                                            @endif
                                        </div>
                                    </header>

                                    <div class="lead-details">
                                        <div class="lead-detail"><span>Telefone</span><strong>{{ $lead['phone'] ?? '-' }}</strong></div>
                                        <div class="lead-detail"><span>E-mail</span><strong>{{ $lead['email'] ?: '-' }}</strong></div>
                                        <div class="lead-detail"><span>Servico</span><strong>{{ $lead['cleaning_type'] ?? '-' }}</strong></div>
                                        <div class="lead-detail"><span>Frequencia</span><strong>{{ $lead['frequency'] ?? '-' }}</strong></div>
                                        <div class="lead-detail"><span>Quartos</span><strong>{{ $lead['bedrooms'] ?? '-' }}</strong></div>
                                        <div class="lead-detail"><span>Banheiros</span><strong>{{ $lead['bathrooms'] ?? '-' }}</strong></div>
                                        <div class="lead-detail"><span>ZIP Code</span><strong>{{ $lead['zip_code'] ?? '-' }}</strong></div>
                                        <div class="lead-detail"><span>Contato preferido</span><strong>{{ $lead['contact_method_label'] }}</strong></div>
                                    </div>

                                    <details class="lead-tracking">
                                        <summary>Ver origem e dados da campanha</summary>
                                        <div class="lead-tracking-grid">
                                            <div class="lead-detail"><span>Origem</span><strong>{{ $lead['source'] ?: 'Direto' }}</strong></div>
                                            <div class="lead-detail"><span>UTM Source</span><strong>{{ $lead['utm_source'] ?: '-' }}</strong></div>
                                            <div class="lead-detail"><span>UTM Campaign</span><strong>{{ $lead['utm_campaign'] ?: '-' }}</strong></div>
                                            <div class="lead-detail"><span>UTM Medium</span><strong>{{ $lead['utm_medium'] ?: '-' }}</strong></div>
                                            <div class="lead-detail"><span>GCLID</span><strong>{{ $lead['gclid'] ?: '-' }}</strong></div>
                                            <div class="lead-detail"><span>Pagina</span><strong>{{ $lead['page_url'] ?: '-' }}</strong></div>
                                        </div>
                                    </details>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </section>

                <section class="section active" data-tab="settings">
                    <div class="card">
                        <h2>Configuracoes globais</h2>
                        <div class="grid grid-3">
                            <div><label>Nome da marca</label><input name="settings[brand]" value="{{ $settings['brand'] ?? '' }}"></div>
                            <div><label>Cidade principal</label><input name="settings[city]" value="{{ $settings['city'] ?? '' }}"></div>
                            <div><label>Raio de atendimento</label><input name="settings[service_radius]" value="{{ $settings['service_radius'] ?? '' }}"></div>
                            <div><label>Telefone exibido</label><input name="settings[phone_display]" value="{{ $settings['phone_display'] ?? '' }}"></div>
                            <div><label>Telefone para link</label><input name="settings[phone_tel]" value="{{ $settings['phone_tel'] ?? '' }}"></div>
                            <div><label>Digitos para SMS</label><input name="settings[phone_digits]" value="{{ $settings['phone_digits'] ?? '' }}"></div>
                            <div><label>WhatsApp</label><input name="settings[whatsapp_digits]" value="{{ $settings['whatsapp_digits'] ?? '' }}"></div>
                            <div><label>Email</label><input name="settings[email]" value="{{ $settings['email'] ?? '' }}"></div>
                            <div><label>URL base</label><input name="settings[base_url]" value="{{ $settings['base_url'] ?? '' }}"></div>
                            <div><label>Google Analytics ID</label><input name="settings[google_analytics_id]" value="{{ $settings['google_analytics_id'] ?? '' }}"></div>
                            <div><label>Google Ads ID</label><input name="settings[google_ads_id]" value="{{ $settings['google_ads_id'] ?? '' }}"></div>
                            <div><label>Imagem social</label><input name="settings[image]" value="{{ $settings['image'] ?? '' }}"></div>
                        </div>
                    </div>
                    <div class="card large">
                        <h2>Rodape</h2>
                        <label>Descricao do rodape</label>
                        <textarea name="settings[footer_description]">{{ $settings['footer_description'] ?? '' }}</textarea>
                    </div>
                </section>

                <section class="section" data-tab="pages">
                    @foreach ($pages as $pageKey => $page)
                        <details class="card" @if ($loop->first) open @endif>
                            <summary class="summary">
                                <div>
                                    <h2>{{ $pageLabels[$pageKey] ?? $pageKey }}</h2>
                                    <p class="subtle">{{ $page['title'] ?? '' }}</p>
                                </div>
                                <span class="pill">Editar pagina</span>
                            </summary>
                            <div class="details-body grid">
                                <div class="grid grid-2">
                                    <div><label>Meta title</label><input name="pages[{{ $pageKey }}][title]" value="{{ $page['title'] ?? '' }}"></div>
                                    <div><label>Meta description</label><input name="pages[{{ $pageKey }}][description]" value="{{ $page['description'] ?? '' }}"></div>
                                </div>
                                @foreach ($page as $field => $value)
                                    @continue(in_array($field, ['title', 'description', 'sections'], true) || is_array($value))
                                    <div>
                                        <label>{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                                        <textarea name="pages[{{ $pageKey }}][{{ $field }}]">{{ $value }}</textarea>
                                    </div>
                                @endforeach
                                @if (isset($page['sections']))
                                    <div>
                                        <label>Secoes</label>
                                        <div class="pair-list" data-repeater>
                                            @foreach ($page['sections'] as $section)
                                                <div class="pair-row">
                                                    <input name="pages[{{ $pageKey }}][sections][{{ $loop->index }}][title]" value="{{ $section[0] ?? '' }}" placeholder="Titulo">
                                                    <textarea name="pages[{{ $pageKey }}][sections][{{ $loop->index }}][text]" placeholder="Texto">{{ $section[1] ?? '' }}</textarea>
                                                    <button type="button" class="btn secondary remove-row" data-remove-row>Remover</button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn secondary" data-add-row data-prefix="pages[{{ $pageKey }}][sections]" data-first="title" data-second="text">Adicionar secao</button>
                                    </div>
                                @endif
                            </div>
                        </details>
                    @endforeach
                </section>

                <section class="section" data-tab="services">
                    @foreach ($services as $slug => $service)
                        <details class="card" @if ($loop->first) open @endif>
                            <summary class="summary">
                                <div>
                                    <h2>{{ $service['name'] ?? $slug }}</h2>
                                    <p class="subtle">/services/{{ $slug }}</p>
                                </div>
                                <span class="pill">Servico</span>
                            </summary>
                            <div class="details-body grid">
                                <div class="grid grid-2">
                                    <div><label>Nome</label><input name="services[{{ $slug }}][name]" value="{{ $service['name'] ?? '' }}"></div>
                                    <div><label>Meta title</label><input name="services[{{ $slug }}][title]" value="{{ $service['title'] ?? '' }}"></div>
                                </div>
                                <div><label>Meta description</label><textarea name="services[{{ $slug }}][description]">{{ $service['description'] ?? '' }}</textarea></div>
                                <div><label>Introducao</label><textarea name="services[{{ $slug }}][intro]">{{ $service['intro'] ?? '' }}</textarea></div>
                                <div class="grid grid-2">
                                    <div><label>Para quem e</label><textarea name="services[{{ $slug }}][for]">{{ implode("\n", $service['for'] ?? []) }}</textarea><p class="hint">Uma linha por item.</p></div>
                                    <div><label>O que inclui</label><textarea name="services[{{ $slug }}][included]">{{ implode("\n", $service['included'] ?? []) }}</textarea><p class="hint">Uma linha por item.</p></div>
                                    <div><label>Afeta o orcamento</label><textarea name="services[{{ $slug }}][quote]">{{ implode("\n", $service['quote'] ?? []) }}</textarea><p class="hint">Uma linha por item.</p></div>
                                    <div><label>Add-ons populares</label><textarea name="services[{{ $slug }}][addons]">{{ implode("\n", $service['addons'] ?? []) }}</textarea><p class="hint">Uma linha por item.</p></div>
                                </div>
                            </div>
                        </details>
                    @endforeach
                </section>

                <section class="section" data-tab="areas">
                    @foreach ($areas as $slug => $area)
                        <details class="card" @if ($loop->first) open @endif>
                            <summary class="summary">
                                <div>
                                    <h2>{{ $area['city'] ?? $slug }}, GA</h2>
                                    <p class="subtle">/service-areas/{{ $slug }}</p>
                                </div>
                                <span class="pill">Area</span>
                            </summary>
                            <div class="details-body grid">
                                <div><label>Cidade</label><input name="areas[{{ $slug }}][city]" value="{{ $area['city'] ?? '' }}"></div>
                                <div><label>Texto da pagina</label><textarea name="areas[{{ $slug }}][note]">{{ $area['note'] ?? '' }}</textarea></div>
                                <div><label>Cidades proximas</label><textarea name="areas[{{ $slug }}][nearby]">{{ implode("\n", $area['nearby'] ?? []) }}</textarea><p class="hint">Uma cidade por linha.</p></div>
                            </div>
                        </details>
                    @endforeach
                </section>

                <section class="section" data-tab="faqs">
                    @foreach ($faqs as $faqKey => $items)
                        <div class="card">
                            <div class="summary" style="margin-bottom:14px">
                                <div>
                                    <h2>{{ $faqKey === 'home' ? 'FAQ da Home' : 'Pagina completa de FAQ' }}</h2>
                                    <p class="subtle">Perguntas exibidas no site e usadas no schema SEO.</p>
                                </div>
                                <button type="button" class="btn secondary" data-add-row data-prefix="faqs[{{ $faqKey }}]" data-first="question" data-second="answer">Adicionar pergunta</button>
                            </div>
                            <div class="pair-list" data-repeater>
                                @foreach ($items as $item)
                                    <div class="pair-row">
                                        <input name="faqs[{{ $faqKey }}][{{ $loop->index }}][question]" value="{{ $item[0] ?? '' }}" placeholder="Pergunta">
                                        <textarea name="faqs[{{ $faqKey }}][{{ $loop->index }}][answer]" placeholder="Resposta">{{ $item[1] ?? '' }}</textarea>
                                        <button type="button" class="btn secondary remove-row" data-remove-row>Remover</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </section>

                <section class="section" data-tab="before-after">
                    <div class="card">
                        <h2>Secao antes e depois</h2>
                        <div class="grid grid-2">
                            <div>
                                <label>Status</label>
                                <select name="before_after[section][enabled]">
                                    <option value="1" @if (($beforeAfter['section']['enabled'] ?? '1') === '1') selected @endif>Visivel no site</option>
                                    <option value="0" @if (($beforeAfter['section']['enabled'] ?? '1') === '0') selected @endif>Oculta</option>
                                </select>
                            </div>
                            <div><label>Etiqueta</label><input name="before_after[section][eyebrow]" value="{{ $beforeAfter['section']['eyebrow'] ?? '' }}"></div>
                            <div><label>Titulo</label><input name="before_after[section][title]" value="{{ $beforeAfter['section']['title'] ?? '' }}"></div>
                            <div><label>Texto de apoio</label><input name="before_after[section][text]" value="{{ $beforeAfter['section']['text'] ?? '' }}"></div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="summary" style="margin-bottom:14px">
                            <div>
                                <h2>Fotos e videos</h2>
                                <p class="subtle">Cadastre pares de foto antes/depois. O video e opcional.</p>
                            </div>
                            <button type="button" class="btn secondary" data-add-media>Adicionar item</button>
                        </div>

                        <div class="media-list" data-media-list>
                            @foreach ($beforeAfter['items'] as $item)
                                <div class="media-item">
                                    <div class="media-head">
                                        <strong>{{ $item['title'] ?? 'Resultado' }}</strong>
                                        <button type="button" class="btn secondary remove-row" data-remove-row>Remover</button>
                                    </div>
                                    <div class="grid grid-2">
                                        <div>
                                            <label>Titulo</label>
                                            <input name="before_after[items][{{ $loop->index }}][title]" value="{{ $item['title'] ?? '' }}" placeholder="Ex: Kitchen deep clean">
                                        </div>
                                        <div>
                                            <label>Status</label>
                                            <select name="before_after[items][{{ $loop->index }}][enabled]">
                                                <option value="1" @if (($item['enabled'] ?? '1') === '1') selected @endif>Visivel</option>
                                                <option value="0" @if (($item['enabled'] ?? '1') === '0') selected @endif>Oculto</option>
                                            </select>
                                        </div>
                                    </div>
                                    <label>Descricao</label>
                                    <textarea name="before_after[items][{{ $loop->index }}][description]" placeholder="Pequena descricao do resultado">{{ $item['description'] ?? '' }}</textarea>
                                    <div class="grid grid-3">
                                        <div>
                                            <label>Foto antes</label>
                                            @if (!empty($item['before_image']))
                                                <img class="media-preview" src="{{ url($item['before_image']) }}" alt="">
                                            @endif
                                            <input type="hidden" name="before_after[items][{{ $loop->index }}][before_image_existing]" value="{{ $item['before_image'] ?? '' }}">
                                            <input type="file" name="before_after[items][{{ $loop->index }}][before_image]" accept="image/*">
                                        </div>
                                        <div>
                                            <label>Foto depois</label>
                                            @if (!empty($item['after_image']))
                                                <img class="media-preview" src="{{ url($item['after_image']) }}" alt="">
                                            @endif
                                            <input type="hidden" name="before_after[items][{{ $loop->index }}][after_image_existing]" value="{{ $item['after_image'] ?? '' }}">
                                            <input type="file" name="before_after[items][{{ $loop->index }}][after_image]" accept="image/*">
                                        </div>
                                        <div>
                                            <label>Video opcional</label>
                                            @if (!empty($item['video']))
                                                <video class="media-preview" src="{{ url($item['video']) }}" controls></video>
                                            @endif
                                            <input type="hidden" name="before_after[items][{{ $loop->index }}][video_existing]" value="{{ $item['video'] ?? '' }}">
                                            <input type="file" name="before_after[items][{{ $loop->index }}][video]" accept="video/mp4,video/webm,video/quicktime">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </main>

            <div class="savebar">
                <p class="subtle">As alteracoes entram no site assim que forem salvas.</p>
                <button class="btn" type="submit" data-save-action>Salvar alteracoes</button>
            </div>
        </div>
    </form>

    <form id="admin-logout-form" method="post" action="{{ url('/admin/logout') }}" hidden>
        <input type="hidden" name="_admin_csrf" value="{{ $adminCsrfToken }}">
    </form>

    <script>
        document.querySelectorAll("[data-tab-button]").forEach((button) => {
            button.addEventListener("click", () => {
                document.querySelectorAll("[data-tab-button]").forEach((item) => item.classList.remove("active"));
                document.querySelectorAll("[data-tab]").forEach((section) => section.classList.remove("active"));
                button.classList.add("active");
                document.querySelector(`[data-tab="${button.dataset.tabButton}"]`).classList.add("active");
                document.body.classList.toggle("viewing-leads", button.dataset.tabButton === "leads");
            });
        });

        document.addEventListener("click", (event) => {
            const addButton = event.target.closest("[data-add-row]");
            const removeButton = event.target.closest("[data-remove-row]");

            if (removeButton) {
                const row = removeButton.closest(".pair-row") || removeButton.closest(".media-item");
                if (row) row.remove();
                return;
            }

            if (!addButton) return;

            const list = addButton.parentElement.querySelector("[data-repeater]") || addButton.closest(".card").querySelector("[data-repeater]");
            const index = list.querySelectorAll(".pair-row").length;
            const prefix = addButton.dataset.prefix;
            const first = addButton.dataset.first;
            const second = addButton.dataset.second;
            const row = document.createElement("div");

            row.className = "pair-row";
            row.innerHTML = `
                <input name="${prefix}[${index}][${first}]" placeholder="${first === "question" ? "Pergunta" : "Titulo"}">
                <textarea name="${prefix}[${index}][${second}]" placeholder="${second === "answer" ? "Resposta" : "Texto"}"></textarea>
                <button type="button" class="btn secondary remove-row" data-remove-row>Remover</button>
            `;
            list.appendChild(row);
        });

        document.querySelector("[data-add-media]")?.addEventListener("click", () => {
            const list = document.querySelector("[data-media-list]");
            const index = list.querySelectorAll(".media-item").length;
            const item = document.createElement("div");

            item.className = "media-item";
            item.innerHTML = `
                <div class="media-head">
                    <strong>Novo resultado</strong>
                    <button type="button" class="btn secondary remove-row" data-remove-row>Remover</button>
                </div>
                <div class="grid grid-2">
                    <div>
                        <label>Titulo</label>
                        <input name="before_after[items][${index}][title]" placeholder="Ex: Kitchen deep clean">
                    </div>
                    <div>
                        <label>Status</label>
                        <select name="before_after[items][${index}][enabled]">
                            <option value="1" selected>Visivel</option>
                            <option value="0">Oculto</option>
                        </select>
                    </div>
                </div>
                <label>Descricao</label>
                <textarea name="before_after[items][${index}][description]" placeholder="Pequena descricao do resultado"></textarea>
                <div class="grid grid-3">
                    <div>
                        <label>Foto antes</label>
                        <input type="hidden" name="before_after[items][${index}][before_image_existing]" value="">
                        <input type="file" name="before_after[items][${index}][before_image]" accept="image/*">
                    </div>
                    <div>
                        <label>Foto depois</label>
                        <input type="hidden" name="before_after[items][${index}][after_image_existing]" value="">
                        <input type="file" name="before_after[items][${index}][after_image]" accept="image/*">
                    </div>
                    <div>
                        <label>Video opcional</label>
                        <input type="hidden" name="before_after[items][${index}][video_existing]" value="">
                        <input type="file" name="before_after[items][${index}][video]" accept="video/mp4,video/webm,video/quicktime">
                    </div>
                </div>
            `;
            list.appendChild(item);
        });
    </script>
</body>
</html>
