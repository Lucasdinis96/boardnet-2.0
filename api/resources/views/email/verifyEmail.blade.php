<div id="main">
    <p id="text">Olá, {{ $data['name'] }}.</p>
    <a href="http://localhost:8080/verifyEmail/{{ $token }}">Teste de rota</a>
</div>

<style>
    #main {
        background-color: gray;
    }
    #text {
        color: white;
    }
</style>