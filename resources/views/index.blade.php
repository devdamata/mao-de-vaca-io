<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mão de Vaca IO</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f2027 0%, #2c5364 100%);
            color: #fff;
            font-family: 'Montserrat', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 70vh;
            text-align: center;
            background: linear-gradient(120deg, #232526 0%, #414345 100%);
            border-radius: 0 0 40px 40px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        .hero h1 {
            font-size: 3rem;
            letter-spacing: 2px;
            margin-bottom: 1rem;
            background: linear-gradient(90deg, #00c6ff, #0072ff, #00f2fe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 900;
        }
        .hero p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: #b2fefa;
        }
        .cta-btn {
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            color: #fff;
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 30px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 20px 0 rgba(0,198,255,0.2);
            transition: background 0.3s, transform 0.2s;
            margin-bottom: 2rem;
        }
        .cta-btn:hover {
            background: linear-gradient(90deg, #0072ff, #00c6ff);
            transform: scale(1.05);
        }
        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            margin: 3rem 0;
        }
        .feature {
            background: rgba(44, 83, 100, 0.7);
            border-radius: 20px;
            padding: 2rem;
            width: 270px;
            box-shadow: 0 2px 16px 0 rgba(0,198,255,0.08);
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .feature:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 8px 32px 0 rgba(0,198,255,0.18);
        }
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #00c6ff;
        }
        .plans {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin: 4rem 0 2rem 0;
        }
        .plan {
            background: rgba(44, 83, 100, 0.8);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            width: 300px;
            box-shadow: 0 2px 16px 0 rgba(0,198,255,0.08);
            text-align: center;
            position: relative;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .plan.featured {
            border: 2px solid #00c6ff;
            box-shadow: 0 8px 32px 0 rgba(0,198,255,0.18);
            transform: scale(1.05);
        }
        .plan h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #00c6ff;
        }
        .plan .price {
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #b2fefa;
        }
        .plan ul {
            list-style: none;
            padding: 0;
            margin-bottom: 1.5rem;
        }
        .plan ul li {
            margin-bottom: 0.7rem;
            color: #fff;
        }
        .plan .plan-btn {
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            color: #fff;
            padding: 0.7rem 2rem;
            border: none;
            border-radius: 20px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }
        .plan .plan-btn:hover {
            background: linear-gradient(90deg, #0072ff, #00c6ff);
            transform: scale(1.07);
        }
        .testimonials {
            margin: 4rem 0 2rem 0;
            text-align: center;
        }
        .testimonial {
            background: rgba(44, 83, 100, 0.7);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin: 1rem auto;
            max-width: 600px;
            color: #b2fefa;
            font-style: italic;
            box-shadow: 0 2px 16px 0 rgba(0,198,255,0.08);
        }
        footer {
            text-align: center;
            padding: 2rem 0 1rem 0;
            color: #b2fefa;
            font-size: 1rem;
            background: transparent;
        }
    </style>
</head>
<body>
    <div class="hero">
        <h1>Mão de Vaca IO</h1>
        <p>O jeito futurista de controlar suas finanças pessoais</p>
        <a href="/register" class="cta-btn">Experimente Grátis</a>
    </div>

    <section class="features">
        <div class="feature">
            <div class="feature-icon">💸</div>
            <h3>Controle Total</h3>
            <p>Gerencie receitas, despesas, categorias e carteiras de forma intuitiva.</p>
        </div>
        <div class="feature">
            <div class="feature-icon">📊</div>
            <h3>Relatórios Inteligentes</h3>
            <p>Visualize gráficos e relatórios para tomar decisões melhores.</p>
        </div>
        <div class="feature">
            <div class="feature-icon">🔁</div>
            <h3>Recorrências & Parcelas</h3>
            <p>Automatize lançamentos recorrentes e controle parcelamentos.</p>
        </div>
        <div class="feature">
            <div class="feature-icon">🔒</div>
            <h3>Segurança</h3>
            <p>Seus dados protegidos com tecnologia de ponta.</p>
        </div>
    </section>

    <section class="plans">
        <div class="plan">
            <h3>Gratuito</h3>
            <div class="price">R$0/mês</div>
            <ul>
                <li>1 Carteira</li>
                <li>10 Categorias</li>
                <li>Relatórios básicos</li>
                <li>Suporte por e-mail</li>
            </ul>
            <button class="plan-btn">Começar</button>
        </div>
        <div class="plan featured">
            <h3>Pro</h3>
            <div class="price">R$19/mês</div>
            <ul>
                <li>Carteiras ilimitadas</li>
                <li>Categorias ilimitadas</li>
                <li>Relatórios avançados</li>
                <li>Recorrências e parcelamentos</li>
                <li>Suporte prioritário</li>
            </ul>
            <button class="plan-btn">Assinar</button>
        </div>
        <div class="plan">
            <h3>Empresarial</h3>
            <div class="price">R$49/mês</div>
            <ul>
                <li>Tudo do Pro</li>
                <li>Multiusuário</li>
                <li>Integrações</li>
                <li>Suporte dedicado</li>
            </ul>
            <button class="plan-btn">Solicitar contato</button>
        </div>
    </section>

    <section class="testimonials">
        <h2>O que dizem nossos clientes</h2>
        <div class="testimonial">“Nunca foi tão fácil controlar meu dinheiro. Interface linda e prática!”</div>
        <div class="testimonial">“Os relatórios me ajudaram a economizar de verdade!”</div>
        <div class="testimonial">“Recomendo para todos que querem ter controle financeiro de verdade.”</div>
    </section>

    <footer>
        &copy; 2025 Mão de Vaca IO &mdash; O futuro do controle financeiro
    </footer>
</body>
</html>
