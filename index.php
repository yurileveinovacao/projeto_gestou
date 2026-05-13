<?php require __DIR__ . '/config/maintenance.php'; checkMaintenanceMode(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestou — Automatize seu Departamento Pessoal</title>
  <meta name="description" content="Com a Plataforma Gestou, seu DP ganha agilidade através da automação do Departamento Pessoal. Holerite digital, aceite eletrônico e gestão documental sem papel.">
  <meta name="author" content="Gestou">
  <meta name="creator" content="Leve Inovação Estratégica">
  <meta name="keywords" content="holerite digital,departamento pessoal,gestão de documentos,aceite eletrônico,GED,DP digital,espelho de ponto,folha de pagamento,automação RH,software DP,holerite online,assinatura digital holerite">
  <meta name="robots" content="index, follow">
  <meta name="googlebot" content="index, follow, max-video-preview:-1, max-image-preview:large, max-snippet:-1">

  <!-- Open Graph -->
  <meta property="og:title" content="Gestou — Automatize seu Departamento Pessoal">
  <meta property="og:description" content="Elimine o papel do seu DP. Holerite digital, aceite eletrônico e gestão documental em uma plataforma simples e segura.">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://www.gestou.com.br">
  <meta property="og:site_name" content="Gestou">
  <meta property="og:locale" content="pt_BR">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Gestou — Automatize seu Departamento Pessoal">
  <meta name="twitter:description" content="Elimine o papel do seu DP. Holerite digital, aceite eletrônico e gestão documental em uma plataforma simples e segura.">

  <!-- Schema.org JSON-LD -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Gestou",
    "url": "https://www.gestou.com.br",
    "applicationCategory": "BusinessApplication",
    "operatingSystem": "Web, Android, iOS",
    "description": "Plataforma de Departamento Pessoal Digital. Automatize holerites, aceites eletrônicos e gestão documental sem papel.",
    "offers": {
      "@type": "Offer",
      "price": "6.00",
      "priceCurrency": "BRL",
      "priceSpecification": {
        "@type": "UnitPriceSpecification",
        "price": "6.00",
        "priceCurrency": "BRL",
        "unitText": "por colaborador por mês"
      }
    },
    "author": {
      "@type": "Organization",
      "name": "Leve Inovação Estratégica",
      "url": "https://leveinovacao.com.br",
      "email": "contato@leveinovacao.com.br"
    },
    "contactPoint": {
      "@type": "ContactPoint",
      "contactType": "sales",
      "availableLanguage": "Portuguese"
    }
  }
  </script>

  <!-- Favicons -->
  <link href="/img/logo.png" rel="icon">
  <link href="/img/logo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Google Tag Manager — TODO: substituir GTM-XXXXXXX pelo ID real (tagmanager.google.com).
       GA4 e Meta Pixel são configurados como tags dentro do container, não no HTML. -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-XXXXXXX');</script>
  <!-- End Google Tag Manager -->

  <style>
    /* ===========================
       CSS VARIABLES
    =========================== */
    :root {
      --yellow: #FCD23B;
      --yellow-dark: #e6bc20;
      --yellow-light: #fde97a;
      --dark: #003099;
      --dark-2: #01036f;
      --gray-100: #f8f9fa;
      --gray-200: #e9ecef;
      --gray-400: #ced4da;
      --gray-600: #6c757d;
      --gray-800: #343a40;
      --white: #ffffff;
      --font-title: 'Montserrat', sans-serif;
      --font-body: 'Poppins', sans-serif;
      --radius: 12px;
      --radius-lg: 20px;
      --shadow: 0 4px 24px rgba(0,0,0,0.08);
      --shadow-lg: 0 12px 48px rgba(0,0,0,0.14);
      --transition: 0.3s ease;
    }

    /* ===========================
       RESET & BASE
    =========================== */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; font-size: 16px; }
    body {
      font-family: var(--font-body);
      color: var(--gray-800);
      background: var(--white);
      overflow-x: hidden;
    }
    img { max-width: 100%; height: auto; display: block; }
    a { text-decoration: none; color: inherit; }
    ul { list-style: none; }

    .container {
      width: 100%;
      max-width: 1140px;
      margin: 0 auto;
      padding: 0 24px;
    }
    .section-pad { padding: 96px 0; }
    .section-pad-sm { padding: 64px 0; }

    /* ===========================
       SECTION TITLES
    =========================== */
    .section-label {
      display: inline-block;
      font-family: var(--font-title);
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--yellow-dark);
      background: rgba(252,210,59,0.12);
      border: 1px solid rgba(252,210,59,0.3);
      padding: 5px 14px;
      border-radius: 50px;
      margin-bottom: 16px;
    }
    .cta-label {
      display: inline-block;
      font-family: var(--font-title);
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--yellow-dark);
      background: rgba(252,210,59,0.15);
      border: 1px solid rgba(252,210,59,0.35);
      padding: 5px 16px;
      border-radius: 50px;
      margin-bottom: 20px;
    }
    .section-title {
      font-family: var(--font-title);
      font-size: clamp(28px, 4vw, 40px);
      font-weight: 800;
      color: var(--dark);
      line-height: 1.2;
      margin-bottom: 16px;
    }
    .section-title span { color: var(--yellow-dark); }
    .section-subtitle {
      font-size: 17px;
      color: var(--gray-600);
      line-height: 1.7;
      max-width: 560px;
    }
    .section-header { margin-bottom: 56px; }
    .section-header.center { text-align: center; }
    .section-header.center .section-subtitle { margin: 0 auto; }

    /* ===========================
       BUTTONS
    =========================== */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-family: var(--font-title);
      font-weight: 700;
      font-size: 14px;
      letter-spacing: 0.5px;
      padding: 14px 28px;
      border-radius: 50px;
      border: none;
      cursor: pointer;
      transition: var(--transition);
      white-space: nowrap;
    }
    .btn-primary {
      background: var(--yellow);
      color: var(--dark);
    }
    .btn-primary:hover {
      background: var(--yellow-dark);
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(252,210,59,0.4);
    }
    .btn-outline {
      background: transparent;
      color: var(--white);
      border: 2px solid rgba(255,255,255,0.4);
    }
    .btn-outline:hover {
      border-color: var(--yellow);
      color: var(--yellow);
      transform: translateY(-2px);
    }
    .btn-dark {
      background: var(--dark);
      color: var(--white);
    }
    .btn-dark:hover {
      background: var(--dark-2);
      transform: translateY(-2px);
      box-shadow: var(--shadow);
    }
    .btn-lg { padding: 18px 36px; font-size: 16px; }
    .btn-whatsapp {
      background: #25D366;
      color: var(--white);
    }
    .btn-whatsapp:hover {
      background: #1ebe5a;
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(37,211,102,0.35);
    }

    /* ===========================
       HEADER / NAV
    =========================== */
    #header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      transition: background 0.4s ease, box-shadow 0.4s ease, padding 0.3s ease;
      padding: 20px 0;
    }
    #header.scrolled {
      background: rgba(0, 48, 153, 0.97);
      backdrop-filter: blur(12px);
      box-shadow: 0 2px 20px rgba(0,0,0,0.2);
      padding: 12px 0;
    }
    .header-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 24px;
    }
    .logo img { height: 38px; width: auto; }

    /* Desktop Nav */
    .nav-desktop { display: flex; align-items: center; gap: 8px; }
    .nav-desktop a {
      font-family: var(--font-title);
      font-size: 13px;
      font-weight: 600;
      color: rgba(255,255,255,0.85);
      padding: 8px 14px;
      border-radius: 8px;
      transition: var(--transition);
      letter-spacing: 0.3px;
    }
    .nav-desktop a:hover { color: var(--yellow); background: rgba(252,210,59,0.1); }
    .nav-desktop a.active { color: var(--yellow); }
    .nav-desktop .nav-cta-collaborator {
      background: rgba(252,210,59,0.15);
      border: 1.5px solid rgba(252,210,59,0.4);
      color: var(--yellow);
      border-radius: 50px;
      padding: 8px 18px;
    }
    .nav-desktop .nav-cta-collaborator:hover {
      background: var(--yellow);
      border-color: var(--yellow);
      color: var(--dark);
    }
    .nav-desktop .nav-cta-admin {
      background: var(--yellow);
      color: var(--dark);
      border-radius: 50px;
      padding: 8px 18px;
      margin-left: 4px;
    }
    .nav-desktop .nav-cta-admin:hover {
      background: var(--yellow-dark);
      color: var(--dark);
    }

    /* Mobile Nav Toggle */
    .nav-toggle {
      display: none;
      background: none;
      border: none;
      cursor: pointer;
      padding: 8px;
      color: var(--white);
      font-size: 24px;
    }

    /* Mobile Nav Drawer */
    .nav-mobile {
      display: none;
      position: fixed;
      top: 0;
      right: 0;
      bottom: 0;
      width: min(320px, 85vw);
      background: var(--dark);
      z-index: 1100;
      flex-direction: column;
      padding: 0;
      transform: translateX(100%);
      transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: -8px 0 40px rgba(0,0,0,0.4);
    }
    .nav-mobile.open { transform: translateX(0); }
    .nav-mobile-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 20px 24px;
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .nav-mobile-header img { height: 34px; }
    .nav-mobile-close {
      background: none;
      border: none;
      color: rgba(255,255,255,0.6);
      font-size: 24px;
      cursor: pointer;
      padding: 4px;
    }
    .nav-mobile-close:hover { color: var(--white); }
    .nav-mobile-links {
      flex: 1;
      overflow-y: auto;
      padding: 16px 0;
    }
    .nav-mobile-links a {
      display: flex;
      align-items: center;
      gap: 12px;
      font-family: var(--font-title);
      font-size: 14px;
      font-weight: 600;
      color: rgba(255,255,255,0.75);
      padding: 14px 24px;
      transition: var(--transition);
      letter-spacing: 0.3px;
    }
    .nav-mobile-links a i { font-size: 18px; width: 20px; }
    .nav-mobile-links a:hover { color: var(--white); background: rgba(255,255,255,0.05); }
    .nav-mobile-links .divider {
      height: 1px;
      background: rgba(255,255,255,0.08);
      margin: 8px 24px;
    }
    .nav-mobile-ctas {
      padding: 20px 24px;
      border-bottom: 1px solid rgba(255,255,255,0.08);
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .nav-mobile-cta-collaborator {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-family: var(--font-title);
      font-weight: 700;
      font-size: 14px;
      padding: 14px 20px;
      border-radius: 50px;
      background: var(--yellow);
      color: var(--dark);
      transition: var(--transition);
      text-align: center;
    }
    .nav-mobile-cta-collaborator:hover { background: var(--yellow-dark); }
    .nav-mobile-cta-admin {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-family: var(--font-title);
      font-weight: 600;
      font-size: 13px;
      padding: 12px 20px;
      border-radius: 50px;
      background: rgba(255,255,255,0.08);
      color: rgba(255,255,255,0.75);
      border: 1px solid rgba(255,255,255,0.15);
      transition: var(--transition);
      text-align: center;
    }
    .nav-mobile-cta-admin:hover { background: rgba(255,255,255,0.15); color: var(--white); }
    .nav-mobile-note {
      font-size: 11px;
      color: rgba(255,255,255,0.35);
      text-align: center;
      padding: 8px 24px 4px;
      font-family: var(--font-body);
    }

    /* Overlay */
    .nav-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.6);
      z-index: 1050;
      backdrop-filter: blur(2px);
    }
    .nav-overlay.open { display: block; }

    /* ===========================
       HERO
    =========================== */
    #hero {
      min-height: 100vh;
      background: linear-gradient(135deg, #01036f 0%, #003099 100%);
      display: flex;
      align-items: center;
      position: relative;
      overflow: hidden;
      padding: 120px 0 80px;
    }
    .hero-bg-pattern {
      position: absolute;
      inset: 0;
      background-image:
        /* Grid quadriculado sutil (estilo Leve Inovação) */
        linear-gradient(rgba(255,255,255,0.055) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.055) 1px, transparent 1px),
        /* Manchas amarelas que já existiam */
        radial-gradient(circle at 20% 50%, rgba(252,210,59,0.07) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(252,210,59,0.05) 0%, transparent 40%);
      background-size: 48px 48px, 48px 48px, 100% 100%, 100% 100%;
      pointer-events: none;
    }
    .hero-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 64px;
      align-items: center;
    }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(252,210,59,0.12);
      border: 1px solid rgba(252,210,59,0.25);
      border-radius: 50px;
      padding: 6px 16px 6px 8px;
      margin-bottom: 28px;
    }
    .hero-badge-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--yellow);
      animation: pulse-dot 2s infinite;
    }
    @keyframes pulse-dot {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.6; transform: scale(1.3); }
    }
    .hero-badge span {
      font-family: var(--font-title);
      font-size: 12px;
      font-weight: 600;
      color: var(--yellow);
      letter-spacing: 0.5px;
    }
    .hero-title {
      font-family: var(--font-title);
      font-size: clamp(32px, 4.5vw, 52px);
      font-weight: 900;
      color: var(--white);
      line-height: 1.15;
      margin-bottom: 20px;
    }
    .hero-title span {
      color: var(--yellow);
      display: block;
    }
    .hero-subtitle {
      font-size: 17px;
      color: rgba(255,255,255,0.7);
      line-height: 1.75;
      margin-bottom: 36px;
      max-width: 500px;
    }
    .hero-actions {
      display: flex;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
      margin-bottom: 48px;
    }
    .hero-trust {
      display: flex;
      align-items: center;
      gap: 16px;
      padding-top: 32px;
      border-top: 1px solid rgba(255,255,255,0.1);
      flex-wrap: wrap;
      row-gap: 20px;
    }
    .hero-trust-item {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }
    .hero-trust-value {
      font-family: var(--font-title);
      font-size: 22px;
      font-weight: 800;
      color: var(--yellow);
    }
    .hero-trust-label {
      font-size: 12px;
      color: rgba(255,255,255,0.5);
      line-height: 1.3;
    }
    .hero-trust-divider {
      width: 1px;
      height: 36px;
      background: rgba(255,255,255,0.15);
    }
    .hero-visual {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .hero-wave {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
    }
    .gestou-orb-container {
      position: relative;
      width: 100%;
      height: 620px;
      overflow: visible;
    }
    /* Vinheta escura radial: dá "espaço" preto atrás do orb pra cor azul Gestou
       aparecer limpa, sem se misturar com o azul do fundo do hero */
    .gestou-orb-container::before {
      content: "";
      position: absolute;
      inset: -10%;
      background: radial-gradient(
        ellipse at center,
        rgba(0,0,0,0.75) 0%,
        rgba(0,0,0,0.45) 35%,
        rgba(0,0,0,0) 70%
      );
      pointer-events: none;
      z-index: 0;
    }
    .gestou-orb-container canvas {
      display: block;
      width: 100%;
      height: 100%;
      position: relative;
      z-index: 1;
    }
    @media (max-width: 991px) {
      .gestou-orb-container { height: 460px; }
    }
    @media (max-width: 600px) {
      .gestou-orb-container { height: 360px; }
    }

    /* ===========================
       IMPACT NUMBERS
    =========================== */
    #impact {
      background: var(--yellow);
      padding: 40px 0;
    }
    .impact-phrase {
      display: block;
      text-align: center;
      font-family: var(--font-title);
      font-size: 15px;
      font-weight: 600;
      color: rgba(26,26,46,0.78);
      margin-bottom: 40px;
      padding: 13px 28px;
      background: rgba(26,26,46,0.08);
      border-radius: 50px;
      border: 1px solid rgba(26,26,46,0.1);
    }
    .impact-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 32px;
    }
    .impact-item {
      text-align: center;
      padding: 16px;
    }
    .impact-value {
      font-family: var(--font-title);
      font-size: clamp(32px, 4vw, 48px);
      font-weight: 900;
      color: var(--dark);
      line-height: 1;
      margin-bottom: 8px;
    }
    .impact-label {
      font-size: 14px;
      color: rgba(26,26,46,0.7);
      font-weight: 500;
      line-height: 1.4;
    }
    .impact-divider {
      width: 1px;
      background: rgba(26,26,46,0.15);
      align-self: stretch;
      margin: 8px 0;
    }

    /* ===========================
       SERVICES
    =========================== */
    #services { background: var(--white); }
    .services-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
    }
    .service-card {
      background: var(--gray-100);
      border: 1px solid var(--gray-200);
      border-radius: var(--radius-lg);
      padding: 36px 28px;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }
    .service-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--yellow);
      transform: scaleX(0);
      transition: var(--transition);
      transform-origin: left;
    }
    .service-card:hover {
      box-shadow: var(--shadow-lg);
      transform: translateY(-4px);
      border-color: rgba(252,210,59,0.3);
    }
    .service-card:hover::before { transform: scaleX(1); }
    .service-icon {
      width: 56px;
      height: 56px;
      background: rgba(252,210,59,0.12);
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      font-size: 26px;
      color: var(--yellow-dark);
    }
    .service-card h3 {
      font-family: var(--font-title);
      font-size: 18px;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 12px;
    }
    .service-card p {
      font-size: 14px;
      color: var(--gray-600);
      line-height: 1.7;
      margin-bottom: 20px;
    }
    .service-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-family: var(--font-title);
      font-size: 13px;
      font-weight: 700;
      color: var(--yellow-dark);
      transition: var(--transition);
    }
    .service-link:hover { gap: 10px; }

    /* ===========================
       HOW IT WORKS
    =========================== */
    #how-it-works { background: var(--gray-100); }
    .steps-timeline {
      position: relative;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 0;
    }
    .steps-timeline::before {
      content: '';
      position: absolute;
      top: 36px;
      left: calc(12.5% + 18px);
      right: calc(12.5% + 18px);
      height: 2px;
      background: linear-gradient(to right, var(--yellow), var(--yellow-light), var(--yellow));
      z-index: 0;
    }
    .step-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 0 20px;
      position: relative;
      z-index: 1;
    }
    .step-number {
      width: 72px;
      height: 72px;
      border-radius: 50%;
      background: var(--white);
      border: 3px solid var(--yellow);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: var(--font-title);
      font-size: 22px;
      font-weight: 900;
      color: var(--dark);
      margin-bottom: 24px;
      box-shadow: 0 4px 16px rgba(252,210,59,0.3);
      transition: var(--transition);
      position: relative;
    }
    .step-item:hover .step-number {
      background: var(--yellow);
      transform: scale(1.1);
    }
    .step-icon {
      font-size: 28px;
      margin-bottom: 16px;
      color: var(--yellow-dark);
    }
    .step-title {
      font-family: var(--font-title);
      font-size: 15px;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 8px;
    }
    .step-desc {
      font-size: 13px;
      color: var(--gray-600);
      line-height: 1.6;
    }

    /* ===========================
       FEATURES
    =========================== */
    #features { background: var(--white); }
    .features-layout {
      display: block;
      max-width: 720px;
    }
    .features-list {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    .feature-item {
      display: flex;
      gap: 16px;
      padding: 20px;
      border-radius: var(--radius);
      border: 1px solid transparent;
      transition: var(--transition);
      cursor: default;
    }
    .feature-item:hover {
      background: var(--gray-100);
      border-color: var(--gray-200);
    }
    .feature-icon-wrap {
      flex-shrink: 0;
      width: 44px;
      height: 44px;
      background: rgba(252,210,59,0.1);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      color: var(--yellow-dark);
    }
    .feature-text h4 {
      font-family: var(--font-title);
      font-size: 15px;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 4px;
    }
    .feature-text p {
      font-size: 13px;
      color: var(--gray-600);
      line-height: 1.6;
    }
    .features-visual {
      position: relative;
    }
    .features-video-wrap {
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow-lg);
      border: 1px solid var(--gray-200);
    }
    .features-video-wrap video {
      width: 100%;
      display: block;
    }

    /* ===========================
       PRODUCT SHOWCASE (substitui galeria)
    =========================== */
    #showcase { background: #01036f; padding: 96px 0; }
    #showcase .section-title { color: var(--white); }
    #showcase .section-subtitle { color: rgba(255,255,255,0.6); }
    .showcase-tabs {
      display: flex;
      gap: 8px;
      justify-content: center;
      margin-bottom: 40px;
      flex-wrap: wrap;
    }
    .showcase-tab {
      font-family: var(--font-title);
      font-size: 13px;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 50px;
      border: 1.5px solid rgba(255,255,255,0.15);
      color: rgba(255,255,255,0.6);
      background: transparent;
      cursor: pointer;
      transition: var(--transition);
    }
    .showcase-tab:hover { border-color: var(--yellow); color: var(--yellow); }
    .showcase-tab.active {
      background: var(--yellow);
      border-color: var(--yellow);
      color: var(--dark);
    }
    .showcase-panels { position: relative; }
    .showcase-panel {
      display: none;
      grid-template-columns: 1fr 1fr;
      gap: 48px;
      align-items: center;
    }
    .showcase-panel.active { display: grid; }
    .showcase-screen {
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: var(--radius-lg);
      padding: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 320px;
      position: relative;
      overflow: hidden;
    }
    .showcase-screen-mockup {
      width: 100%;
      max-width: 380px;
      background: var(--white);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 24px 64px rgba(0,0,0,0.5);
    }
    .mockup-bar {
      background: var(--gray-100);
      padding: 10px 16px;
      display: flex;
      align-items: center;
      gap: 6px;
      border-bottom: 1px solid var(--gray-200);
    }
    .mockup-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
    }
    .mockup-dot:nth-child(1) { background: #ff5f57; }
    .mockup-dot:nth-child(2) { background: #febc2e; }
    .mockup-dot:nth-child(3) { background: #28c840; }
    .mockup-url {
      flex: 1;
      background: var(--gray-200);
      border-radius: 4px;
      height: 20px;
      margin-left: 8px;
    }
    .mockup-content {
      padding: 20px;
      min-height: 200px;
      background: var(--white);
    }
    .mockup-row {
      height: 12px;
      background: var(--gray-200);
      border-radius: 4px;
      margin-bottom: 10px;
    }
    .mockup-row.short { width: 60%; }
    .mockup-row.medium { width: 80%; }
    .mockup-card-row {
      display: flex;
      gap: 10px;
      margin-bottom: 12px;
    }
    .mockup-card {
      flex: 1;
      height: 72px;
      background: var(--gray-100);
      border-radius: 8px;
      border: 1px solid var(--gray-200);
    }
    .mockup-highlight {
      height: 40px;
      background: rgba(252,210,59,0.15);
      border: 1px solid rgba(252,210,59,0.3);
      border-radius: 8px;
      margin-bottom: 10px;
    }
    .showcase-info { color: var(--white); }
    .showcase-info h3 {
      font-family: var(--font-title);
      font-size: 26px;
      font-weight: 800;
      margin-bottom: 16px;
    }
    .showcase-info h3 span { color: var(--yellow); }
    .showcase-info p {
      font-size: 15px;
      color: rgba(255,255,255,0.65);
      line-height: 1.75;
      margin-bottom: 24px;
    }
    .showcase-feature-list { display: flex; flex-direction: column; gap: 10px; }
    .showcase-feature-item {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 14px;
      color: rgba(255,255,255,0.75);
    }
    .showcase-feature-item i { color: var(--yellow); font-size: 16px; }

    /* ===========================
       TESTIMONIALS
    =========================== */
    #testimonials { background: var(--gray-100); }
    .testimonials-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }
    .testimonial-card {
      background: var(--white);
      border: 1px solid var(--gray-200);
      border-radius: var(--radius-lg);
      padding: 32px;
      position: relative;
      transition: var(--transition);
    }
    .testimonial-card:hover {
      box-shadow: var(--shadow-lg);
      transform: translateY(-4px);
    }
    .testimonial-text {
      font-size: 14px;
      color: var(--gray-600);
      line-height: 1.75;
      margin-bottom: 24px;
      font-style: italic;
    }
    .testimonial-text::before,
    .testimonial-text::after {
      color: var(--yellow);
      font-family: Georgia, serif;
      font-size: 28px;
      font-weight: 700;
      line-height: 0;
      vertical-align: -0.35em;
    }
    .testimonial-text::before { content: "\201C"; margin-right: 4px; }
    .testimonial-text::after  { content: "\201D"; margin-left: 4px; }
    .testimonial-author {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .testimonial-avatar {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--yellow), var(--yellow-dark));
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: var(--font-title);
      font-size: 16px;
      font-weight: 800;
      color: var(--dark);
      flex-shrink: 0;
    }
    .testimonial-author-info h5 {
      font-family: var(--font-title);
      font-size: 14px;
      font-weight: 700;
      color: var(--dark);
    }
    .testimonial-author-info span {
      font-size: 12px;
      color: var(--gray-600);
    }
    .testimonial-stars {
      display: flex;
      gap: 2px;
      margin-bottom: 16px;
    }
    .testimonial-stars i { color: var(--yellow); font-size: 14px; }
    .testimonial-placeholder-badge {
      position: absolute;
      top: 16px;
      right: 16px;
      background: rgba(252,210,59,0.12);
      border: 1px solid rgba(252,210,59,0.3);
      border-radius: 50px;
      padding: 3px 10px;
      font-size: 10px;
      font-family: var(--font-title);
      font-weight: 600;
      color: var(--yellow-dark);
      letter-spacing: 0.5px;
    }

    /* ===========================
       PRICING
    =========================== */
    #pricing { background: var(--white); }
    .pricing-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 24px;
      align-items: stretch;
      max-width: 820px;
      margin: 0 auto;
    }
    .pricing-card {
      border: 2px solid var(--gray-200);
      border-radius: var(--radius-lg);
      padding: 36px 28px;
      display: flex;
      flex-direction: column;
      transition: var(--transition);
      position: relative;
    }
    .pricing-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-4px); }
    .pricing-card.featured {
      border-color: var(--yellow);
      background: var(--dark);
    }
    .pricing-card.featured .pricing-title,
    .pricing-card.featured .pricing-price,
    .pricing-card.featured .pricing-price-note,
    .pricing-card.featured .pricing-features li,
    .pricing-card.featured .pricing-desc { color: rgba(255,255,255,0.85); }
    .pricing-card.featured .pricing-price { color: var(--yellow); }
    .pricing-badge {
      position: absolute;
      top: -14px;
      left: 50%;
      transform: translateX(-50%);
      background: var(--yellow);
      color: var(--dark);
      font-family: var(--font-title);
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1px;
      padding: 4px 16px;
      border-radius: 50px;
      white-space: nowrap;
    }
    .pricing-title {
      font-family: var(--font-title);
      font-size: 13px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--gray-600);
      margin-bottom: 8px;
    }
    .pricing-price {
      font-family: var(--font-title);
      font-size: 42px;
      font-weight: 900;
      color: var(--dark);
      line-height: 1;
      margin-bottom: 4px;
    }
    .pricing-price sup { font-size: 20px; vertical-align: top; margin-top: 10px; font-weight: 700; }
    .pricing-price sub { font-size: 14px; font-weight: 500; }
    .pricing-price-note {
      font-size: 13px;
      color: var(--gray-600);
      margin-bottom: 8px;
    }
    .pricing-plus {
      font-family: var(--font-title);
      font-size: 13px;
      font-weight: 600;
      color: var(--yellow-dark);
      background: rgba(252,210,59,0.1);
      border-radius: 8px;
      padding: 8px 12px;
      margin-bottom: 16px;
      display: inline-block;
    }
    .pricing-card.featured .pricing-plus {
      background: rgba(252,210,59,0.15);
    }
    .pricing-desc {
      font-size: 13px;
      color: var(--gray-600);
      margin-bottom: 20px;
      line-height: 1.6;
      flex: 1;
    }
    .pricing-divider {
      height: 1px;
      background: var(--gray-200);
      margin: 20px 0;
    }
    .pricing-card.featured .pricing-divider { background: rgba(255,255,255,0.1); }
    .pricing-features {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-bottom: 28px;
    }
    .pricing-features li {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      font-size: 13px;
      color: var(--gray-600);
      line-height: 1.5;
    }
    .pricing-features li i { color: #22c55e; font-size: 15px; flex-shrink: 0; margin-top: 1px; }
    .pricing-cta { margin-top: auto; }

    /* ===========================
       CTA FINAL
    =========================== */
    #cta-final {
      background: linear-gradient(135deg, #01036f 0%, #003099 100%);
      padding: 96px 0;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    #cta-final::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 50% 50%, rgba(252,210,59,0.08) 0%, transparent 60%);
    }
    #cta-final .section-title { color: var(--white); }
    #cta-final .section-subtitle { color: rgba(255,255,255,0.65); max-width: 520px; margin: 0 auto 36px; }
    .cta-actions {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
      flex-wrap: wrap;
    }
    .cta-note {
      font-size: 13px;
      color: rgba(255,255,255,0.4);
      margin-top: 20px;
    }

    /* ===========================
       FOOTER
    =========================== */
    #footer { background: #01036f; padding: 56px 0 0; }
    .footer-grid {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr;
      gap: 48px;
      margin-bottom: 48px;
    }
    .footer-brand img { height: 34px; margin-bottom: 16px; }
    .footer-brand p {
      font-size: 13px;
      color: rgba(255,255,255,0.4);
      line-height: 1.7;
      max-width: 280px;
      margin-bottom: 20px;
    }
    .footer-social {
      display: flex;
      gap: 10px;
    }
    .footer-social a {
      width: 36px;
      height: 36px;
      border-radius: 8px;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      color: rgba(255,255,255,0.5);
      font-size: 16px;
      transition: var(--transition);
    }
    .footer-social a:hover { background: var(--yellow); border-color: var(--yellow); color: var(--dark); }
    .footer-col h5 {
      font-family: var(--font-title);
      font-size: 13px;
      font-weight: 700;
      color: var(--white);
      margin-bottom: 20px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .footer-col ul { display: flex; flex-direction: column; gap: 10px; }
    .footer-col ul li a {
      font-size: 13px;
      color: rgba(255,255,255,0.45);
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .footer-col ul li a:hover { color: var(--yellow); }
    .footer-bottom {
      border-top: 1px solid rgba(255,255,255,0.06);
      padding: 20px 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      flex-wrap: wrap;
    }
    .footer-bottom p {
      font-size: 12px;
      color: rgba(255,255,255,0.25);
    }
    .footer-bottom a {
      font-size: 12px;
      color: rgba(255,255,255,0.35);
      transition: var(--transition);
    }
    .footer-bottom a:hover { color: var(--yellow); }

    /* ===========================
       BACK TO TOP
    =========================== */
    .back-to-top {
      position: fixed;
      bottom: 24px;
      right: 24px;
      width: 44px;
      height: 44px;
      background: var(--yellow);
      color: var(--dark);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      opacity: 0;
      visibility: hidden;
      transition: var(--transition);
      box-shadow: var(--shadow);
      z-index: 999;
    }
    .back-to-top.visible { opacity: 1; visibility: visible; }
    .back-to-top:hover { background: var(--yellow-dark); transform: translateY(-3px); }

    /* ===========================
       RESPONSIVE
    =========================== */
    @media (max-width: 991px) {
      .nav-desktop { display: none; }
      .nav-toggle { display: flex; align-items: center; }
      .nav-mobile { display: flex; }

      .hero-grid { grid-template-columns: 1fr; gap: 48px; }
      .hero-visual { display: none; }
      .hero-title { font-size: clamp(28px, 6vw, 40px); }

      .impact-grid { grid-template-columns: repeat(2, 1fr); }
      .impact-divider { display: none; }

      .services-grid { grid-template-columns: 1fr; }
      .steps-timeline {
        grid-template-columns: 1fr 1fr;
        gap: 32px;
      }
      .steps-timeline::before { display: none; }

      .features-layout { grid-template-columns: 1fr; gap: 40px; }
      .showcase-panel.active { grid-template-columns: 1fr; }
      .showcase-screen { min-height: 240px; }
      .testimonials-grid { grid-template-columns: 1fr; }
      .pricing-grid { grid-template-columns: 1fr; max-width: 420px; margin: 0 auto; }
      .pricing-card.featured { order: -1; }
      .footer-grid { grid-template-columns: 1fr; gap: 32px; }
      .footer-bottom { flex-direction: column; text-align: center; gap: 8px; }
    }

    @media (max-width: 575px) {
      .section-pad { padding: 64px 0; }
      .hero-actions { flex-direction: column; align-items: flex-start; }
      .hero-trust { flex-wrap: wrap; gap: 16px; }
      .impact-grid { grid-template-columns: 1fr 1fr; gap: 20px; }
      .steps-timeline { grid-template-columns: 1fr; }
      .cta-actions { flex-direction: column; align-items: center; }
      .showcase-tabs { gap: 6px; }
      .showcase-tab { font-size: 12px; padding: 8px 14px; }
    }

    /* AOS override */
    [data-aos] { opacity: 0; }
    [data-aos].aos-animate { opacity: 1; }
  </style>
</head>

<body>

<!-- Google Tag Manager (noscript) — usa o mesmo ID definido no <head> -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXXX"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- ======= HEADER ======= -->
<header id="header">
  <div class="container">
    <div class="header-inner">
      <a href="#hero" class="logo">
        <img src="/img/gestou-logo.png" alt="Gestou">
      </a>

      <!-- Desktop Navigation -->
      <nav class="nav-desktop">
        <a href="#hero" class="active">Início</a>
        <a href="#services">Serviços</a>
        <a href="#how-it-works">Como Funciona</a>
        <a href="#features">Recursos</a>
        <a href="#pricing">Planos</a>
        <a href="#testimonials">Depoimentos</a>
        <a href="/app/login" class="nav-cta-collaborator">
          <i class="bi bi-person-circle"></i> Colaborador
        </a>
        <a href="/admin/login" class="nav-cta-admin">
          Administrador <i class="bi bi-arrow-right"></i>
        </a>
      </nav>

      <!-- Mobile Toggle -->
      <button class="nav-toggle" id="navToggle" aria-label="Abrir menu">
        <i class="bi bi-list"></i>
      </button>
    </div>
  </div>
</header>

<!-- Overlay -->
<div class="nav-overlay" id="navOverlay"></div>

<!-- Mobile Drawer -->
<nav class="nav-mobile" id="navMobile">
  <div class="nav-mobile-header">
    <img src="/img/gestou-logo.png" alt="Gestou">
    <button class="nav-mobile-close" id="navClose" aria-label="Fechar menu">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>

  <div class="nav-mobile-ctas">
    <p class="nav-mobile-note">Acesso rápido</p>
    <a href="/app/login" class="nav-mobile-cta-collaborator">
      <i class="bi bi-person-circle"></i> Acessar como Colaborador
    </a>
    <a href="/admin/login" class="nav-mobile-cta-admin">
      <i class="bi bi-buildings"></i> Acesso Administrador
    </a>
  </div>

  <div class="nav-mobile-links">
    <a href="#hero"><i class="bi bi-house"></i> Início</a>
    <a href="#services"><i class="bi bi-grid-3x3-gap"></i> Serviços</a>
    <a href="#how-it-works"><i class="bi bi-signpost-split"></i> Como Funciona</a>
    <a href="#features"><i class="bi bi-stars"></i> Recursos</a>
    <a href="#pricing"><i class="bi bi-tag"></i> Planos</a>
    <a href="#testimonials"><i class="bi bi-chat-quote"></i> Depoimentos</a>
    <div class="divider"></div>
    <a href="/validar"><i class="bi bi-shield-check"></i> Validar Holerite</a>
    <a href="/download"><i class="bi bi-download"></i> Download do App</a>
  </div>
</nav>

<!-- ======= HERO ======= -->
<section id="hero">
  <div class="hero-bg-pattern"></div>
  <div class="container">
    <div class="hero-grid">
      <div data-aos="fade-right" data-aos-duration="700">
        <div class="hero-badge">
          <div class="hero-badge-dot"></div>
          <span>Plataforma de DP Digital</span>
        </div>
        <h1 class="hero-title">
          Seu Departamento Pessoal
          <span>sem papel, sem burocracia.</span>
        </h1>
        <p class="hero-subtitle">
          Automatize holerites, avisos, espelhos de ponto e muito mais. Seus colaboradores assinam digitalmente — de qualquer lugar, de qualquer dispositivo.
        </p>
        <div class="hero-actions">
          <a href="https://wa.me/5516999915755?text=Quero%20saber%20mais%20sobre%20a%20Plataforma%20Gestou" class="btn btn-primary btn-lg" target="_blank" rel="noopener">
            <i class="bi bi-whatsapp"></i> Quero uma Demonstração
          </a>
          <a href="#how-it-works" class="btn btn-outline btn-lg">
            Ver como funciona
          </a>
        </div>
        <div class="hero-trust">
          <div class="hero-trust-item">
            <div class="hero-trust-value">48.000+</div>
            <div class="hero-trust-label">Documentos<br>gerenciados</div>
          </div>
          <div class="hero-trust-divider"></div>
          <div class="hero-trust-item">
            <div class="hero-trust-value">96.000+</div>
            <div class="hero-trust-label">Folhas de papel<br>eliminadas</div>
          </div>
          <div class="hero-trust-divider"></div>
          <div class="hero-trust-item">
            <div class="hero-trust-value">100%</div>
            <div class="hero-trust-label">Digital e<br>sem papel</div>
          </div>
        </div>
      </div>
      <div class="hero-visual" data-aos="fade-left" data-aos-duration="700" data-aos-delay="200">
        <div class="gestou-orb-container">
          <canvas id="gestou-orb"></canvas>
        </div>
      </div>
    </div>
  </div>
  <svg class="hero-wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none">
    <path fill="#FCD23B" fill-opacity="1" d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z"></path>
  </svg>
</section>

<!-- ======= IMPACT NUMBERS ======= -->
<section id="impact">
  <div class="container">
    <p class="impact-phrase" data-aos="fade-up">
      🌱 Papel acumula, arquivo lota, assinatura atrasa. Com holerite digital, seu DP fica leve — e o meio ambiente também.
    </p>
  </div>
</section>

<!-- ======= SERVICES ======= -->
<section id="services" class="section-pad">
  <div class="container">
    <div class="section-header" data-aos="fade-up">
      <div class="section-label">Serviços</div>
      <h2 class="section-title">Tudo que seu DP precisa,<br><span>em um só lugar</span></h2>
      <p class="section-subtitle">A Gestou conecta gestores de DP e colaboradores de forma simples, segura e eficiente.</p>
    </div>
    <div class="services-grid">
      <div class="service-card" data-aos="fade-up" data-aos-delay="0">
        <div class="service-icon"><i class="bi bi-buildings"></i></div>
        <h3>Portal Administrativo</h3>
        <p>Área completa para gestores de DP gerenciarem todos os documentos dos colaboradores: holerites, espelhos de ponto, avisos de férias e muito mais. Envio em massa, controle de leitura e aceite em tempo real.</p>
        <a href="/admin/login" class="service-link">Acessar admin <i class="bi bi-arrow-right"></i></a>
      </div>
      <div class="service-card" data-aos="fade-up" data-aos-delay="100">
        <div class="service-icon"><i class="bi bi-phone"></i></div>
        <h3>App do Colaborador</h3>
        <p>Interface simples e intuitiva para smartphones. O colaborador acessa seus documentos, assina digitalmente os holerites e se comunica com o RH — de qualquer lugar, a qualquer hora.</p>
        <a href="/app/login" class="service-link">Acessar app <i class="bi bi-arrow-right"></i></a>
      </div>
      <div class="service-card" data-aos="fade-up" data-aos-delay="200">
        <div class="service-icon"><i class="bi bi-headset"></i></div>
        <h3>Painel RH</h3>
        <p>Canal exclusivo de comunicação entre gestores e colaboradores. Transparência, agilidade e rastreabilidade em todas as interações do Departamento Pessoal com a equipe.</p>
        <a href="#features" class="service-link">Saiba mais <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- ======= HOW IT WORKS ======= -->
<section id="how-it-works" class="section-pad">
  <div class="container">
    <div class="section-header center" data-aos="fade-up">
      <div class="section-label">Como Funciona</div>
      <h2 class="section-title">Do cadastro ao aceite digital<br><span>em 4 passos simples</span></h2>
      <p class="section-subtitle">O gestor de DP tem o controle total do processo. Rápido, seguro e sem papel.</p>
    </div>
    <div class="steps-timeline">
      <div class="step-item" data-aos="fade-up" data-aos-delay="0">
        <div class="step-number">1</div>
        <div class="step-icon"><i class="bi bi-building-add"></i></div>
        <div class="step-title">Cadastra a Empresa</div>
        <div class="step-desc">Configure a empresa e o plano em minutos. A implementação é 100% gratuita e assistida pela equipe Gestou.</div>
      </div>
      <div class="step-item" data-aos="fade-up" data-aos-delay="100">
        <div class="step-number">2</div>
        <div class="step-icon"><i class="bi bi-people"></i></div>
        <div class="step-title">Importa os Funcionários</div>
        <div class="step-desc">Importe sua equipe em lote via planilha ou cadastre individualmente. Cada colaborador recebe acesso automático via e-mail.</div>
      </div>
      <div class="step-item" data-aos="fade-up" data-aos-delay="200">
        <div class="step-number">3</div>
        <div class="step-icon"><i class="bi bi-file-earmark-arrow-up"></i></div>
        <div class="step-title">Envia os Documentos</div>
        <div class="step-desc">Faça upload de holerites, espelhos de ponto e avisos. Notificações automáticas chegam ao e-mail de cada colaborador.</div>
      </div>
      <div class="step-item" data-aos="fade-up" data-aos-delay="300">
        <div class="step-number">4</div>
        <div class="step-icon"><i class="bi bi-patch-check"></i></div>
        <div class="step-title">Recebe o Aceite Digital</div>
        <div class="step-desc">O colaborador assina digitalmente pelo celular. O admin acompanha em tempo real quem assinou e quem está pendente.</div>
      </div>
    </div>
  </div>
</section>

<!-- ======= FEATURES ======= -->
<section id="features" class="section-pad">
  <div class="container">
    <div class="features-layout">
      <div data-aos="fade-right">
        <div class="section-label">Diferenciais</div>
        <h2 class="section-title">Por que escolher<br><span>a Gestou?</span></h2>
        <p class="section-subtitle" style="margin-bottom: 36px;">Uma plataforma pensada para a realidade do DP brasileiro.</p>
        <div class="features-list">
          <div class="feature-item">
            <div class="feature-icon-wrap"><i class="bi bi-fingerprint"></i></div>
            <div class="feature-text">
              <h4>Aceite Digital com Validade Jurídica</h4>
              <p>Cada assinatura é registrada com data, hora e IP — substituindo a coleta física com segurança legal.</p>
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon-wrap"><i class="bi bi-bell"></i></div>
            <div class="feature-text">
              <h4>Notificações Automáticas</h4>
              <p>O colaborador é notificado no celular assim que um novo documento é disponibilizado. Zero ligações, zero papel.</p>
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon-wrap"><i class="bi bi-shield-lock"></i></div>
            <div class="feature-text">
              <h4>Segurança e Rastreabilidade</h4>
              <p>Acesso por perfil, histórico de ações e documentos criptografados. Conformidade com LGPD.</p>
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon-wrap"><i class="bi bi-clock-history"></i></div>
            <div class="feature-text">
              <h4>Economia Real de Tempo</h4>
              <p>Elimine impressão, envelopes, arquivamento físico e retrabalho. Seu DP foca no que importa.</p>
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon-wrap"><i class="bi bi-rocket-takeoff"></i></div>
            <div class="feature-text">
              <h4>Implementação Gratuita</h4>
              <p>Nossa equipe acompanha todo o onboarding. Você não paga nada para colocar o Gestou em funcionamento.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ======= PRODUCT SHOWCASE ======= -->
<section id="showcase">
  <div class="container">
    <div class="section-header center" data-aos="fade-up">
      <div class="section-label" style="background:rgba(252,210,59,0.1);border-color:rgba(252,210,59,0.2);">Plataforma</div>
      <h2 class="section-title" style="color:#fff;">Conheça a plataforma<br><span>por dentro</span></h2>
      <p class="section-subtitle" style="color:rgba(255,255,255,0.55);">Desenvolvida para ser simples para o colaborador e poderosa para o gestor.</p>
    </div>
    <div class="showcase-tabs" data-aos="fade-up" data-aos-delay="100">
      <button class="showcase-tab active" data-panel="admin">Portal Administrativo</button>
      <button class="showcase-tab" data-panel="app">App Colaborador</button>
      <button class="showcase-tab" data-panel="rh">Painel RH</button>
    </div>
    <div class="showcase-panels">
      <!-- Admin Panel -->
      <div class="showcase-panel active" id="panel-admin" data-aos="fade-up">
        <div class="showcase-screen" style="padding:12px;">
          <img src="data:image/png;base64,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netPvQ1Y1JGywk4iNnESJsIH8pwAe5OgF9huIYXPk6zBMWlraZkNY+qinpYGzKuexrXtcxz2dGxUXO1edq16qEFK6IqgdzRZV4JRZKTYNHBiVUxWtzIKl6uiV7atkudbSZjbxNVq2jvdy+cqKpZ12XuGTvidLiWUdZJHWVNVDNL/AFTqfSRo1kbVZNnKxqoupHMSy6kTWi+Zg15yWHM3n0/FGjD0HEstcNqVxVYnYlE2rajo2xI6J6zcHjZpHyNm85NIzOzXtfqVVRUc5VJsZ8IkdU580dRitYtTW0lRVQVSojHRRNcj6fOz3K6NXOvrREW63TVr84AjJYWz0f7fQ0YeiSZc0nCqdy4ji9YsXCFWrqqe02ZI6JzYWqydrmMasarnNen57kzbKqLwuLzQVOLVlRStmbTyzvfEkz8+RGq5VTOdxuttXjU1QZMLAowvNTEWAAZx6t+SP+sLkx+9/wApMf0Befz+/JH/AFhMmP3v+UmP6AvPOPLD8bT7MfOpq4/nIZDXT9NH/fT7zYkNfZKxdf56bE6z5WGFZgw0icyXu3bhpE5kvdu3EDMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DMGGkTmS927cNInMl7t24DJdhX13ypP7ifepvLIlvzJe7duNCsW9Si2cnmJ+c1U415SR8bxB3GG8QdxkCSg+Ur/cX70N8r6JbVCrZy+Yv5rVXjTkN3SJzJe7duJGYMNInMl7t24aROZL3btxAzBhpE5kvdu3DSJzJe7duAzBhpE5kvdu3DSJzJe7duAzBhpE5kvdu3DSJzJe7duAzBhpE5kvdu3DSJzJe7duAzBhpE5kvdu3DSJzJe7duAzBhpE5kvdu3DSJzJe7duAzBhpE5kvdu3DSJzJe7duAzBhpE5kvdu3DSJzJe7duAzBhpE5kvdu3DSJzJe7duAzBhpE5kvdu3DSJzJe7duAzBhpE5kvdu3DSJzJe7duAzBhpE5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lC3iDuMN4g7jLIT4T8sX7NfvQtSqwn5Yv2a/ehalZWAAQNSspc9Vkj/O405TQVFRbKioqF0Rywxy/nt18vGZqMW2yVJpuqmyPb+a9yepQ573fnOcvrU3H0HMk9qEfAZecz2qZoxKFdGWqDa4DNzme1dw4DNzme1dxPWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbXAZucz2ruHAZucz2ruHWU95oy1QbjaB/9qRqerWTxUkTNaor16ys4tMEUy1KWmdKt1u1nLylkxqNajWpZE2H0GvXXNTJEWAAUS1sT+RP9bfvQroixxP5E/wBbfvQroi0bkS2WcRImwjZxEibCUP5Vg+g96dR8B9AHwH0AfAfQB8B9AHwH0Aeqfkk/rB5M/vf8pMfv55+AvySv1g8mf3v+UmP3688z8s/x1HsR86mnmPOQyEMfyiL7Rv3oTSEMfyiL7Rv3ofItddAAosAAAAAONxx8cKZQUsrmtr6yphWgav58lo4kYrOXNka9dWyyqtjsgCZkYqr9dmtXkuv/ALEVRHJK5qIjEam1c7X9xOCBpJSzar6NOXWur4BKWbVfRpy611fA3QE6UtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAJSzar6NOXWur4G6AaUtJKWbVfRpy611fAlpYZI3Xfm604lubABeQABAAAC7CpxX5Yn2afepbLsKnFflifZp96k0olC3iDuMN4g7jLIT4T8sX7NfvQtSqwn5Yv2a/ehalZWAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAANbE/kT/W370K6IscT+RP8AW370K6ItG5EtlnESJsI2cRImwlD+VgAPenUA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/hP3DymwP07+E/cNey3Ep5wapj+CeUrgFP5TYH6d/CfuHlNgfp38J+4a9luJTzg1TH8E8pXAKfymwP07+E/cPKbA/Tv4T9w17LcSnnBqmP4J5SuAU/lNgfp38J+4eU2B+nfwn7hr2W4lPODVMfwTylcAp/KbA/Tv4T9w8psD9O/hP3DXstxKecGqY/gnlK4BT+U2B+nfwn7h5TYH6d/CfuGvZbiU84NUx/BPKVwCn8psD9O/hP3DymwP07+E/cNey3Ep5wapj+CeUrgFP5TYH6d/CfuHlNgfp38J+4a9luJTzg1TH8E8pb+J/In+tPvQroiOuyjwaWlexlZdy2smifyp1GlHjmFptqv4btxaM9lrftKecInKZjwTyldM4iRNhTtx/CE21f8ADfuJPKHB7fLP4b9xOvZXiU84NUzHgnlL8nVGOY2irbGMQT95fvNV2P4789Yl70/eAfOuwwXH8ev/AI7xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8eUGPfPeJe9P3gAPKDHvnvEven7x5QY9894l70/eAA8oMe+e8S96fvHlBj3z3iXvT94ADygx757xL3p+8xkygx5G6sbxP3p+8ADjMdytyqjxR7I8psaY1L6m10qJ/rFbJljlcmzKrHP/AN4S/iALQ3sPc2aTK/KxzfOyoxtfXXy/iNSbLLK9J1RMqsdROTxhL+IAmESwpMssr3VCo7KvHVS+xcQl/EbcOWGVq1SIuVGNql9nD5fxAEoluYhlblU2aFG5TY01FVL2rpdf/iN3KPKnKeKjhdFlHjEaq3Wra2RL/EAKuWky0yxRVtlZj235xl/EQLlrlln/AP7W4/8A/vGb8QBMEpaLLTLF01nZWY8qdeIy/iLabK/KxIFVMqMbRf8A6+X8QBKFdHlnlgrlvlXju35wl/Eby5X5W6NF8qMb9/l/EATC87mEGWGVqvVFypxxf/8AYS/iNevyyyvbM1G5VY61OrEJfxAEyxVbnV4HlPlLJTsWTKHF3rm7XVsi/wC8tpcosoEhumO4oi//AFcm8AhrypZcqMpkmsmUWL2/+tk3n2TKjKZHpbKLF/fZN4BkVbMWU2Ui2vlBiy/vkm83Yco8oVbrx3FF/e5N4BC0PkmUeUKbMexT3uTeQtylyiz/APH+K++SbwCBtsyiygzf8e4n73JvMJco8oUVtsdxRP3uTeAEPj8o8obf49xT3uTeRrlJlFnJ/h7FffJN4ASymyjyhRG2x7FE/e5N4dlHlDb/AB9invcm8AD7HlHlCrdePYp73JvD8o8oc5v+HsU97k3gART5SZRI9LY/iqfvkm8kTKPKHN/x9invcm8AJZMyjyhVF/w7invcm8+vyiygzE/w7invcm8AmEK7EMp8pGp5uUOLN9VbJvMHZUZS8EV3lDi9+Xhsm8AlCXB8pspJIrvygxZy9dZIv+833ZR5Q2X/AA7invcm8ADWXKXKPPX/AA/ivvkm8zTKTKK3+P8AFffJN4BAxjykyiWZEXH8Vt/9ZJvJJMpMoUdqx7FPfJN4BKWnJlNlIlRZMocWtycMk3ksmUuUaOS2UGK++SbwAiU0OUmUStW+PYqv75JvNafKbKRH6soMWT98k3gASw5S5Rqx18fxVdXpkm8yp8pMolicq4/iqr/9ZJvAITKFuU2Ueev/AOYMW98k3mUOUuUayWXKDFV/fJN4BKiRuUmUV1/w/ivvkm8jXKXKPPt4/wAV98k3gCEpW5SZRW/x/ivvkm8zhyjyhXOvj2KL+9ybwCFoZRZR5QrIiLj2KL+9ybzcTKDHrf47xL3p+8Aw1pffKDHvnvEven7x5QY9894l70/eAUDygx757xL3p+8eUGPfPeJe9P3gEB5QY9894l70/efUx/Hbf47xL3p+8Akf/9k=" alt="Portal Administrativo Gestou" style="width:100%;border-radius:8px;box-shadow:0 8px 32px rgba(0,0,0,0.4);display:block;">
        </div>
        <div class="showcase-info">
          <h3>Controle total do <span>Departamento Pessoal</span></h3>
          <p>O gestor tem visibilidade completa sobre todos os documentos, colaboradores e pendências. Envie em massa, filtre por status e acompanhe o aceite em tempo real.</p>
          <div class="showcase-feature-list">
            <div class="showcase-feature-item"><i class="bi bi-check-circle-fill"></i> Envio em massa de holerites e documentos</div>
            <div class="showcase-feature-item"><i class="bi bi-check-circle-fill"></i> Painel de pendências e aceites em tempo real</div>
            <div class="showcase-feature-item"><i class="bi bi-check-circle-fill"></i> Histórico completo por colaborador</div>
            <div class="showcase-feature-item"><i class="bi bi-check-circle-fill"></i> Relatórios exportáveis</div>
          </div>
        </div>
      </div>
      <!-- App Collaborator -->
      <div class="showcase-panel" id="panel-app">
        <div class="showcase-screen" style="padding:24px; display:flex; justify-content:center;">
          <img src="data:image/png;base64,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" alt="App Colaborador Gestou" style="max-width:200px;border-radius:16px;box-shadow:0 8px 32px rgba(0,0,0,0.5);display:block;">
        </div>
        <div class="showcase-info">
          <h3>Na palma da mão do <span>colaborador</span></h3>
          <p>Interface projetada para ser simples e intuitiva. O colaborador acessa seus documentos, visualiza holerites e assina com um toque — sem complicação.</p>
          <div class="showcase-feature-list">
            <div class="showcase-feature-item"><i class="bi bi-check-circle-fill"></i> Acesso via smartphone (Android e iOS)</div>
            <div class="showcase-feature-item"><i class="bi bi-check-circle-fill"></i> Aceite digital com um toque</div>
            <div class="showcase-feature-item"><i class="bi bi-check-circle-fill"></i> Histórico de todos os documentos recebidos</div>
            <div class="showcase-feature-item"><i class="bi bi-check-circle-fill"></i> Notificação push para novos documentos</div>
          </div>
        </div>
      </div>
      <!-- RH Panel -->
      <div class="showcase-panel" id="panel-rh">
        <div class="showcase-screen" style="padding:12px;">
          <img src="data:image/png;base64,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AAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP57ej8Rkfz29H4gAMj+e3o/EZH89vR+IADI/nt6PxGR/Pb0fiAAyP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dL613WNQznS+td1l4C0FWoZzpfWu6xqGc6X1ruscBaCrUM50vrXdY1DOdL613WOAtBVqGc6X1rusahnOl9a7rHAWgq1DOdL613WNQznS+td1jgLQVahnOl9a7rGoZzpfWu6xwFoKtQznS+td1jUM50vrXdY4C0FWoZzpfWu6xqGc6X1ruscBaCrUM50vrXdY1DOdL613WOAtBVqGc6X1rusahnOl9a7rHAWgq1DOdL613WNQznS+td1jgLQVahnOl9a7rGoZzpfWu6xwFoKtQznS+td1jUM50vrXdY4C0FWoZzpfWu6xqGc6X1ruscBaCrUM50vrXdY1DOdL613WOAtBVqGc6X1rusahnOl9a7rHAWgq1DOdL613WNQznS+td1jgLQVahnOl9a7rGoZzpfWu6xwFoKtQznS+td1jUM50vrXdY4C0FWoZzpfWu6xqGc6X1ruscBaCrUM50vrXdY1DOdL613WOAtBVqGc6X1rusahnOl9a7rHAWgq1DOdL613WNQznS+td1jgLQVahnOl9a7rGoZzpfWu6xwFoKtQznS+td1jUM50vrXdY4C0FWoZzpfWu6xqGc6X1ruscBaCrUM50vrXdY1DOdL613WOAtBVqGc6X1rusahnOl9a7rHAWgq1DOdL613WNQznS+td1jgLQVahnOl9a7rGoZzpfWu6xwFoKtQznS+td1jUM50vrXdY4C0FWoZzpfWu6xqGc6X1ruscBaCrUM50vrXdY1DOdL613WOAtBVqGc6X1rusahnOl9a7rHAWgq1DOdL613WNQznS+td1jgLQVahnOl9a7rGoZzpfWu6xwFoKtQznS+td1jUM50vrXdY4C0FWoZzpfWu6xqGc6X1ruscBaCrUM50vrXdY1DOdL613WOAtBVqGc6X1rusahnOl9a7rHAWgq1DOdL613WNQznS+td1jgLQVahnOl9a7rGoZzpfWu6xwFoKtQznS+td1jUM50vrXdY4D8m/L/ADVq/LXiNDSVfYzZljc5yRtfwU0KpwnIUtXW0WKpQYjUR1DJI1kinRiMVLcKKibOA7H5e6Ctf8smJVlA6BXU7o2qk7nbc1NDyXU4+LC6qqqZKrFZolkWJ0MbIEXKxHJZVuu1VLwF9Li9PUSRNSGojZOqpDK9lmvW19m2/ByoUs0go3RpNqapIM+R0qxd4xb22rcowrBZqOaF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gSIv8KP0vYo1beV/TUi9jczNrvC5y8ilFgI6tvK/pqNW3lf01IJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQCfPO9FPaSK0Y3WuS7vBT/MvnJatvK/pqUSBHVt5X9NRq28r+mpBIEdW3lf01Grbyv6agSBHVt5X9NRq28r+moEgR1beV/TUatvK/pqBIEdW3lf01Grbyv6agSBHVt5X9NRq28r+moEgR1beV/TUatvK/pqBIEdW3lf01Grbyv6agSBHVt5X9NRq28r+moEgR1beV/TUatvK/pqBIEdW3lf01Grbyv6agSBHVt5X9NRq28r+moEgR1beV/TUatvK/pqBIEdW3lf01Grbyv6agSBHVt5X9NRq28r+moEgR1beV/TUatvK/pqBIEdW3lf01Grbyv6agSIv8KP0vYo1beV/TUi9jczNrvC5y8ilFgI6tvK/pqNW3lf01IJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AkCOrbyv6ajVt5X9NQJAjq28r+mo1beV/TUCQI6tvK/pqNW3lf01AQ/Ms9FCRGH5lnooSApq/Ab6XsUqaW1fgN9L2KVNLCJtLI/CK2lkfhBVgAIPycAD3b6AAAAAAAAAAAAAB6B8g/631f8Pf8AzIz2pTxX5B/1vq/4e/8AmRntSnmO1feJ+ENNfNBx8h+fZ9a/kfXHyH59n1r+RzWDLABiqLPCk9L2ISIs8KT0vYhIAAAAAAAAARf4UfpexSRF/hR+l7FAkAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIp8870U9pIinzzvRT2kgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAARf4UfpexSRF/hR+l7FAkAAAAAAAAAAAAAAAAAAABg4ni1Dh+yom79dqMal3GFdym3G1XOIZ0UVXJ2aYzLOBz/dbhviavoN94d1uG+Iq+g33j5vxDTeeH0bhqfJLoAc/3W4b4ir6DfeLINKcLlejXa+K/G9iW+5VEa/TTONuCdDqIjOxLeFVZVU9HTuqKqZkMTeFzlshOKRksbZI3texyXRzVuinD/K3I9IcOiRy5HOkcqcqplt+a7zp6WzF+7TRnm+SeDed2GjnlH8GT3R3Y6OeUfwJPdPJAdz8IseM/T7MNqXrfdjo55R/Ak90d2OjnlH8CT3TyQD8IseM/T7G1L2XDdIsGxGoSnpK5j5V4Gua5qr9WZEubQ8IhkfDMyWNytexyOaqcSpwHu5zNfo6dNNOzPCWUTkABz1AAAAAAAAAAAAAAAARh+ZZ6KEiMPzLPRQkBTV+A30vYpU0tq/Ab6XsUqaWETaWR+EVtLI/CCrAAQfk4AHu30AAAAAAAAAAAAAD0D5B/wBb6v8Ah7/5kZ7Up4r8g/631f8AD3/zIz2pTzHavvE/CGmvmg4+Q/Ps+tfyPrj5D8+z61/I5rBlgAxVFnhSel7EJEWeFJ6XsQkAAAGM1uszOc6S+dybHqibFVOI+omSWPK59nOVFRXKvEq8f1BqSMzN1TnJmVUVFTjW/Gp9akj5Y1WNzEat1VVTkVOJfOBeAABF/hR+l7FJEX+FH6XsUCRrdI8SXC8OWaJiS1Ej2xQRr/neq7ENkc1juDV+MaQRLJLJS0NNHmilieiPWRV2240+HnN2npomv888ISWZhWMvqsDqauaJrKuk1jZ4k4Ee2+z6lLtFsSlxbBIa6aNkcj1cjkZe2xVTjNJBgGJYdiVWylmlq6SupXtmknkTMkllyqvGvJfzqR0XZpPhdLT4e/BYlp2yd/ItQy6IrrquxeK59VyzaqoqmiY5xMcccOOY4/qZZmjOkyYliNbQ1TYoZYXOWPKtkcxFst78af8ArgK8K0tjrK3E1dGxtDRxLIx6Iud6Itvv4jX0+h1RU09Ss7uw6pax7o5WqjldE5LKi2XgXbsXz8pl0mjDo8TxaBsSQ0FRSshheioq3ypdbcN7pdb8Jsrp0masT4fxnHx+6cUO6TSB9AuLx4PT9rku6yyf2itRbX4fYZeJaVNbS0C4bSuqaqvS8Ubltl222/bdPsU1raDS2HBnYAykpJKdWrGlSkiJZirt2Kt+PkMiu0Zq6OnwupwuWJ9VhzVRzZNjZLqrl+raq/YplNGn2ozjnOMT3Y4Z+ZxZ0GLYzRUlXVY9h0EMMMedr4ZEXMt0RG2uu3bwmA/STSCKhbi8uD06Yc6zrJJ/aI1Vsi8PsLaOXE9KsHrIKuCmpaaRmRjmuVXpIjkVLpxJs4Fsphy0OlsuDNwB9JSJTojY1qUkTwEXZsvfiTiJRRbiZiuKYnPHj3fpx5jsKWriqcPjrYbrHJGkjb7FsqXOQwrSfGsQRr2S4DCjpMqRzSubJuzHV0NE2jwmKgjdmSKJI0cvHs4Ti8BwjFcPiZFPorS1b2yZtc+ePMn3rwGrT02pivOP0zj9fGYWWzqtI8Unxupw/C6aitTOyL2TLlc9f/lS6cnn+8txzHcXonYXTR0lJFV1l0kbM5XNYt0S10VOUwdJMMxevrKlF0foKlHKqQ1LZcjkbxK7vkVVQ+VGi9fPHgVNV2qoqfOlUqyWs1XItk412bNnIbqadP8Almcfv3fHx7pwnFfHpRiMDsSpa6mpFqqSn1zXQOVY14Ni7b/5kLNH8dxfEamm1s+BauXa6KOVdciW5t12mZX6O0dPgNfS4RRMjmniVqd8qq7zXcprtGaDEKKejZPovSxrGmV9XrmK9Nm11k2mObFduqqmIz+uPDwz4+GTit7osYxGtqIcAw2GaGndldLM+yOXzbU5DJlx2vgxPCKGqoooZKxF1zc+ZWLeyWVNnnMClw3SLAKyqTCKemraSokzta96NVi/aqf+k4jIq8NxirxvBMQqYIM0CO7I1T+9Yt1ta63Xi5SVU2c8MbOJxx48u/5i/STSGfDq9tPSUzahsMaTVire7GK5ES3n23LtI8ddh0WHS0rI5mVczW5lVbZV403mqodFq2tSqrMVrqukqat7tbFBKmVWcCNW3Ds+4w6vA9IO0tJRpTNnfQ1irCutamePhRdq8v2lptafNMZjhz/Xh/EnF3oNXgdVjVRJK3FcMjo2oiKxzZkdmXksiqfMRwOOtr21jsRxKFUtaOGfKzZ5rHwezimrZqnpx/ZkzcSkqoaGWSjgbPO1O8jc/Ki7eX6tpzmC6TVs2Kvo6+KifG2B0yy0kmdrETnLdU4vyOixVaxtBKtBFDLUWTKyVbNdt2puucpheA4lLjSVU+H02FU2pfFJHA9F1mZFTgRbcaL9h9Gni3Nurbx/P9+SSnBpXiKpTYhUUEEeFVM+pY5HKsjeHavFxLxcSm2rsTqk0nhoKW7oYaZ9RUta1Fc7ia1PPe280Eej2OS0lJgVRHTtoKao1vZLX7XJddiJw375TdaO09WlVi+K1FM9tRUTK2GN/eqrGJZv1X9lzdepsRmqnHf9eXzxlIyr0d0grcSx+qw+qoUpGxQ6xrHX1ibW+F9jr8BhVOleJWqq+loIH4XSzpFI5zl1jtqJdOJOFOLjQjhlPpHFpXPi8uCNayqa2N7eyWf2ad6iu4dvg8hTPo/jkVNW4LSxU76GrqEl7Ic+ysS6LZU4eJODkM4t2Ir445R39e/mcXbQSsmgjmjW7JGo5q8qKl0JlVHC2mpIadqqrYo2sRV40RLFpypxngyAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAART553op7STr2XKqIvFcinzzvRT2kgNS6bGExFlHrqC7onS5tQ/iVEt4fnLG1NfUTSQ0qUyahUZLK9rrOfZFVGtReBL8a8Zc+CVcajqUb/ZNpnsVb/5lc1U/JSlI6uhq6l8FN2VDUP1lmvRrmOsiL4VkVFsi8JRXPiVRHQ1V4omVdO9jHJtcxcypZycC2svB5iySoxCjVklZ2LLTq5GOdE1zXMutkWyqt0upjT0VZLQ1k74k7JqJI3JC1yd61jksl12KtkVTIq21eItSldRvpoFc10j5HtVVRFRbIjVXhtwqUWSVVXPWTU9C2FqQWSSSW6pmVL2REtxW234yqTFJYKWr18LOyKbKio13eOR3guuvAnLyWUksdXR1tRNBT9kw1Co9WtejXMciIi8OxUWycZ8p4a1vZdbJTxrPPlRIFfsRjeJV4L7VXkIL6RcRWRq1DqOSFyXvFmRU5OG6Km4zDT0lNN2fDLDh/a+NuZZk1jbSXTYmVqqnDtuvIbgSAAIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABF/hR+l7FJEX+FH6XsUCQAAAAAAAAAAAAAAAAAAxsVquwsOnqrXWNt0TlXgT7zzpjZq6qe98qZlu+SR67ETlU9A0gp31WDVMMaXerLonKqKi2+489pJ0ge/MzOx7FY9t7KqLyLxLwHnO2qp9rRTV/jj6/wBw9B2PTHsq5p/yyuTDp3OekaxyI2LXIrV2Pbe2z7b7PMpjzxOhejXWurGvS3IqIqfmZK16tVUgjWJrYkjj7+6ts9H3VbbVvfk4Sqvqey6lZtW2O7Wtyt4EsiJs3HHuRa2fyzxda3N3a/Nydbong9PHRR1tRE2SaVMzcyXRreK3nN3VUtPVRLFUQskYvEqcHUYOi9XHVYPAjVTPC1I3t40slk+42h7DR2rUaemKY4THV5TV3Lk36pqnjEudwXPhePS4Qr1dTyN1kN14P/W3caX5XP8AZn+9/wCg3NO9MR0xWoh76KkiyK9OBV2p7V3Gm+Vz/Zn+9/6D7P8A4/8A+bEf4xNWPhj75Nf/AJUzPOYjPxcEdNgujsPaV+N4ssyUyImqhi8OVVWyfUirsOZOpwHSSFMIXBsV1qQbFhqI9rolRbps40RUv9x67Ve12I9n48fHH6PghnQ6P0NRHSdl4VJhzKzvYZY6hz3MfZVRr2uTjtxHL4/hVRg+Ivo6izrJmY9OB7eJUOvl0lolkgqK7FUrkplzxQU9K6PO+yojnK7ZsuuxDkcfxWoxnEX1lRZt0ysYi7GN5D59J7fb/N/j8/pnis4a895PBj3k+Ttn/T5/wtIADhsgAAAAAAAAAAAAAAAEYfmWeihIjD8yz0UJAU1fgN9L2KVNLavwG+l7FKmlhE2lkfhFbSyPwgqwAEH5OAB7t9AAAAAAAAAAAAAA9A+Qf9b6v+Hv/mRntSnivyD/AK31f8Pf/MjPalPMdq+8T8Iaa+aDj5D8+z61/I+uPkPz7PrX8jmsGWADFUWeFJ6XsQkRZ4UnpexCQAAAAAAAAAi/wo/S9ikiL/Cj9L2KBIAAAAAAAA+PY2RjmPajmuSzmql0VORT6AK6eCGniSKnhjhjTgYxqNRPsQsAEznmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACKfPO9FPaSIp8870U9pIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEX+FH6XsUkRf4UfpexQJAAAAAAAAAAAAAAAAAAAc9jOjMNXM6ekkSCRy3c1Uu1V5fMdCDTf09u/Ts3Iy3Wb9yxVtUThxXcliPj6TpO90+dyWJePpOm73TtgfD+D6bwnq+38W1PjHRx9Lo3jNLLraesp4n8rXu90znYVj1U3VVuKsSJfCSJNqpuQ6IGyjs2zRGImceGZw119o3a5zMRnxxDFwygp8Ppkgp22Thc5eFy8qnG/K5/sz/AHv/AEHeGt0iwalxuiSmqVcxWrmjkbwtXq8x19DXRprtM4xEPhrqqrmZqnMy8YB3v6Ov+2P+7f8AmH6Ov+2P+7f+Y9H+JabzfSfs1bMuCB3v6Ov+2P8Au3/mH6Ov+2P+7f8AmH4lpvN9J+xsy4I95OPwjQOlo62Ooqq11Ukao5saRZEVU5dq3TzHYHJ7S1Vu/NMUTnGWVMYAActkAAAAAAAAAAAAAAAAjD8yz0UJEYfmWeihICmr8BvpexSppbV+A30vYpU0sIm0sj8IraWR+EFWAAg6b9BnyWfsv/3+p/qD9BnyWfsv/wB/qf6gB4L8Y7Q9ev8A9qvu9zutjyR0g/QZ8ln7L/8Af6n+oP0GfJZ+y/8A3+p/qAD8Y7Q9ev8A9qvubrY8kdIP0GfJZ+y//f6n+oP0GfJZ+y//AH+p/qAD8Y7Q9ev/ANqvubrY8kdIP0GfJZ+y/wD3+p/qD9BnyWfsv/3+p/qAD8Y7Q9ev/wBqvubrY8kdIP0GfJZ+y/8A3+p/qD9BnyWfsv8A9/qf6gA/GO0PXr/9qvubrY8kdIP0GfJZ+y//AH+p/qD9BnyWfsv/AN/qf6gA/GO0PXr/APar7m62PJHSGwwH5Jvk/wACrH1eFYB2PM+NY3O7Mnddqqi2s56pwohuu5HR7yf+NJ7wBqr7R1dc5qu1TP8A/U/dN0seSOkHcfo75O/Gk94+Jofo4jkcmHbU/wDrSe8AY79qfUq6ybpp/JHSE+5PAPoH4z/eHcngH0D8Z/vAE37U+pV1k3Sx5I6Q+Jolo+iqqYfw7V/tpPePvcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP94Ab9qfUq6ybpY8kdIO5PAPoH4z/AHh3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/eAG/an1Kusm6WPJHSDuTwD6B+M/3j4uiWj6qirh/BtT+2k94Ab9qfUq6ybpY8kdIfe5PAPoH4z/eHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP94Ab9qfUq6ybpY8kdIO5PAPoH4z/eHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP94Ab9qfUq6ybpY8kdIO5PAPoH4z/AHh3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/eAG/an1Kusm6WPJHSDuTwD6B+M/3h3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/AHgBv2p9SrrJuljyR0g7k8A+gfjP94dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/3gBv2p9SrrJuljyR0g7k8A+gfjP94dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/3gBv2p9SrrJuljyR0g7k8A+gfjP8AeHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP94Ab9qfUq6ybpY8kdIO5PAPoH4z/eHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP8AeAG/an1Kusm6WPJHSDuTwD6B+M/3h3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/eAG/an1Kusm6WPJHSDuTwD6B+M/3h3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/eAG/an1Kusm6WPJHSDuTwD6B+M/wB4dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/3gBv2p9SrrJuljyR0g7k8A+gfjP94dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/wB4Ab9qfUq6ybpY8kdIO5PAPoH4z/eHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP94Ab9qfUq6ybpY8kdIO5PAPoH4z/eHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP94Ab9qfUq6ybpY8kdIO5PAPoH4z/AHh3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/eAG/an1Kusm6WPJHSDuTwD6B+M/3h3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/AHgBv2p9SrrJuljyR0g7k8A+gfjP94dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/3gBv2p9SrrJuljyR0g7k8A+gfjP94dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/3gBv2p9SrrJuljyR0g7k8A+gfjP8AeHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP94Ab9qfUq6ybpY8kdIO5PAPoH4z/eHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP8AeAG/an1Kusm6WPJHSDuTwD6B+M/3h3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/eAG/an1Kusm6WPJHSDuTwD6B+M/3h3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/eAG/an1Kusm6WPJHSDuTwD6B+M/wB4dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/3gBv2p9SrrJuljyR0g7k8A+gfjP94dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/wB4Ab9qfUq6ybpY8kdIO5PAPoH4z/eHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP94Ab9qfUq6ybpY8kdIO5PAPoH4z/eHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP94Ab9qfUq6ybpY8kdIO5PAPoH4z/AHh3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/eAG/an1Kusm6WPJHSDuTwD6B+M/3h3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/AHgBv2p9SrrJuljyR0g7k8A+gfjP94dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/3gBv2p9SrrJuljyR0g7k8A+gfjP94dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/3gBv2p9SrrJuljyR0g7k8A+gfjP8AeHcngH0D8Z/vADftT6lXWTdLHkjpD53JaP3Ve1+1dnz0nvH3uTwD6B+M/wB4Ab9qfUq6ybpY8kdIO5PAPoH4z/eHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP94Ab9qfUq6ybpY8kdIO5PAPoH4z/eHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP94Ab9qfUq6ybpY8kdIO5PAPoH4z/AHh3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/eAG/an1Kusm6WPJHSDuTwD6B+M/3h3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/AHgBv2p9SrrJuljyR0g7k8A+gfjP94dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/3gBv2p9SrrJuljyR0g7k8A+gfjP94dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/3gBv2p9SrrJuljyR0g7k8A+gfjP8AeHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP94Ab9qfUq6ybpY8kdIO5PAPoH4z/eHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP8AeAG/an1Kusm6WPJHSDuTwD6B+M/3h3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8fF0S0fVUVcP4Nqf20nvADftT6lXWTdLHkjpD73J4B9A/Gf7w7k8A+gfjP94Ab9qfUq6ybpY8kdIO5PAPoH4z/AHh3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/eAG/an1Kusm6WPJHSDuTwD6B+M/3h3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/AHgBv2p9SrrJuljyR0g7k8A+gfjP94dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/3gBv2p9SrrJuljyR0g7k8A+gfjP94dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/3gBv2p9SrrJuljyR0g7k8A+gfjP8AeHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP94Ab9qfUq6ybpY8kdIO5PAPoH4z/eHcngH0D8Z/vADftT6lXWTdLHkjpB3J4B9A/Gf7w7k8A+gfjP8AeAG/an1Kusm6WPJHSDuTwD6B+M/3h3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/eAG/an1Kusm6WPJHSDuTwD6B+M/3h3J4B9A/Gf7wA37U+pV1k3Sx5I6QdyeAfQPxn+8O5PAPoH4z/eAG/an1Kusm6WPJHSDuTwD6B+M/wB4dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/3gBv2p9SrrJuljyR0g7k8A+gfjP94dyeAfQPxn+8AN+1PqVdZN0seSOkHcngH0D8Z/vDuTwD6B+M/wB4Ab9qfUq6ybpY8kdIfG6JaPoiImH7E2J/bSe8fe5PAPoH4z/eAG/an1Kusm6WPJHSEX6I6PPREdh97bfnpPePiaH6OJ/s78aT3gC79qfUq6ybpp/JHSH3uQ0d8n/jSe8fU0S0eTgw/wDGk94Ab9qfUq6ybpp/JHSH3uTwD6B+M/3gui+AN2dr0X/ev6wBGt1M/wD2VdZSdLYj/SOkP//Z" alt="Painel RH Gestou" style="width:100%;border-radius:8px;box-shadow:0 8px 32px rgba(0,0,0,0.4);display:block;">
        </div>
        <div class="showcase-info">
          <h3>Comunicação <span>direta e transparente</span></h3>
          <p>O Painel RH é o canal oficial de comunicação entre o time de DP e os colaboradores. Tudo registrado, rastreado e seguro.</p>
          <div class="showcase-feature-list">
            <div class="showcase-feature-item"><i class="bi bi-check-circle-fill"></i> Mensagens diretas gestor ↔ colaborador</div>
            <div class="showcase-feature-item"><i class="bi bi-check-circle-fill"></i> Avisos e comunicados em massa</div>
            <div class="showcase-feature-item"><i class="bi bi-check-circle-fill"></i> Histórico de todas as comunicações</div>
            <div class="showcase-feature-item"><i class="bi bi-check-circle-fill"></i> Confirmação de leitura</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ======= TESTIMONIALS ======= -->
<section id="testimonials" class="section-pad">
  <div class="container">
    <div class="section-header center" data-aos="fade-up">
      <div class="section-label">Depoimentos</div>
      <h2 class="section-title">O que dizem nossos <span>clientes</span></h2>
      <p class="section-subtitle">Empresas que transformaram seu Departamento Pessoal com a Gestou.</p>
    </div>
    <div class="testimonials-grid">
      <!-- Card 1 -->
      <div class="testimonial-card" data-aos="fade-up" data-aos-delay="0">
        <div class="testimonial-stars">
          <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
        </div>
        <p class="testimonial-text">O Gestou foi um excelente investimento em nossa empresa. Com ele, os colaboradores podem acessar seus holerites e espelhos de ponto em qualquer hora pelo celular — além de facilitar para eles, facilita para nós.</p>
        <div class="testimonial-author">
          <img src="img/testimonials/plasroll-logo.png" alt="Plasroll" class="testimonial-avatar" style="object-fit: contain; background: #fff; padding: 4px;">
          <div class="testimonial-author-info">
            <h5>Kamila Batista</h5>
            <span>Líder de RH</span>
          </div>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
        <span class="testimonial-placeholder-badge">Em breve</span>
        <div class="testimonial-stars">
          <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
        </div>
        <p class="testimonial-text">Depoimento real de cliente será inserido aqui em breve. Aguardamos o retorno da equipe para preencher com as experiências reais dos nossos clientes.</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">R</div>
          <div class="testimonial-author-info">
            <h5>Responsável de RH</h5>
            <span>Empresa parceira Gestou</span>
          </div>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
        <span class="testimonial-placeholder-badge">Em breve</span>
        <div class="testimonial-stars">
          <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
        </div>
        <p class="testimonial-text">Depoimento real de cliente será inserido aqui em breve. Aguardamos o retorno da equipe para preencher com as experiências reais dos nossos clientes.</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">D</div>
          <div class="testimonial-author-info">
            <h5>Diretor Administrativo</h5>
            <span>Empresa parceira Gestou</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ======= PRICING ======= -->
<section id="pricing" class="section-pad" style="background: var(--gray-100);">
  <div class="container">
    <div class="section-header center" data-aos="fade-up">
      <div class="section-label">Planos</div>
      <h2 class="section-title">Planos simples, <span>sem surpresas</span></h2>
      <p class="section-subtitle">Sem taxa de implementação. Sem surpresas. Pague somente pelo que usar.</p>
    </div>
    <div class="pricing-grid">
      <!-- Plan Standard -->
      <div class="pricing-card featured" data-aos="fade-up" data-aos-delay="0">
        <div class="pricing-badge">Mais contratado</div>
        <div class="pricing-title">Plano Padrão</div>
        <div class="pricing-price"><sup>R$</sup>6<sub>,00</sub></div>
        <div class="pricing-price-note">por colaborador / mês</div>
        <div class="pricing-plus">+ R$ 49,90 / CNPJ / mês</div>
        <p class="pricing-desc">Tudo que seu DP precisa para eliminar o papel e ganhar agilidade, sem taxa de implementação.</p>
        <div class="pricing-divider"></div>
        <ul class="pricing-features">
          <li><i class="bi bi-check-lg"></i> Qualquer número de colaboradores</li>
          <li><i class="bi bi-check-lg"></i> Todos os recursos incluídos</li>
          <li><i class="bi bi-check-lg"></i> Avisos e comunicados em massa</li>
          <li><i class="bi bi-check-lg"></i> Relatórios avançados</li>
          <li><i class="bi bi-check-lg"></i> Suporte prioritário</li>
        </ul>
        <a href="https://wa.me/5516999915755?text=Tenho%20interesse%20no%20Gestou" class="btn btn-primary btn-lg pricing-cta" target="_blank" rel="noopener">
          <i class="bi bi-whatsapp"></i> Contratar
        </a>
      </div>
      <!-- Plan 3 -->
      <div class="pricing-card" data-aos="fade-up" data-aos-delay="200">
        <div class="pricing-title">Grandes Empresas</div>
        <div class="pricing-price" style="font-size:32px; margin-top: 10px;">Fale com<br>especialista</div>
        <div class="pricing-price-note" style="margin-top:8px;">Volume elevado ou múltiplos CNPJs</div>
        <div class="pricing-plus">Proposta sob consulta</div>
        <p class="pricing-desc">Solução personalizada para operações complexas com múltiplos CNPJs, integrações e volume elevado.</p>
        <div class="pricing-divider"></div>
        <ul class="pricing-features">
          <li><i class="bi bi-check-lg"></i> Múltiplos CNPJs</li>
          <li><i class="bi bi-check-lg"></i> Integrações personalizadas</li>
          <li><i class="bi bi-check-lg"></i> SLA dedicado</li>
          <li><i class="bi bi-check-lg"></i> Gerente de conta exclusivo</li>
          <li><i class="bi bi-check-lg"></i> Onboarding enterprise</li>
        </ul>
        <a href="https://wa.me/5516999915755?text=Quero%20uma%20proposta%20enterprise%20Gestou" class="btn btn-dark btn-lg pricing-cta" target="_blank" rel="noopener">
          <i class="bi bi-whatsapp"></i> Solicitar Proposta
        </a>
      </div>
    </div>
    <p style="text-align:center; margin-top:32px; font-size:13px; color:var(--gray-600);">
      * Taxa de R$49,90/mês por CNPJ. Implementação e suporte de onboarding sempre gratuitos.
    </p>
  </div>
</section>

<!-- ======= CTA FINAL ======= -->
<section id="cta-final">
  <div class="container" style="position:relative; z-index:1;">
    <div data-aos="zoom-in">
      <span class="cta-label">Pronto para começar?</span>
      <h2 class="section-title" style="color:#fff; text-align:center; margin-bottom:16px;">
        Transforme seu DP hoje.<br><span>Sem papel. Sem burocracia.</span>
      </h2>
      <p class="section-subtitle" style="color:rgba(255,255,255,0.65); text-align:center; max-width:520px; margin:0 auto 36px;">
        Fale com nossa equipe agora mesmo e descubra como a Gestou pode eliminar o retrabalho e modernizar seu Departamento Pessoal.
      </p>
      <div class="cta-actions">
        <a href="https://wa.me/5516999915755?text=Quero%20saber%20mais%20sobre%20a%20Plataforma%20Gestou" class="btn btn-whatsapp btn-lg" target="_blank" rel="noopener">
          <i class="bi bi-whatsapp"></i> Falar com um especialista
        </a>
        <a href="#pricing" class="btn btn-outline btn-lg">Ver planos e preços</a>
      </div>
      <p class="cta-note">Implementação gratuita · Sem fidelidade · Suporte incluído</p>
    </div>
  </div>
</section>

<!-- ======= FOOTER ======= -->
<footer id="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <img src="/img/gestou-logo.png" alt="Gestou">
        <p>Plataforma de Departamento Pessoal Digital. Automatize holerites, aceites e comunicações com seus colaboradores de forma simples e segura.</p>
        <div class="footer-social">
          <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
          <a href="https://wa.me/5516999915755" aria-label="WhatsApp" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i></a>
        </div>
      </div>
      <div class="footer-col">
        <h5>Navegação</h5>
        <ul>
          <li><a href="#hero">Início</a></li>
          <li><a href="#services">Serviços</a></li>
          <li><a href="#how-it-works">Como Funciona</a></li>
          <li><a href="#features">Recursos</a></li>
          <li><a href="#pricing">Planos</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h5>Acesso</h5>
        <ul>
          <li><a href="/admin/login"><i class="bi bi-buildings"></i> Administrador</a></li>
          <li><a href="/app/login"><i class="bi bi-person-circle"></i> Colaborador</a></li>
          <li><a href="/validar"><i class="bi bi-shield-check"></i> Validar Holerite</a></li>
          <li><a href="/download"><i class="bi bi-download"></i> Download do App</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 Gestou. Todos os direitos reservados.</p>
      <a href="/contato">Contato</a>
    </div>
  </div>
</footer>

<!-- Back to Top -->
<a href="#hero" class="back-to-top" id="backToTop" aria-label="Voltar ao topo">
  <i class="bi bi-arrow-up"></i>
</a>

<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- TYPEBOT -->
<script>
  const typebotInitScript = document.createElement("script");
  typebotInitScript.type = "module";
  typebotInitScript.innerHTML = `import Typebot from 'https://cdn.jsdelivr.net/npm/@typebot.io/js@0.3/dist/web.js'
Typebot.initBubble({
  typebot: "my-typebot-fnfzfbt",
  previewMessage: {
    message: "Olá! Eu sou a Bia da Gestou. Clique para falar comigo!",
    autoShowDelay: 10000,
    avatarUrl: "https://s3.typebot.io/public/workspaces/cm1z3ii1l000732ufglvpxqtp/typebots/cm1z3koa8000c1jtc6fnfzfbt/hostAvatar?v=1728408703179",
  },
  theme: { button: { backgroundColor: "#fcd23b", size: "large" } },
});`;
  document.body.append(typebotInitScript);
</script>

<script>
  // ===== AOS INIT =====
  AOS.init({ duration: 600, once: true, offset: 60 });

  // ===== HEADER SCROLL =====
  const header = document.getElementById('header');
  const backToTop = document.getElementById('backToTop');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 60) {
      header.classList.add('scrolled');
      backToTop.classList.add('visible');
    } else {
      header.classList.remove('scrolled');
      backToTop.classList.remove('visible');
    }
  });

  // ===== MOBILE NAV =====
  const navToggle = document.getElementById('navToggle');
  const navMobile = document.getElementById('navMobile');
  const navOverlay = document.getElementById('navOverlay');
  const navClose = document.getElementById('navClose');

  function openNav() {
    navMobile.classList.add('open');
    navOverlay.classList.add('open');
    document.body.style.overflow = 'hidden';
  }
  function closeNav() {
    navMobile.classList.remove('open');
    navOverlay.classList.remove('open');
    document.body.style.overflow = '';
  }
  navToggle.addEventListener('click', openNav);
  navClose.addEventListener('click', closeNav);
  navOverlay.addEventListener('click', closeNav);

  // Close nav on link click
  navMobile.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', closeNav);
  });

  // ===== SHOWCASE TABS =====
  const tabs = document.querySelectorAll('.showcase-tab');
  const panels = document.querySelectorAll('.showcase-panel');
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      panels.forEach(p => p.classList.remove('active'));
      tab.classList.add('active');
      const panelId = 'panel-' + tab.dataset.panel;
      document.getElementById(panelId).classList.add('active');
    });
  });

  // ===== ACTIVE NAV LINK ON SCROLL =====
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-desktop a');
  window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(section => {
      if (window.scrollY >= section.offsetTop - 100) current = section.getAttribute('id');
    });
    navLinks.forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('href') === '#' + current) link.classList.add('active');
    });
  });
</script>

<!-- ============================================================
     GESTOU REACTIVE ORB — hero animation
============================================================ -->
<script type="importmap">
{
  "imports": {
    "three": "https://cdnjs.cloudflare.com/ajax/libs/three.js/0.160.0/three.module.min.js"
  }
}
</script>
<script type="module">
import * as THREE from 'three';

const PALETTE = {
  dark:        new THREE.Color(0x010310),
  base:        new THREE.Color(0x003099),
  baseBright:  new THREE.Color(0x1E5FC7),
  cyan:        new THREE.Color(0x50A8E8),
  yellow:      new THREE.Color(0xFCD23B),
  yellowLight: new THREE.Color(0xFDE97A),
  hot:         new THREE.Color(0xFFFFFF)
};

const ORB_RADIUS = 2.0;
const SPHERE_SIZE = 0.17;
const RINGS = 24;
const PER_RING_BASE = 34;
const LIGHT_DIR = new THREE.Vector3(0.75, 0.25, 0.6).normalize();

const canvas = document.getElementById('gestou-orb');
if (canvas) {
  const container = canvas.parentElement;
  const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.setClearColor(0x000000, 0);
  renderer.toneMapping = THREE.NoToneMapping;

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(42, 1, 0.1, 100);
  camera.position.set(0, 0, 8.2);   // mais afastado + FOV maior → orb grande mas cabe
  camera.lookAt(0, 0, 0);

  function resize() {
    const w = container.clientWidth;
    const h = container.clientHeight;
    renderer.setSize(w, h, false);
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
  }
  resize();
  window.addEventListener('resize', resize);

  const points = [];
  for (let i = 0; i < RINGS; i++) {
    const lat = Math.PI * (i / (RINGS - 1));
    const y = Math.cos(lat);
    const r = Math.sin(lat);
    const count = Math.max(4, Math.round(PER_RING_BASE * r));
    for (let j = 0; j < count; j++) {
      const lon = (j / count) * Math.PI * 2;
      points.push(new THREE.Vector3(Math.cos(lon) * r, y, Math.sin(lon) * r));
    }
  }
  const N = points.length;

  const geo = new THREE.SphereGeometry(SPHERE_SIZE, 28, 28);
  const posAttr = geo.attributes.position;
  const shadingColors = new Float32Array(posAttr.count * 3);
  const LIGHT_LOCAL = new THREE.Vector3(0.4, 0.85, 0.35).normalize();
  for (let i = 0; i < posAttr.count; i++) {
    const nx = posAttr.getX(i) / SPHERE_SIZE;
    const ny = posAttr.getY(i) / SPHERE_SIZE;
    const nz = posAttr.getZ(i) / SPHERE_SIZE;
    const dot = nx * LIGHT_LOCAL.x + ny * LIGHT_LOCAL.y + nz * LIGHT_LOCAL.z;
    let lambert = dot * 0.5 + 0.5;
    lambert = 0.08 + lambert * 0.92;
    lambert = Math.pow(lambert, 1.4);
    const specCone = Math.max(0, dot);
    const spec = Math.pow(specCone, 60) * 1.8;
    const specHalo = Math.pow(specCone, 14) * 0.35;
    const rimDist = Math.sqrt(nx * nx + ny * ny);
    const rimFactor = Math.pow(rimDist, 3.5);
    const rimDarken = 1.0 - rimFactor * 0.5;
    const value = Math.min(1.0, (lambert + spec + specHalo) * rimDarken);
    shadingColors[i * 3]     = value;
    shadingColors[i * 3 + 1] = value;
    shadingColors[i * 3 + 2] = value;
  }
  geo.setAttribute('color', new THREE.BufferAttribute(shadingColors, 3));

  const mat = new THREE.MeshBasicMaterial({ color: 0xffffff, vertexColors: true, toneMapped: false });
  const mesh = new THREE.InstancedMesh(geo, mat, N);
  mesh.instanceMatrix.setUsage(THREE.DynamicDrawUsage);
  mesh.instanceColor = new THREE.InstancedBufferAttribute(new Float32Array(N * 3), 3);
  mesh.instanceColor.setUsage(THREE.DynamicDrawUsage);
  scene.add(mesh);

  const raycaster = new THREE.Raycaster();
  const mouseNDC = new THREE.Vector2(2, 2);
  const mouseHitPoint = new THREE.Vector3(10, 10, 10);
  let mouseActive = false;

  container.addEventListener('mousemove', (e) => {
    const rect = container.getBoundingClientRect();
    mouseNDC.x = ((e.clientX - rect.left) / rect.width) * 2 - 1;
    mouseNDC.y = -((e.clientY - rect.top) / rect.height) * 2 + 1;
    mouseActive = true;
  });
  container.addEventListener('mouseleave', () => { mouseActive = false; });
  container.addEventListener('touchmove', (e) => {
    if (e.touches[0]) {
      const rect = container.getBoundingClientRect();
      mouseNDC.x = ((e.touches[0].clientX - rect.left) / rect.width) * 2 - 1;
      mouseNDC.y = -((e.touches[0].clientY - rect.top) / rect.height) * 2 + 1;
      mouseActive = true;
    }
  }, { passive: true });
  container.addEventListener('touchend', () => { mouseActive = false; });

  function updateMouseHit() {
    raycaster.setFromCamera(mouseNDC, camera);
    const ro = raycaster.ray.origin;
    const rd = raycaster.ray.direction;
    const R = ORB_RADIUS * 1.02;
    const b = ro.dot(rd);
    const c = ro.dot(ro) - R * R;
    const disc = b * b - c;
    if (disc < 0) return false;
    const t = -b - Math.sqrt(disc);
    mouseHitPoint.copy(rd).multiplyScalar(t).add(ro);
    return true;
  }

  const dummy = new THREE.Object3D();
  const tmpColor = new THREE.Color();
  const offsets = new Float32Array(N);
  const heat = new Float32Array(N);
  const INFLUENCE_RADIUS = 0.90;
  const MAX_PUSH = 1.00;

  const clock = new THREE.Clock();

  function animate() {
    const t = clock.getElapsedTime();
    const yaw = t * 0.55;
    const pitch = Math.sin(t * 0.35) * 0.45;
    const cosY = Math.cos(yaw), sinY = Math.sin(yaw);
    const cosX = Math.cos(pitch), sinX = Math.sin(pitch);
    const hasHit = mouseActive ? updateMouseHit() : false;

    for (let i = 0; i < N; i++) {
      const p = points[i];
      let rx = p.x * cosY + p.z * sinY;
      let rz = -p.x * sinY + p.z * cosY;
      let ry = p.y;
      const ry2 = ry * cosX - rz * sinX;
      const rz2 = ry * sinX + rz * cosX;
      ry = ry2; rz = rz2;

      const baseX = rx * ORB_RADIUS;
      const baseY = ry * ORB_RADIUS;
      const baseZ = rz * ORB_RADIUS;

      let targetOffset = 0, proximity = 0;
      if (hasHit) {
        const dx = baseX - mouseHitPoint.x;
        const dy = baseY - mouseHitPoint.y;
        const dz = baseZ - mouseHitPoint.z;
        const d = Math.sqrt(dx*dx + dy*dy + dz*dz);
        if (d < INFLUENCE_RADIUS) {
          proximity = 1 - d / INFLUENCE_RADIUS;
          proximity = proximity * proximity * (3 - 2 * proximity);
          const pushCurve = Math.max(0, (proximity - 0.5) / 0.5);
          targetOffset = pushCurve * pushCurve * MAX_PUSH;
        }
      }

      const current = offsets[i];
      const lerp = targetOffset > current ? 0.32 : 0.045;
      offsets[i] = current + (targetOffset - current) * lerp;
      const off = offsets[i];

      const targetHeat = proximity;
      const hLerp = targetHeat > heat[i] ? 0.45 : 0.018;
      heat[i] = heat[i] + (targetHeat - heat[i]) * hLerp;
      const h = heat[i];

      dummy.position.set(baseX + rx * off, baseY + ry * off, baseZ + rz * off);
      dummy.scale.setScalar(1 + off * 0.15);
      dummy.updateMatrix();
      mesh.setMatrixAt(i, dummy.matrix);

      const rawDot = rx * LIGHT_DIR.x + ry * LIGHT_DIR.y + rz * LIGHT_DIR.z;
      let litAmount = Math.pow((rawDot + 1) * 0.5, 3.5);
      tmpColor.copy(PALETTE.dark).lerp(PALETTE.base, litAmount);
      if (litAmount > 0.7) {
        tmpColor.lerp(PALETTE.baseBright, (litAmount - 0.7) / 0.3 * 0.25);
      }
      if (h > 0.01) {
        let reactColor;
        if (h < 0.25)      reactColor = tmpColor.clone().lerp(PALETTE.cyan, h / 0.25);
        else if (h < 0.55) reactColor = PALETTE.cyan.clone().lerp(PALETTE.yellow, (h - 0.25) / 0.30);
        else if (h < 0.80) reactColor = PALETTE.yellow.clone().lerp(PALETTE.yellowLight, (h - 0.55) / 0.25);
        else               reactColor = PALETTE.yellowLight.clone().lerp(PALETTE.hot, (h - 0.80) / 0.20);
        tmpColor.lerp(reactColor, Math.min(1, h * 1.3));
      }
      mesh.instanceColor.setXYZ(i, tmpColor.r, tmpColor.g, tmpColor.b);
    }
    mesh.instanceMatrix.needsUpdate = true;
    mesh.instanceColor.needsUpdate = true;
    renderer.render(scene, camera);
    requestAnimationFrame(animate);
  }
  animate();
}
</script>

</body>
</html>
