<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Taskday' }} | Taskday</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --green: #228B22; --green-dark: #176b1a; --ink: #172117; --muted: #6d786d; --paper: #f9f9f9; --line: #e3e9e3; --white: #fff; --red: #c94d45; }
        * { box-sizing: border-box; }
        body { margin: 0; min-width: 320px; background: var(--paper); color: var(--ink); font-family: 'DM Sans', sans-serif; }
        a { color: inherit; text-decoration: none; }
        button, input, textarea { font: inherit; }
        button { cursor: pointer; }
        .shell { min-height: 100vh; }
        .topbar { display: flex; align-items: center; justify-content: space-between; padding: 28px max(24px, calc((100vw - 1120px) / 2)); background: var(--white); border-bottom: 1px solid var(--line); }
        .brand { display: flex; align-items: center; gap: 11px; font-family: 'Space Grotesk', sans-serif; font-size: 21px; font-weight: 700; letter-spacing: -.4px; }
        .brand-mark { display: grid; place-items: center; width: 32px; height: 32px; border-radius: 9px; background: var(--green); color: var(--white); font-size: 16px; }
        .topbar-note { color: var(--muted); font-size: 13px; }
        .content { width: min(1120px, calc(100% - 48px)); margin: 0 auto; padding: 54px 0 70px; }
        .eyebrow { margin: 0 0 10px; color: var(--green); font-size: 12px; font-weight: 700; letter-spacing: 1.6px; text-transform: uppercase; }
        h1, h2 { margin: 0; font-family: 'Space Grotesk', sans-serif; letter-spacing: -.8px; }
        h1 { font-size: clamp(32px, 5vw, 54px); line-height: 1.02; }
        .intro { display: flex; align-items: end; justify-content: space-between; gap: 24px; margin-bottom: 38px; }
        .intro-copy { max-width: 560px; }
        .intro-copy p { margin: 14px 0 0; color: var(--muted); font-size: 16px; line-height: 1.6; }
        .button { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 45px; padding: 0 17px; border: 0; border-radius: 7px; background: var(--green); color: var(--white); font-weight: 700; transition: background .2s, transform .2s; }
        .button:hover { background: var(--green-dark); transform: translateY(-1px); }
        .button.secondary { background: var(--white); color: var(--ink); border: 1px solid var(--line); }
        .button.secondary:hover { background: #f1f5f1; }
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 28px; }
        .stat { padding: 20px 22px; border: 1px solid var(--line); border-radius: 9px; background: var(--white); }
        .stat strong { display: block; margin-bottom: 6px; font-family: 'Space Grotesk', sans-serif; font-size: 28px; }
        .stat span { color: var(--muted); font-size: 13px; }
        .stat.accent { background: var(--green); color: var(--white); border-color: var(--green); }
        .stat.accent span { color: #d8f3d8; }
        .section-heading { display: flex; justify-content: space-between; align-items: center; margin-bottom: 13px; }
        .section-heading h2 { font-size: 20px; }
        .section-heading span { color: var(--muted); font-size: 13px; }
        .task-list { display: grid; gap: 10px; }
        .task { display: grid; grid-template-columns: auto 1fr auto; align-items: center; gap: 16px; padding: 19px 21px; border: 1px solid var(--line); border-radius: 9px; background: var(--white); }
        .status-toggle { display: grid; place-items: center; width: 25px; height: 25px; padding: 0; border: 2px solid #b5c2b5; border-radius: 50%; background: transparent; color: transparent; font-size: 15px; font-weight: 700; }
        .status-toggle:hover { border-color: var(--green); }
        .task.completed .status-toggle { border-color: var(--green); background: var(--green); color: var(--white); }
        .task-title { margin: 0 0 5px; font-size: 16px; font-weight: 700; }
        .task.completed .task-title { color: #8b958b; text-decoration: line-through; }
        .task-description { margin: 0; max-width: 650px; color: var(--muted); font-size: 13px; line-height: 1.5; }
        .task-date { margin-top: 8px; color: #9ca69c; font-size: 11px; }
        .task-actions { display: flex; align-items: center; gap: 13px; }
        .status { padding: 5px 9px; border-radius: 99px; background: #fff4c2; color: #806000; font-size: 11px; font-weight: 700; text-transform: capitalize; }
        .status.completed { background: #e8f3ed; color: #28724d; }
        .action-link { color: var(--muted); font-size: 12px; font-weight: 600; }
        .action-link:hover { color: var(--green); }
        .action-link.delete { color: var(--red); background: none; border: 0; padding: 0; }
        .empty { padding: 60px 20px; border: 1px dashed #cad5ca; border-radius: 9px; text-align: center; }
        .empty strong { display: block; margin-bottom: 7px; font-family: 'Space Grotesk', sans-serif; font-size: 20px; }
        .empty p { margin: 0 0 20px; color: var(--muted); font-size: 14px; }
        .flash { margin-bottom: 20px; padding: 13px 16px; border: 1px solid #b7dbb7; border-radius: 7px; background: #edf8ed; color: var(--green-dark); font-size: 14px; }
        .form-wrap { max-width: 680px; margin: 0 auto; }
        .form-card { margin-top: 30px; padding: clamp(22px, 5vw, 38px); border: 1px solid var(--line); border-radius: 10px; background: var(--white); }
        .field { margin-bottom: 22px; }
        label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; }
        input, textarea { width: 100%; padding: 13px 14px; border: 1px solid #d6dfd6; border-radius: 6px; outline: none; color: var(--ink); background: #fcfdfc; }
        input:focus, textarea:focus { border-color: var(--green); box-shadow: 0 0 0 3px #228b2218; }
        textarea { min-height: 130px; resize: vertical; }
        .error { margin: 6px 0 0; color: var(--red); font-size: 12px; }
        .form-actions { display: flex; align-items: center; gap: 15px; margin-top: 30px; }
        @media (max-width: 650px) { .topbar { padding: 20px 18px; } .topbar-note { display: none; } .content { width: min(100% - 36px, 540px); padding-top: 38px; } .intro { align-items: start; flex-direction: column; margin-bottom: 28px; } .stats { gap: 8px; } .stat { padding: 15px; } .stat strong { font-size: 23px; } .task { grid-template-columns: auto 1fr; gap: 12px; padding: 16px; } .task-actions { grid-column: 2; justify-content: space-between; } }
    </style>
</head>
<body>
    <div class="shell">
        <header class="topbar">
            <a class="brand" href="{{ route('tasks.index', [], false) }}"><span class="brand-mark">T</span> Taskday</a>
            <span class="topbar-note">A calmer place for your to-do list</span>
        </header>
        <main class="content">
            @if (session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>