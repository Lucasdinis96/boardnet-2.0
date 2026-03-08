<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoardgameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('boardgames')->insert([
            [
                'title' => 'King of Tokyo',
                'publisher' => 'Devir Brasil',
                'players' => '2 a 6 Jogadores',
                'playtime' => '30 min',
                'age_range' => 'A partir de 8 anos',
                'description' => 'Em King of Tokyo, você joga com monstros mutantes, robôs gigantes e outras criaturas - os quais estão felizes em bater uns aos outros em um ambiente alegre, a fim de tornar-se o primeiro e único Rei de Tóquio.',
                'cover' => 'assets/covers/kingoftokyo.webp',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Carcassone',
                'publisher' => 'Devir Brasil',
                'players' => '2 a 5 Jogadores',
                'playtime' => '45 min',
                'age_range' => 'A partir de 8 anos',
                'description' => 'Carcassonne é um jogo de colocação de peças modulares, onde cada ladrilho representam um pedaço do sul da França. Cada jogada consiste em compra e colocar uma nova peça, que precisa ser encaixada preservando as formas topológicas dos desenhos. Cada peça irá expandir o tabuleiro e você deve tentar controlar áreas como uma cidade (Cavaleiro), uma estrada (Ladrão), um mosteiro (Monge) ou dos campos (Fazendeiros) para ganhar pontos. Carcassonne além de ser o jogo que inventou o marcador do Meeple (my+people) se tornou um novo clássico moderno dos jogos de tabuleiro, altamente acessível à iniciantes, mas com camadas estratégicas tão fortes que se tornou um jogo com diversos torneios e competições mundiais.',
                'cover' => 'assets/covers/carcassone.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Munchkin',
                'publisher' => 'Devir Brasil',
                'players' => '2 a 6 Jogadores',
                'playtime' => '90 min',
                'age_range' => 'A partir de 10 anos',
                'description' => 'Entre na Dungeon e explore seus mistérios! Abra portas secretas e mate todos os monstros que cruzarem seu caminho. Trapaceie seus colegas. Pegue todo o tesouro para você e saia correndo. Seja sincero: Você adora isso! Este jogo contém a essência da Experiência Dungeon… sem toda a complexidade do RPG. Tudo que você precisa é juntar alguns amigos, matar uns monstros e pegar seus valiosos tesouros. Itens poderosíssimos como uma “Bandana de Machão” ou as famosas “Joelheiras da Sedução”.Calçe as “Botas de Chutar a Bunda” ou talvez use sua “Serra Elétrica de Mutilação Sangrenta”. Dê início à sua saga massacrando “Rãs Voadoras” ou um “Troll da Internet”, para quem sabe um dia ter o prazer de matar o temível “Dragão de Plutônio”.Rápido e leve, Munchkin vai levar qualquer grupo de jogadores de RPG à loucura! E, enquanto todos estiverem rindo, você pode roubar suas coisas.',              
                'cover' => 'assets/covers/munchkin.webp',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Sword & Sorcery: Espíritos Imortais',
                'publisher' => 'Devir Brasil',
                'players' => '1 a 5 Jogadores',
                'playtime' => '90 min',
                'age_range' => 'A partir de 14 anos',
                'description' => 'Sword & Sorcery é um jogo cooperativo de fantasia, em que você unirá suas forças com até 4 amigos (5 jogadores no total) para derrotar o mal, salvar o reino e quebrar o feitiço que está ligado a suas almas. Os vilões são controlados pelo jogo, que segundo os desenvolvedores, possui uma inteligência artificial (IA) única. O sistema de jogo é uma evolução do apresentado em Galaxy Defenders, com aprimoramento da IA dos monstros, alta escala de customização dos personagens e múltiplas táticas de combate, com a promessa de ter mecânicas nunca vistas antes em jogos desse porte.',
                'cover' => 'assets/covers/swordandsorcery.webp',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Mysterium',
                'publisher' => 'Galápagos',
                'players' => '2 a 7 Jogadores',
                'playtime' => '42 min',
                'age_range' => 'A partir de 8 anos',
                'description' => 'Mysterium é um jogo cooperativo para 2-7 jogadores. Um jogador assume o papel de um fantasma que vive em uma mansão antiga misteriosa. Outros jogadores são um grupo de médiuns convidados pelo proprietário da mansão para resolver o mistério do lugar e trazer a paz a seus moradores, enquanto qualquer pessoa que permanece no castelo vê sonhos estranhos.',
                'cover' => 'assets/covers/mysterium.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Eldritch Horror',
                'publisher' => 'Galápagos',
                'players' => '1 a 8 Jogadores',
                'playtime' => '240 min',
                'age_range' => 'A partir de 14 anos',
                'description' => 'Em Eldritch Horror, de um a oito jogadores assumem o papel de investigadores que andam pelo mundo, trabalhando juntos, e devem resolver mistérios relacionados aos Grandes Antigos cuja intenção é a destruição global. Nessa busca você pode reunir pistas, encontrar situações estranhas, lutar contra monstros e embarcar em expedições ousadas. Você tem a coragem de salvar o mundo?',
                'cover' => 'assets/covers/eldritchhorror.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Dead of Winter: Um Jogo de Encruzilhadas',
                'publisher' => 'Galápagos',
                'players' => '2 a 5 Jogadores',
                'playtime' => '100 min',
                'age_range' => 'A partir de 14 anos',
                'description' => 'Dead of Winter é um jogo cooperativo de sobrevivência psicológica. Isso significa que os jogadores estão trabalhando juntos em direção a uma condição de vitória comum - mas para cada jogador conseguir a vitória, ele também deve cumprir o seu objetivo pessoal secreto. Este objetivo secreto poderia se relacionar com uma marca psicológica que é inofensiva para a maioria dos outros na colônia, uma obsessão perigosa que poderia colocar o objetivo principal em risco, um desejo de sabotagem da missão principal, ou ( pior de tudo) vingança contra a colônia! Alguns jogos podem terminar com todos os jogadores vencedores, alguns ganhando e outros perdendo, ou todos os jogadores perdendo. Trabalhe para o objetivo do grupo, mas não ande como um falastrão que está olhando apenas para seus próprios interesses!',
                'cover' => 'assets/covers/deadofwinter.webp',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'The Resistence',
                'publisher' => 'Grok Games',
                'players' => '3 a 10 Jogadores',
                'playtime' => '30 min',
                'age_range' => 'A partir de 13 anos',
                'description' => 'The Resistance é um jogo festivo de dedução social. É projetado para 5-10 jogadores, dura cerca de 30 minutos, e não tem eliminação jogador. The Resistance é inspirado por Mafia / Lobisomem, no entanto, é único em sua mecânica principal que aumenta os recursos para decisões informadas, intensifica a interação do jogador, e evita a eliminação de jogadores.',
                'cover' => 'assets/covers/resistence.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Deterence 2X62',
                'publisher' => 'Mandala Jogos',
                'players' => '2 Jogadores',
                'playtime' => '30 min',
                'age_range' => 'A partir de 10 anos',
                'description' => 'Um dia, no passado, o mundo civilizado ficou na beira da destruição. A superpotência soviética apontou perigosamente seus mísseis em direção superpotência norte-americana, provocando uma crise que ameaçava a existência da humanidade. Era 1962. Em algum universo paralelo, no entanto, a crise nunca terminou. Séculos se passaram. Em segredo, terríveis máquinas de matar foram desenvolvidas por ambos os lados. E chegou o momento que uma nova corrida armamentista pode acabar com o mundo ... ou dedicar seu lado o vencedor! Em Deterrence 2X62, seu objetivo é ganhar a guerra fria, destruindo o país inimigo através de um único ataque bem-sucedido, ou dominar a riqueza do mundo.',
                'cover' => 'assets/covers/deterrence.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Yomi: Round 1',
                'publisher' => 'Mandala Jogos',
                'players' => '2 Jogadores',
                'playtime' => '30 min',
                'age_range' => 'A partir de 10 anos',
                'description' => 'Yomi é a palavra japonesa para leitura. Nesse caso, no sentido de ler a mente do seu oponente. É um jogo de cartas que simula um jogo de luta. Testa sua habilidade de prever como seus oponentes vão agir e a sua habilidade de julgar o valor relativo das cartas de uma situação para a próxima. Além disso, deixa você aplicar combos divertidos e ser um panda. Existem 10 personagens diferentes para serem escolhidos , cada um com seu próprio deck, estilo e habilidades. Cada deck também funciona como um baralho regular de cartas. O jogo completo tem 120 ilustrações diferentes.',
                'cover' => 'assets/covers/yomi.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
