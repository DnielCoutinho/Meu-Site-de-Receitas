-- Inserindo Paises
REPLACE INTO `paises` (`nome`) VALUES
('Itália'),
('Brasil'),
('Japão'),
('Tailândia'),
('China'),
('México'),
('Índia'),
('França'),
('Áustria'),
('Grécia'),
('Hungria'),
('Polônia'),
('Portugal'),
('Reino Unido'),
('Coreia do Sul'),
('Canadá'),
('Peru'),
('Egito'),
('Líbano');

-- Inserindo Tipos de Refeição
REPLACE INTO `tipos_refeicao` (`nome`) VALUES
('Entrada'),
('Prato Principal'),
('Sobremesa'),
('Aperitivo');

-- Inserindo Categorias
REPLACE INTO `categorias` (`nome`) VALUES
('Massas'),
('Carnes'),
('Saladas'),
('Sopas'),
('Frutos do Mar'),
('Aves');

-- Inserindo Receitas
-- Lembre-se de criar um usuário primeiro para que o usuario_id seja válido
REPLACE INTO `receitas` (`nome`, `pais_id`, `tipo_refeicao_id`, `categoria_id`, `ingredientes`, `preparo`, `usuario_id`, `foto`) VALUES
('Pizza Napolitana', 1, 2, 1, '- 500g de farinha de trigo tipo "00"
- 300ml de água morna
- 15g de sal marinho fino
- 1.5g de fermento biológico fresco (ou 0.5g de fermento biológico seco)
- 1 lata de tomate pelado San Marzano (para o molho)
- 125g de queijo Mozzarella de Búfala fresca, escorrida e rasgada
- Folhas frescas de manjericão a gosto
- Azeite de oliva extravirgem de boa qualidade', '1. **Preparo da Massa (Fermentação Lenta - Dia Anterior ou 8 horas antes):**
   - Em uma tigela grande, dissolva 1.5g de fermento biológico fresco (ou 0.5g de fermento biológico seco) em 300ml de água morna (cerca de 35-40°C). Misture delicadamente.
   - Adicione 250g da farinha de trigo tipo "00" e misture com uma colher de pau ou espátula até incorporar.
   - Acrescente 15g de sal marinho fino e o restante da farinha (250g) gradualmente, misturando até formar uma massa pegajosa e sem grumos secos.
   - Transfira a massa para uma superfície levemente enfarinhada (com farinha de trigo ou sêmola fina) e sove por 10-15 minutos. O objetivo é desenvolver o glúten, tornando a massa lisa, elástica e menos pegajosa. Ela deve passar no "teste do véu" (esticar um pedaço pequeno até ficar translúcido sem rasgar).
   - Forme uma bola com a massa, coloque-a em uma tigela grande untada com um fio de azeite de oliva. Cubra a tigela com plástico filme ou um pano úmido para evitar que a massa resseque. Deixe descansar em temperatura ambiente (cerca de 20-24°C) por 2 horas. A massa deve dobrar de volume.
   - Após o descanso inicial, leve a tigela com a massa à geladeira por 18-24 horas para uma fermentação lenta e controlada. Este processo aprimora significativamente o sabor e a textura da massa.
2. **Preparo do Molho de Tomate Fresco:**
   - Em uma tigela média, amasse 1 lata de tomate pelado San Marzano (aproximadamente 400g) com as mãos limpas (ou use um garfo) até obter uma consistência rústica, com alguns pedaços de tomate. Evite usar liquidificador para manter a textura.
   - Tempere o molho com uma pitada generosa de sal e um fio de azeite de oliva extravirgem de boa qualidade. Adicione folhas frescas de manjericão a gosto. Misture bem. É crucial que o molho não seja cozido, pois ele cozinhará no forno com a pizza.
3. **Preparo da Pizza (No Dia do Consumo):**
   - Retire a massa da geladeira 2-3 horas antes de usá-la para que atinja a temperatura ambiente. Isso a tornará mais fácil de manusear e esticar.
   - Divida a massa em 2-3 porções iguais (para pizzas individuais de tamanho médio) e forme bolas bem lisas. Coloque-as em uma bandeja levemente enfarinhada, cubra com um pano úmido e deixe descansar por mais 1 hora em temperatura ambiente.
   - **Pré-aquecimento do Forno:** É fundamental que o forno esteja extremamente quente. Pré-aqueça o forno na temperatura máxima possível (idealmente entre 250-300°C) com uma pedra de pizza ou uma assadeira virada para baixo na grade mais alta. Deixe aquecer por pelo menos 30-45 minutos para garantir que a pedra/assadeira esteja bem quente.
   - Em uma superfície levemente enfarinhada (preferencialmente com sêmola de trigo para evitar que grude), pegue uma bola de massa. Com as pontas dos dedos, comece a abrir a massa delicadamente do centro para as bordas, formando um círculo de aproximadamente 25-30 cm de diâmetro. Procure deixar as bordas (cornicione) mais grossas para que fiquem aeradas e crocantes. Evite usar rolo, pois isso remove o ar da massa.
   - Transfira a massa aberta para uma pá de pizza levemente enfarinhada (ou para um pedaço de papel manteiga sobre uma tábua).
   - Espalhe uma camada fina do molho de tomate preparado sobre a massa, deixando uma borda de 1-2 cm livre.
   - Distribua 125g de queijo Mozzarella de Búfala fresca, escorrida e rasgada, sobre o molho. Adicione mais folhas frescas de manjericão, se desejar.
   - **Assar a Pizza:** Deslize cuidadosamente a pizza para a pedra de pizza ou assadeira quente no forno. Asse por 5-8 minutos, ou até que as bordas estejam douradas e infladas, o queijo borbulhante e levemente gratinado, e a base crocante. O tempo exato pode variar dependendo do seu forno.
   - Retire a pizza do forno com a pá. Regue com um fio de azeite de oliva extravirgem antes de servir.
   - Sirva imediatamente e desfrute da sua Pizza Napolitana autêntica!', 1, 'https://unsplash.com/photos/1595908129339-95f14b01ac39'),
('Espaguete ao Pomodoro', 1, 2, 1, '- 1kg de tomates italianos maduros
- 4 colheres de sopa de azeite de oliva extravirgem
- 1 cebola pequena, finamente picada
- 2 dentes de alho, amassados ou picados
- Folhas frescas de manjericão a gosto
- Sal e pimenta-do-reino moída na hora a gosto
- 500g de espaguete de boa qualidade
- Queijo parmesão ralado na hora para servir', '1. **Preparo dos Tomates Frescos (Remoção da Pele e Sementes):**
   - Lave bem 1kg de tomates italianos maduros. Com uma faca afiada, faça um pequeno corte em "X" na base de cada tomate.
   - Em uma panela, ferva água suficiente para cobrir os tomates. Mergulhe os tomates na água fervente por aproximadamente 30 segundos a 1 minuto, ou até que a pele comece a se soltar nas áreas cortadas.
   - Com uma escumadeira, transfira imediatamente os tomates para um recipiente com água gelada e cubos de gelo. Este choque térmico interrompe o cozimento e facilita a remoção da pele.
   - Retire a pele dos tomates com facilidade. Corte-os ao meio, remova as sementes (se desejar um molho mais liso) e pique-os grosseiramente. Reserve.
2. **Preparo do Molho Pomodoro (Base Aromática):**
   - Em uma panela grande e de fundo grosso, aqueça 4 colheres de sopa de azeite de oliva extravirgem em fogo médio.
   - Adicione 1 cebola pequena, finamente picada, e refogue por cerca de 5-7 minutos, mexendo ocasionalmente, até que fique macia e translúcida, sem dourar.
   - Acrescente 2 dentes de alho, amassados ou finamente picados, e refogue por mais 1 minuto, tomando muito cuidado para que o alho não queime, pois isso pode amargar o molho.
   - Incorpore os tomates picados à panela. Tempere com sal e pimenta-do-reino moída na hora a gosto.
   - Reduza o fogo para baixo, tampe a panela e cozinhe por 20-30 minutos, mexendo ocasionalmente, até o molho encorpar e os sabores se aprofundarem. Se o molho parecer muito seco ou espesso, adicione um pouco da água do cozimento do macarrão (que será reservada no passo 3).
3. **Cozimento do Espaguete (Al Dente):**
   - Enquanto o molho cozinha, leve uma panela grande com bastante água salgada (cerca de 1 colher de sopa de sal para cada litro de água) para ferver em fogo alto.
   - Adicione 500g de espaguete de boa qualidade e cozinhe conforme as instruções da embalagem, até ficar "al dente" (cozido, mas ainda firme ao morder).
   - **Ponto Crucial:** Antes de escorrer o macarrão, reserve cerca de 1 xícara (240ml) da água do cozimento. Esta água rica em amido é essencial para dar cremosidade e ligar o molho ao macarrão.
   - Escorra o espaguete imediatamente após atingir o ponto al dente.
4. **Finalização e Integração dos Sabores:**
   - Transfira o espaguete escorrido diretamente para a panela com o molho de tomate quente.
   - Adicione um punhado generoso de folhas frescas de manjericão (rasgadas com as mãos para liberar o aroma) e, se necessário, um pouco da água do cozimento do macarrão reservada para ajustar a consistência do molho, deixando-o mais cremoso e envolvente.
   - Misture bem, usando pinças ou duas colheres grandes, para que cada fio de macarrão seja completamente envolvido pelo molho. Cozinhe por mais 1-2 minutos em fogo baixo para que os sabores se integrem.
   - Sirva imediatamente em pratos aquecidos, finalizando com queijo parmesão ralado na hora e mais algumas folhas de manjericão fresco para decorar. Um fio de azeite extravirgem pode ser adicionado antes de servir para realçar o brilho e o sabor.', 1, 'https://unsplash.com/photos/1595908129339-95f14b01ac39'),
('Risotto', 1, 2, 1, '1 xícara de arroz para risotto (Arbório ou Carnaroli), 1.5 litro de caldo de legumes ou frango, ½ cebola média picada, ½ xícara de vinho branco seco, 2 colheres de sopa de azeite, 2 colheres de sopa de manteiga gelada, 1/2 xícara de queijo parmesão ralado, sal e pimenta a gosto.', '1. **Preparação do Caldo (Essencial para o Risotto):**
   - Em uma panela separada, mantenha 1.5 litro de caldo de legumes ou frango (caseiro ou de boa qualidade) em fogo baixo, próximo ao ponto de fervura. É fundamental que o caldo esteja sempre quente ao ser adicionado ao arroz para não interromper o cozimento e manter a temperatura constante, garantindo a cremosidade final do risotto.
2. **Refogado Aromático (Soffritto):**
   - Em uma panela de fundo grosso e bordas altas (idealmente uma panela para risotto ou uma caçarola), aqueça 2 colheres de sopa de azeite de oliva em fogo médio.
   - Adicione ½ cebola média finamente picada e refogue por cerca de 5-7 minutos, mexendo ocasionalmente, até que fique macia, translúcida e levemente adocicada, sem dourar. Este é o soffritto, a base de sabor do risotto.
3. **Tostatura do Arroz (Selagem dos Grãos):**
   - Aumente o fogo para médio-alto. Adicione 1 xícara de arroz para risotto (Arbório ou Carnaroli) à panela.
   - Mexa constantemente por cerca de 2-3 minutos. Os grãos de arroz devem ficar levemente transparentes nas bordas e opacos no centro, com um aroma tostado. Esta etapa, conhecida como "tostatura", sela o arroz, ajudando-o a cozinhar por fora e permanecer "al dente" por dentro.
4. **Deglacear com Vinho Branco:**
   - Adicione ½ xícara de vinho branco seco à panela. Continue mexendo vigorosamente até que o álcool evapore completamente e o arroz absorva todo o líquido. O aroma do vinho deve desaparecer.
5. **Cozimento Gradual e Liberação do Amido:**
   - Reduza o fogo para médio-baixo. Comece a adicionar o caldo quente, uma concha por vez (cerca de 120-150ml).
   - Mexa continuamente e suavemente com uma colher de pau. Espere o líquido ser quase todo absorvido pelo arroz antes de adicionar a próxima concha de caldo.
   - Continue este processo por aproximadamente 15 a 20 minutos. O movimento constante é crucial, pois ele libera o amido do arroz, criando a textura cremosa e aveludada característica do risotto.
   - Prove o arroz regularmente. Ele deve estar "al dente" – cozido, mas ainda com uma leve resistência ao morder no centro.
6. **Finalização e Mantecatura (Incorporação de Sabor e Cremosidade):**
   - Quando o arroz estiver no ponto "al dente" e o risotto tiver uma consistência cremosa e fluida (não seca), retire a panela do fogo.
   - Adicione 2 colheres de sopa de manteiga gelada (cortada em cubos) e ½ xícara de queijo parmesão ralado na hora.
   - Mexa vigorosamente (processo conhecido como "mantecatura") por cerca de 1-2 minutos. Isso criará uma emulsão rica e aveludada, dando ao risotto sua cremosidade final.
   - Tempere com sal e pimenta-do-reino moída na hora a gosto. Ajuste o tempero conforme sua preferência.
7. **Servir Imediatamente:**
   - Sirva o risotto imediatamente em pratos aquecidos para manter a temperatura e a textura perfeitas. O risotto não espera, ele deve ser apreciado assim que pronto.', 1, 'https://unsplash.com/photos/1595908129339-95f14b01ac39'),
('Bistecca alla Fiorentina', 1, 2, 2, '1 Bife T-bone ou Porterhouse de 1 a 1.5 kg e 4-5 cm de espessura, azeite de oliva extravirgem, sal grosso, pimenta do reino moída na hora.', '1. **Preparação da Carne (Temperatura Ambiente e Secagem):**
   - Retire o bife T-bone ou Porterhouse (de 1 a 1.5 kg e 4-5 cm de espessura) da geladeira com pelo menos 2 a 3 horas de antecedência. É crucial que a carne atinja a temperatura ambiente por completo antes de ir para a grelha, garantindo um cozimento mais uniforme do centro às bordas.
   - Seque muito bem toda a superfície da carne com papel toalha. A umidade na superfície impede a formação de uma crosta perfeita.
   - Tempere generosamente a carne com sal grosso e pimenta-do-reino moída na hora em ambos os lados, pressionando levemente para que os temperos adiram.
2. **Aquecimento da Grelha (Calor Intenso):**
   - Aqueça uma grelha de carvão, a gás ou uma chapa de ferro fundido em fogo alto. A grelha deve estar extremamente quente (cerca de 230-260°C) para selar a carne rapidamente e formar uma crosta deliciosa. Você deve conseguir manter a mão sobre a grelha por apenas 1-2 segundos.
   - Opcional: Pincele um pouco de azeite de oliva extravirgem na carne antes de colocá-la na grelha.
3. **Grelhar (Selagem e Ponto Tradicional):**
   - Coloque a bistecca diretamente na grelha quente. Grelhe por 3 a 5 minutos de cada lado para um ponto mal passado (al sangue), que é o tradicional para a Bistecca alla Fiorentina. Evite virar a carne constantemente; vire apenas uma vez para garantir uma boa crosta.
   - Para um ponto perfeito, use um termômetro de carne: a temperatura interna deve atingir cerca de 52-55°C para mal passado.
4. **Cozinhar no Osso (Transferência de Calor):**
   - Após grelhar os dois lados, posicione a carne na vertical, apoiada sobre o osso em T. Cozinhe por mais 5 a 7 minutos. O osso conduz o calor para o centro da carne, ajudando a cozinhar o interior de forma mais homogênea, especialmente próximo ao osso.
5. **Descanso da Carne (Redistribuição dos Sucos):**
   - Retire a carne da grelha e transfira-a para uma tábua de corte ou um prato. Cubra-a frouxamente com papel alumínio e deixe-a descansar por 5 a 10 minutos. Este passo é absolutamente fundamental: permite que os sucos da carne se redistribuam por toda a peça, resultando em uma carne muito mais macia, suculenta e saborosa.
6. **Fatiar e Servir (Apresentação e Finalização):**
   - Fatie a carne em tiras grossas, separando o filé e o contrafilé do osso.
   - Disponha as fatias de carne de volta ao redor do osso na tábua de corte.
   - Tempere generosamente com mais sal grosso (flor de sal, se tiver) e pimenta-do-reino moída na hora. Finalize com um generoso fio de azeite de oliva extravirgem de boa qualidade.
   - Sirva imediatamente, tradicionalmente acompanhada de feijão branco ou salada verde.', 1, 'https://via.placeholder.com/250x250?text=Imagem+Nao+Encontrada'),
('Feijoada Completa', 2, 2, 2, '1 kg de feijão preto, 250g de carne-seca, 250g de costelinha de porco, 200g de linguiça paio, 200g de linguiça calabresa, 150g de bacon, 2 cebolas, 4 dentes de alho, 3 folhas de louro, sal, pimenta, cheiro-verde.', '1. **Dessalgar e Preparar as Carnes Salgadas (Véspera):**
   - No dia anterior ao preparo, coloque 250g de carne-seca e 250g de costelinha de porco salgada de molho em água fria.
   - Troque a água a cada 4-6 horas (pelo menos 3-4 vezes) durante um período de 12 a 24 horas para remover o excesso de sal. Este passo é crucial para evitar que a feijoada fique excessivamente salgada.
   - Após dessalgar, escorra as carnes e reserve.
2. **Cozimento Inicial do Feijão e Carnes Duras:**
   - Lave 1 kg de feijão preto em água corrente.
   - Em uma panela de pressão grande, coloque o feijão preto lavado, a carne-seca dessalgada e a costelinha de porco dessalgada.
   - Adicione 3 folhas de louro e cubra com bastante água fria (cerca de 3-4 litros).
   - Leve ao fogo alto e, após a panela pegar pressão, reduza o fogo para médio e cozinhe por cerca de 30-40 minutos.
   - Desligue o fogo e espere a pressão sair naturalmente antes de abrir a panela. O feijão e as carnes devem estar começando a amaciar.
3. **Adição das Linguiças e Bacon:**
   - Com a panela de pressão aberta, adicione 200g de linguiça paio (em rodelas grossas), 200g de linguiça calabresa (em rodelas) e 150g de bacon (em cubos ou fatias grossas).
   - Se necessário, adicione mais água fervente para cobrir todos os ingredientes.
   - Cozinhe em fogo baixo por mais 20-30 minutos (sem pressão, ou com pressão por 10 min) até que todas as carnes estejam bem cozidas e macias, e o caldo comece a engrossar.
4. **Preparo do Refogado (Tempero da Feijoada):**
   - Enquanto a feijoada cozinha, prepare o refogado. Em uma frigideira separada, frite o bacon (se não o adicionou antes) em sua própria gordura até ficar crocante. Retire o bacon e reserve.
   - Na mesma frigideira, com a gordura do bacon, adicione 2 cebolas médias picadas e refogue até ficarem douradas e macias.
   - Acrescente 4 dentes de alho amassados ou picados e refogue por mais 1-2 minutos, até ficarem aromáticos, tomando cuidado para não queimar.
5. **Finalização e Apuração dos Sabores:**
   - Despeje o refogado aromático (cebola e alho) na panela da feijoada. Se tiver bacon frito, adicione-o também.
   - Misture bem todos os ingredientes.
   - Prove e ajuste o sal, se necessário (lembre-se que as carnes salgadas já contribuem com sal). Adicione pimenta-do-reino moída na hora a gosto.
   - Deixe a feijoada cozinhar em fogo baixo por mais 10-15 minutos, sem tampa, para que os sabores se apurem e o caldo engrosse um pouco mais.
   - Finalize com cheiro-verde fresco picado (salsinha e cebolinha).
6. **Servir:**
   - Sirva a Feijoada Completa bem quente, tradicionalmente acompanhada de arroz branco soltinho, couve refogada, farofa e fatias de laranja para cortar a gordura.', 1, 'https://img.freepik.com/fotos-gratis/feijoada-em-uma-tigela-de-ceramica-comida-tradicional-brasileira-em-um-fundo-de-madeira_528335-166.jpg?size=626&ext=jpg'),
('Sushi (Makisushi)', 3, 2, 5, '2 xícaras de arroz japonês, 2 ½ xícaras de água, ½ xícara de vinagre de arroz, 2 colheres de sopa de açúcar, 1 colher de chá de sal, folhas de alga nori, salmão ou atum fresco, pepino, manga, cream cheese.', '1. **Preparo do Arroz Japonês (Shari):**
   - Lave 2 xícaras de arroz japonês em água fria, esfregando suavemente com as mãos, até que a água escorra completamente limpa (isso pode levar 5-7 trocas de água). Este passo remove o excesso de amido e garante um arroz soltinho.
   - Deixe o arroz escorrer em uma peneira por pelo menos 30 minutos.
   - Transfira o arroz para uma panela de fundo grosso. Adicione 2 ½ xícaras de água. Leve ao fogo alto até ferver.
   - Assim que ferver, reduza o fogo para o mínimo, tampe a panela e cozinhe por 15-20 minutos, ou até que toda a água seja absorvida. Não levante a tampa durante o cozimento.
   - Desligue o fogo e deixe o arroz descansar, ainda tampado, por mais 10 minutos. Isso permite que o vapor termine o cozimento e os grãos fiquem perfeitos.
2. **Preparo do Tempero para Sushi (Sushi-zu):**
   - Enquanto o arroz cozinha, prepare o tempero. Em uma panela pequena, combine ½ xícara de vinagre de arroz, 2 colheres de sopa de açúcar e 1 colher de chá de sal.
   - Aqueça em fogo baixo, mexendo constantemente, até que o açúcar e o sal estejam completamente dissolvidos. Não deixe a mistura ferver, apenas aquecer o suficiente para dissolver.
3. **Temperar e Esfriar o Arroz:**
   - Transfira o arroz cozido e ainda quente para uma tigela grande de madeira ou plástico (evite metal, pois pode reagir com o vinagre).
   - Despeje o tempero de sushi (sushi-zu) sobre o arroz.
   - Usando uma espátula de madeira ou plástico, misture delicadamente o tempero ao arroz com movimentos de corte e dobra, evitando amassar os grãos.
   - Enquanto mistura, abane o arroz com um leque ou pedaço de papelão para esfriá-lo rapidamente até a temperatura ambiente. O arroz deve ficar brilhante e levemente pegajoso.
4. **Montagem do Maki (Rolo de Sushi):**
   - Coloque uma esteira de bambu (makisu) sobre uma superfície limpa. Cubra-a com plástico filme para facilitar a limpeza.
   - Posicione uma folha de alga nori (com o lado brilhante para baixo) sobre a esteira, alinhada com a borda mais próxima a você.
   - Umedeça levemente as mãos em uma tigela com água e um pouco de vinagre (tezu) para evitar que o arroz grude.
   - Pegue uma porção de arroz (cerca de ¾ de xícara) e espalhe uma camada fina e uniforme sobre a folha de nori, deixando uma borda de aproximadamente 2 cm livre na extremidade superior (a mais distante de você).
   - Disponha o recheio (salmão ou atum fresco fatiado, pepino em tiras finas, manga, cream cheese, etc.) em uma linha horizontal no centro do arroz. Não sobrecarregue com recheio.
5. **Enrolar e Cortar o Sushi:**
   - Com a ajuda da esteira de bambu, comece a enrolar o sushi firmemente a partir da borda mais próxima a você. Levante a esteira e o nori, dobrando-os sobre o recheio e pressionando suavemente para formar um rolo compacto.
   - Continue enrolando, puxando a esteira para frente e pressionando levemente para garantir que o rolo fique bem apertado e uniforme.
   - Umedeça a borda livre da alga nori com um pouco de água para selar o rolo.
   - Com uma faca bem afiada e úmida (passe a lâmina em água fria e limpe-a entre os cortes para evitar que o arroz grude), corte o rolo em 8 pedaços iguais.
   - Sirva imediatamente com molho shoyu, wasabi e gengibre em conserva.', 1, 'https://www.shutterstock.com/image-photo/overhead-japanese-sushi-food-maki-ands-2021573107'),
('Pad Thai', 4, 2, 1, '200g de noodles de arroz, 3 colheres de sopa de molho de peixe, 3 colheres de sopa de açúcar mascavo, 2 colheres de sopa de suco de tamarindo, 2 colheres de sopa de suco de limão, 200g de camarão ou frango, 2 ovos, 1 xícara de broto de feijão, ½ xícara de amendoim torrado.', '1. **Hidratar o Macarrão de Arroz (Noodles):**
   - Em uma tigela grande, mergulhe 200g de noodles de arroz (largura média) em água morna (não fervente) por cerca de 20-30 minutos. O tempo exato pode variar de acordo com a espessura do macarrão. O objetivo é que ele fique flexível, mas ainda firme e com uma leve resistência ao toque (não mole).
   - Escorra bem a água e reserve o macarrão. Se for demorar para usar, adicione um fio de óleo vegetal e misture para evitar que grude.
2. **Preparar o Molho Pad Thai (Equilíbrio de Sabores):**
   - Em uma tigela pequena, combine 3 colheres de sopa de molho de peixe, 3 colheres de sopa de açúcar mascavo (ou açúcar de palma ralado), 2 colheres de sopa de suco de tamarindo (concentrado, sem sementes) e 2 colheres de sopa de suco de limão fresco.
   - Misture bem até que o açúcar esteja completamente dissolvido. Prove e ajuste o equilíbrio entre doce, salgado, azedo e umami conforme sua preferência. Reserve.
3. **Saltear a Proteína (Camarão ou Frango):**
   - Aqueça uma wok ou frigideira grande e de fundo pesado em fogo alto. Adicione 1-2 colheres de sopa de óleo vegetal.
   - Quando o óleo estiver bem quente, adicione 200g de camarão descascado e limpo ou frango cortado em tiras finas. Salteie por 2-3 minutos, mexendo constantemente, até que a proteína esteja cozida e levemente dourada.
   - Retire a proteína da wok e reserve em um prato.
4. **Cozinhar os Ovos e a Base do Prato:**
   - Na mesma wok, se necessário, adicione mais 1 colher de sopa de óleo.
   - Quebre 2 ovos diretamente na wok e mexa rapidamente com uma espátula para fazer ovos mexidos. Cozinhe por cerca de 1 minuto, até ficarem quase prontos.
   - Empurre os ovos para um lado da wok. Adicione o macarrão de arroz hidratado ao centro da wok.
   - Despeje o molho Pad Thai preparado sobre o macarrão.
   - Cozinhe, mexendo e misturando vigorosamente o macarrão, os ovos e o molho por 2-3 minutos, garantindo que o macarrão absorva bem o sabor do molho.
5. **Finalizar e Servir (Textura e Frescor):**
   - Retorne a proteína cozida (camarão ou frango) à wok.
   - Adicione 1 xícara de broto de feijão e 2-3 cebolinhas picadas (parte branca e verde).
   - Misture tudo rapidamente por mais 1 minuto, apenas para aquecer os brotos de feijão e a cebolinha, mantendo sua crocância.
   - Transfira o Pad Thai para pratos individuais.
   - Sirva imediatamente, guarnecido com ½ xícara de amendoim torrado e picado, pimenta vermelha em flocos (se gostar de picante) e gomos de limão fresco para espremer na hora.', 1, 'https://www.shutterstock.com/image-photo/pad-thai-stirfried-rice-noodles-shrimp-260nw-1433479070.jpg'),
('Tacos al Pastor', 6, 2, 2, '500g de lombo de porco, 3 pimentas guajillo, 2 pimentas ancho, 30g de pasta de achiote, ¼ de xícara de vinagre, suco de abacaxi, 2 dentes de alho, orégano, cominho, tortilhas de milho, abacaxi, cebola, coentro.', '1. **Preparar a Marinada "Adobo" (Base de Sabor):**
   - Comece pelas pimentas secas: 3 pimentas guajillo e 2 pimentas ancho. Retire as sementes e os talos. Mergulhe-as em água quente por cerca de 20-30 minutos, ou até que fiquem macias e flexíveis.
   - No liquidificador, combine as pimentas hidratadas, 30g de pasta de achiote, ¼ de xícara de vinagre de maçã (ou branco), um pouco de suco de abacaxi (cerca de ¼ de xícara), 2 dentes de alho, 1 colher de chá de orégano mexicano e 1 colher de chá de cominho em pó.
   - Bata todos os ingredientes até obter uma pasta lisa e homogênea. Se necessário, adicione um pouco mais de suco de abacaxi ou água para ajudar a bater, mas mantenha a marinada espessa. Tempere com sal a gosto.
2. **Marinar a Carne de Porco (Infusão de Sabor):**
   - Fatie 500g de lombo de porco em bifes bem finos (cerca de 0,5 cm de espessura).
   - Em uma tigela grande, cubra completamente as fatias de carne com a marinada "adobo", garantindo que cada pedaço esteja bem envolvido.
   - Cubra a tigela e leve à geladeira para marinar por pelo menos 4 horas, ou idealmente, de um dia para o outro (12-24 horas) para que os sabores se aprofundem.
3. **Cozinhar a Carne (Métodos Alternativos ao Trompo):**
   - **Método Tradicional (Forno):** Empilhe as fatias de carne marinada em um espeto vertical (se tiver) ou em uma assadeira. Asse em forno pré-aquecido a 180°C por cerca de 30-40 minutos, ou até que a carne esteja cozida e levemente caramelizada nas bordas.
   - **Método Alternativo (Frigideira/Chapa):** Aqueça uma frigideira grande ou chapa em fogo médio-alto com um pouco de óleo. Grelhe as fatias de carne em lotes, por 2-3 minutos de cada lado, até dourarem e cozinharem por completo. Fatie a carne em pedaços pequenos, característicos dos tacos al pastor.
4. **Grelhar o Abacaxi (Doçura e Acidez):**
   - Corte fatias de abacaxi fresco em cubos pequenos.
   - Em uma frigideira ou chapa quente, grelhe os pedaços de abacaxi por alguns minutos de cada lado, até ficarem levemente caramelizados e com marcas de grelha. O abacaxi adiciona uma doçura e acidez que complementam a carne.
5. **Montar os Tacos (Experiência Completa):**
   - Aqueça as tortilhas de milho em uma chapa seca, frigideira ou micro-ondas até ficarem macias e flexíveis.
   - Para montar cada taco, coloque uma porção generosa da carne de porco "al pastor" no centro de uma tortilha.
   - Adicione pedaços de abacaxi grelhado, cebola branca ou roxa finamente picada e coentro fresco picado a gosto.
   - Sirva imediatamente, acompanhado de molho picante (salsa) e limão para espremer.', 1, 'https://media.istockphoto.com/id/1322282497/photo/delicious-tacos-al-pastor-with-toppings-in-a-traditional-mexican-restaurant.jpg?s=612x612&w=0&k=20&c=3V253wG3gH-C8z_A-3a-5m7d_1s_aQy1f5v0j2cKjYc='),
('Butter Chicken (Frango na Manteiga)', 7, 2, 6, '600g de frango, ½ xícara de iogurte, 1 colher de sopa de pasta de alho e gengibre, 1 colher de sopa de suco de limão, Garam Masala, cúrcuma, cominho, 2 colheres de sopa de manteiga, 1 cebola, 400g de tomate pelado, 35g de castanha de caju, 200 ml de creme de leite.', '1. **Marinar o Frango (Primeira Marinada para Sabor e Maciez):**
   - Corte 600g de frango (peito ou coxa/sobrecoxa desossada) em cubos de aproximadamente 3-4 cm.
   - Em uma tigela grande, misture o frango com ½ xícara de iogurte natural (sem açúcar), 1 colher de sopa de pasta de alho e gengibre (ou 1 dente de alho picado e 1 cm de gengibre ralado), 1 colher de sopa de suco de limão fresco, 1 colher de chá de garam masala, ½ colher de chá de cúrcuma em pó e ½ colher de chá de cominho em pó.
   - Certifique-se de que todos os pedaços de frango estejam bem cobertos pela marinada. Cubra a tigela e leve à geladeira para marinar por pelo menos 1 hora, ou idealmente por 4-6 horas para um sabor mais intenso e carne mais macia.
2. **Grelhar ou Selar o Frango Marinado:**
   - Aqueça uma frigideira grande ou chapa em fogo médio-alto com 1 colher de sopa de óleo vegetal.
   - Retire o frango da marinada (descarte o excesso de marinada) e grelhe ou sele os pedaços em lotes, por 3-4 minutos de cada lado, até ficarem dourados e cozidos por fora. Não é necessário cozinhar completamente por dentro, pois ele terminará de cozinhar no molho.
   - Retire o frango da frigideira e reserve em um prato.
3. **Preparar a Base do Molho (Aromáticos e Tomate):**
   - Na mesma panela (se necessário, adicione mais 1 colher de sopa de manteiga), derreta 2 colheres de sopa de manteiga em fogo médio.
   - Adicione 1 cebola média picada finamente e refogue por 5-7 minutos, mexendo ocasionalmente, até ficar macia e translúcida.
   - Acrescente mais 1 colher de sopa de pasta de alho e gengibre (ou 1 dente de alho picado e 1 cm de gengibre ralado) e refogue por mais 1 minuto, até ficar aromático.
   - Junte 400g de tomate pelado (amassado ou picado) e 35g de castanhas de caju (inteiras ou quebradas).
   - Cozinhe em fogo baixo por 10-15 minutos, mexendo ocasionalmente, para que os sabores se desenvolvam e o tomate se desfaça.
4. **Bater e Coar o Molho (Textura Aveludada):**
   - Retire a panela do fogo e deixe o molho esfriar um pouco.
   - Transfira todo o conteúdo da panela para um liquidificador e bata até obter um creme liso e aveludado.
   - Para uma textura ainda mais fina e sedosa, passe o molho por uma peneira fina de volta para a panela.
5. **Finalizar o Butter Chicken (Cremosidade e Integração):**
   - Leve o molho coado de volta ao fogo baixo.
   - Adicione o frango grelhado reservado e 200ml de creme de leite fresco (ou creme de leite de caixinha).
   - Cozinhe em fogo baixo por 5-10 minutos, mexendo delicadamente, para que o frango termine de cozinhar no molho e os sabores se incorporem.
   - Prove e ajuste o tempero com sal, pimenta e, se desejar, uma pitada extra de garam masala.
   - Sirva o Butter Chicken quente, tradicionalmente acompanhado de arroz basmati soltinho, pão naan fresco ou chapati. Decore com folhas de coentro fresco picado.', 1, 'https://www.gettyimages.com/gi-resources/images/500px/983794168.jpg'),
('Wiener Schnitzel', 9, 2, 2, '4 bifes finos de vitela, 50g de farinha de trigo, 2 ovos, 50g de farinha de rosca, sal, pimenta-do-reino, óleo vegetal.', '1. **Preparar a Carne (Afinar e Tenderizar):**
   - Pegue 4 bifes finos de vitela (cerca de 150-200g cada). Coloque cada bife entre duas folhas de plástico filme ou dentro de um saco plástico resistente.
   - Com um martelo de carne (o lado liso) ou um rolo de massa, bata os bifes delicadamente, mas firmemente, até que fiquem bem finos, com aproximadamente 2-3 mm de espessura. O objetivo é uniformizar a espessura para um cozimento rápido e homogêneo.
2. **Temperar a Vitela:**
   - Tempere os bifes afinados generosamente com sal e pimenta-do-reino moída na hora em ambos os lados.
3. **Preparar a Estação de Empanamento (Mise en Place):**
   - Prepare três pratos fundos ou recipientes rasos para o empanamento.
     - **Primeiro prato:** 50g de farinha de trigo (cerca de ½ xícara).
     - **Segundo prato:** 2 ovos grandes batidos com um garfo, adicionando uma pitada de sal e 1 colher de sopa de água ou leite para diluir levemente.
     - **Terceiro prato:** 50g de farinha de rosca (cerca de 1 xícara), preferencialmente pão ralado fresco para uma textura mais crocante.
4. **Empanar os Schnitzels (Camadas Crocantes):**
   - Passe cada bife primeiro na farinha de trigo, cobrindo todos os lados e sacudindo o excesso.
   - Em seguida, mergulhe o bife nos ovos batidos, garantindo que esteja completamente coberto. Deixe escorrer o excesso de ovo.
   - Por último, passe o bife na farinha de rosca, pressionando levemente com as mãos para que a farinha adira bem e forme uma camada uniforme. Certifique-se de que não há áreas sem cobertura.
   - Coloque os schnitzels empanados em uma assadeira ou prato e reserve.
5. **Fritar os Schnitzels (Dourado e Crocante):**
   - Em uma frigideira grande e de fundo pesado, aqueça uma quantidade generosa de óleo vegetal (óleo de girassol, canola ou manteiga clarificada/ghee são boas opções) em fogo médio-alto. O óleo deve ter profundidade suficiente para que o schnitzel "flutue" parcialmente (cerca de 1-2 cm de altura).
   - Quando o óleo estiver quente (cerca de 170-180°C), frite um bife de cada vez para não superlotar a frigideira e baixar a temperatura do óleo.
   - Frite por 2-3 minutos de cada lado, ou até que o schnitzel esteja dourado, crocante e com as bolhas características na superfície.
   - Dica: Durante a fritura, você pode inclinar a frigideira e usar uma colher para regar a parte superior do schnitzel com o óleo quente, ajudando a criar as bolhas e a crocância.
6. **Escorrer e Servir (Frescor e Tradição):**
   - Retire o schnitzel frito da frigideira e coloque-o sobre papel toalha para escorrer o excesso de gordura.
   - Sirva imediatamente, enquanto ainda está quente e crocante. O acompanhamento clássico é uma fatia de limão fresco para espremer sobre a carne, batatas cozidas ou salada de batata.', 1, 'https://images.unsplash.com/photo-1599921841143-819762ae7a1f?ixid=M3wxNDc5Mzh8MHwxfGFsbHx8fHx8fHx8fDE3MjY1MTI5MDF8&ixlib=rb-4.0.3&q=85&w=1920'),
('Moussaka', 10, 2, 2, '3 berinjelas, 4 batatas, 1 kg de carne moída, 1 cebola, 2 dentes de alho, 400g de molho de tomate, canela, orégano, sal, pimenta, 50g de manteiga, 2 colheres de sopa de farinha de trigo, 500ml de leite, 1 ovo, 50g de queijo parmesão, noz-moscada.', '1. **Preparar e Pré-cozinhar os Vegetais (Berinjelas e Batatas):**
   - Lave bem 3 berinjelas e 4 batatas médias. Corte-as em fatias de aproximadamente 0,5 cm de espessura.
   - **Para as Berinjelas:** Polvilhe sal sobre as fatias de berinjela e deixe-as descansar em uma peneira por 30 minutos. Isso ajuda a remover o excesso de água e o amargor. Enxágue e seque bem com papel toalha.
   - **Pré-cozimento:** Em uma frigideira grande com um pouco de azeite, grelhe ou frite as fatias de berinjela e batata em lotes até dourarem levemente e ficarem macias. Alternativamente, você pode assá-las no forno a 200°C com um fio de azeite por 15-20 minutos. Reserve.
2. **Preparar o Molho de Carne (Ragu Grego):**
   - Em uma panela grande, aqueça um fio de azeite em fogo médio. Adicione 1 cebola média picada finamente e refogue até ficar translúcida (cerca de 5 minutos).
   - Acrescente 2 dentes de alho picados e refogue por mais 1 minuto, até ficar aromático.
   - Adicione 1 kg de carne moída (bovina ou mista) e cozinhe, desfazendo os grumos, até dourar completamente. Escorra o excesso de gordura.
   - Incorpore 400g de molho de tomate (ou tomate pelado amassado), 1 colher de chá de canela em pó (ingrediente chave da moussaka), 1 colher de chá de orégano seco, sal e pimenta-do-reino moída na hora a gosto.
   - Reduza o fogo para baixo, tampe e cozinhe por pelo menos 20-30 minutos, mexendo ocasionalmente, para que os sabores se aprofundem. O molho deve ficar encorpado.
3. **Preparar o Molho Bechamel Cremoso (Cobertura):**
   - Em outra panela média, derreta 50g de manteiga em fogo médio.
   - Adicione 2 colheres de sopa de farinha de trigo e cozinhe, mexendo constantemente, por 1-2 minutos para formar um roux (pasta).
   - Aos poucos, adicione 500ml de leite integral quente, mexendo vigorosamente com um fouet para evitar a formação de grumos.
   - Cozinhe em fogo médio-baixo, mexendo sempre, até o molho engrossar e atingir uma consistência cremosa (cerca de 5-7 minutos).
   - Retire do fogo. Tempere com sal, pimenta-do-reino e uma pitada generosa de noz-moscada ralada na hora.
   - Deixe o molho esfriar um pouco. Em seguida, misture 1 ovo batido e 50g de queijo parmesão ralado. O ovo ajuda a dar estrutura e cor ao bechamel durante o cozimento.
4. **Montagem da Moussaka (Camadas Saborosas):**
   - Pré-aqueça o forno a 180°C.
   - Em um refratário grande (aproximadamente 20x30 cm), comece com uma camada de fatias de batata pré-cozidas no fundo.
   - Em seguida, adicione uma camada de fatias de berinjela pré-cozidas.
   - Espalhe metade do molho de carne sobre as berinjelas.
   - Repita as camadas: mais uma camada de berinjela, o restante do molho de carne e, por fim, a última camada de berinjela.
   - Despeje cuidadosamente o molho bechamel sobre a última camada de berinjela, espalhando uniformemente para cobrir toda a superfície.
5. **Assar e Servir (Dourado e Borbulhante):**
   - Leve ao forno pré-aquecido a 180°C por 45-60 minutos, ou até que a superfície esteja dourada, borbulhante e o molho bechamel esteja firme.
   - Retire do forno e deixe a moussaka descansar por pelo menos 15-20 minutos antes de cortar e servir. Isso permite que as camadas se firmem e facilita o corte.
   - Sirva quente, acompanhada de uma salada fresca.', 1, 'https://www.shutterstock.com/image-photo/moussaka-layer-rich-tomato-beef-600w-1933123999.jpg'),
('Goulash', 11, 2, 2, '1 kg de carne bovina, 2 cebolas, 3 dentes de alho, 2 colheres de sopa de páprica doce, 1 colher de chá de páprica picante, 1 colher de sopa de farinha de trigo, 400g de tomate pelado, 1 litro de caldo de carne, sal, pimenta-do-reino.', '1. **Preparar e Dourar a Carne (Selagem para Sabor):**
   - Corte 1 kg de carne bovina (paleta, acém ou músculo são boas opções) em cubos de aproximadamente 3 cm.
   - Tempere os cubos de carne generosamente com sal e pimenta-do-reino moída na hora.
   - Em uma panela grande e pesada (idealmente de ferro fundido ou com fundo grosso), aqueça 2-3 colheres de sopa de óleo vegetal em fogo alto.
   - Doure a carne em lotes, sem superlotar a panela. O objetivo é criar uma crosta caramelizada em todos os lados, o que adiciona profundidade de sabor ao goulash. Retire a carne dourada da panela e reserve.
2. **Refogar os Aromáticos (Base do Molho):**
   - Na mesma panela (se necessário, adicione um pouco mais de óleo), reduza o fogo para médio.
   - Adicione 2 cebolas grandes fatiadas finamente e refogue por 8-10 minutos, mexendo ocasionalmente, até ficarem bem macias, translúcidas e levemente caramelizadas. Este passo é crucial para a doçura e profundidade do molho.
   - Acrescente 3 dentes de alho picados e refogue por mais 1-2 minutos, até ficarem aromáticos, tomando cuidado para não queimar.
3. **Adicionar Temperos e Tomate (Construção do Sabor):**
   - Polvilhe 1 colher de sopa de farinha de trigo sobre as cebolas e o alho. Cozinhe por 1 minuto, mexendo, para tostar a farinha e remover o sabor de cru. Isso também ajudará a engrossar o molho.
   - Adicione 2 colheres de sopa de páprica doce e 1 colher de chá de páprica picante (ajuste a quantidade de páprica picante ao seu gosto). Mexa bem e cozinhe por mais 30 segundos, liberando os aromas das especiarias.
   - Incorpore 400g de tomate pelado (amassado com um garfo ou picado). Mexa e cozinhe por 5 minutos, raspando o fundo da panela para soltar qualquer resíduo.
4. **Cozinhar Lentamente (Ternura e Sabor):**
   - Retorne a carne dourada à panela.
   - Despeje 1 litro de caldo de carne quente sobre a carne e os vegetais. Certifique-se de que a carne esteja submersa.
   - Leve a mistura para ferver, então reduza o fogo para o mínimo, tampe a panela e cozinhe lentamente por 2 a 3 horas. O tempo exato dependerá do corte da carne, mas o objetivo é que a carne esteja extremamente macia e desmanchando, e o molho tenha encorpado e desenvolvido um sabor rico e profundo. Mexa ocasionalmente para evitar que grude no fundo.
5. **Finalização e Servir (Ajustes Finais):**
   - Prove o goulash e ajuste o sal e a pimenta-do-reino moída na hora, se necessário.
   - Se o molho estiver muito ralo, você pode cozinhar sem tampa por mais alguns minutos para reduzir. Se estiver muito espesso, adicione um pouco mais de caldo.
   - Sirva o goulash quente, tradicionalmente acompanhado de purê de batata, spätzle (um tipo de macarrão alemão), pão fresco ou macarrão. Decore com um pouco de salsinha fresca picada, se desejar.', 1, 'https://www.simplyrecipes.com/thmb/k13FFRk_8I0u_yI2d3N2h2iA3aA=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/Simply-Recipes-Goulash-LEAD-04-6985750b6f33433e8771b811521adad6.jpg'),
('Pierogi', 12, 2, 1, '1 kg de farinha de trigo, 1 ovo, 1 colher de chá de sal, 250ml de água morna, 1 kg de batatas cozidas, 150g de queijo parmesão, sal, pimenta-do-reino, 200g de manteiga, 2 cebolas.', '1. **Preparar o Recheio de Batata e Queijo (Sabor e Textura):**
   - Cozinhe 1 kg de batatas (tipo Aster ou Monalisa) com casca em água salgada até ficarem bem macias. Descasque-as ainda quentes e amasse-as com um garfo ou espremedor de batatas até obter um puré liso.
   - Em uma tigela, misture o puré de batatas com 150g de queijo parmesão ralado (ou outro queijo de sua preferência, como queijo cottage ou ricota para uma versão mais leve).
   - Tempere com sal e pimenta-do-reino moída na hora a gosto. Misture bem e reserve. O recheio deve estar frio antes de ser usado para facilitar a montagem.
2. **Preparar a Massa do Pierogi (Elástica e Maleável):**
   - Em uma tigela grande, misture 1 kg de farinha de trigo com 1 colher de chá de sal.
   - Faça um buraco no centro da farinha e adicione 1 ovo grande e 250ml de água morna (cerca de 35-40°C).
   - Com um garfo, comece a misturar os ingredientes do centro para as bordas, incorporando a farinha gradualmente até formar uma massa rústica.
   - Transfira a massa para uma superfície levemente enfarinhada e sove por 5-7 minutos, até que fique lisa, elástica e homogênea. A massa deve ser firme, mas maleável.
   - Forme uma bola com a massa, cubra com um pano de prato limpo e deixe descansar por pelo menos 30 minutos em temperatura ambiente. Isso permite que o glúten relaxe, facilitando a abertura da massa.
3. **Montar os Pierogi (Formato Tradicional):**
   - Divida a massa em 2-3 porções para facilitar o manuseio. Em uma superfície levemente enfarinhada, abra cada porção de massa com um rolo até que fique bem fina (cerca de 1-2 mm de espessura).
   - Use um cortador redondo (cerca de 6-8 cm de diâmetro) para cortar círculos de massa.
   - Coloque uma colher de chá cheia do recheio de batata e queijo no centro de cada círculo de massa.
   - Dobre o círculo ao meio, formando uma meia-lua. Pressione firmemente as bordas com os dedos para selar bem o pierogi, garantindo que o recheio não escape durante o cozimento. Você pode usar um garfo para criar um padrão decorativo e selar ainda mais.
   - Coloque os pierogi montados em uma assadeira enfarinhada, garantindo que não se toquem para não grudar.
4. **Cozinhar os Pierogi (Ponto Ideal):**
   - Em uma panela grande, ferva bastante água salgada.
   - Adicione os pierogi à água fervente em lotes, sem superlotar a panela.
   - Cozinhe por 3-5 minutos após eles flutuarem para a superfície. Eles estarão prontos quando a massa estiver macia e o recheio aquecido.
   - Retire os pierogi cozidos com uma escumadeira e escorra bem.
5. **Finalizar e Servir (Dourado e Saboroso):**
   - Em uma frigideira grande, derreta 200g de manteiga em fogo médio.
   - Adicione 2 cebolas médias picadas finamente e refogue até ficarem douradas e crocantes (cerca de 8-10 minutos).
   - Adicione os pierogi cozidos à frigideira com a manteiga e a cebola. Frite-os por alguns minutos de cada lado, até ficarem levemente dourados e crocantes.
   - Sirva os pierogi quentes, regados com a manteiga dourada e as cebolas crocantes. Tradicionalmente, são acompanhados de creme azedo (sour cream) ou iogurte natural.', 1, 'https://media.istockphoto.com/id/1279233632/photo/fried-dumplings-stuffed-with-cabbage-and-meat-sprinkled-with-bacon-greaves-and-chopped.jpg?s=612x612&w=0&k=20&c=pY-03_13y2v_j2J3L3g_O4pr9pS_N32mI3l2Qj5i2yA='),
('Pastel de Nata', 13, 3, 1, 'Massa folhada, 500ml de leite, 7 gemas, 250g de açúcar, 50g de farinha de trigo, 125ml de água, casca de limão, pau de canela.', '1. **Preparar as Formas com a Massa Folhada (Base Crocante):**
   - Em uma superfície levemente enfarinhada, abra a massa folhada (pronta, de boa qualidade) em um retângulo.
   - Enrole a massa folhada firmemente como um rocambole.
   - Com uma faca afiada, corte o rolo em rodelas de aproximadamente 2 cm de espessura.
   - Unte levemente forminhas de pastel de nata (ou forminhas de cupcake) com manteiga.
   - Coloque uma rodela de massa em cada forminha. Com os polegares umedecidos em água, pressione a massa do centro para as bordas, forrando o fundo e as laterais da forma. O objetivo é deixar a massa bem fina no fundo e um pouco mais alta nas laterais, formando uma pequena borda.
   - Leve as formas com a massa à geladeira enquanto prepara o creme.
2. **Preparar a Calda de Açúcar (Base do Creme):**
   - Em uma panela pequena, combine 125ml de água e 250g de açúcar. Leve ao fogo médio, mexendo ocasionalmente, até o açúcar dissolver completamente.
   - Deixe a calda ferver por cerca de 3-5 minutos, sem mexer, até atingir o ponto de fio fraco (quando você levanta a colher, a calda forma um fio que se quebra rapidamente). Reserve.
3. **Preparar o Creme de Leite e Gemas (Recheio Cremoso):**
   - Em outra panela, aqueça 500ml de leite integral com 1 casca de limão (apenas a parte amarela, sem a branca para evitar amargor) e 1 pau de canela em fogo médio, até quase ferver. Retire do fogo e deixe em infusão por 10 minutos. Coe e descarte a casca de limão e a canela.
   - Em uma tigela pequena, misture 50g de farinha de trigo com um pouco do leite frio (cerca de 50ml) para dissolver, formando uma pasta lisa.
   - Adicione essa mistura de farinha ao restante do leite quente (já coado), mexendo sempre com um fouet para evitar grumos.
   - Leve a panela de volta ao fogo médio-baixo e cozinhe, mexendo constantemente, até o creme engrossar e atingir a consistência de um mingau ralo. Retire do fogo.
   - Verta a calda de açúcar quente (preparada no passo 2) sobre o creme de leite, mexendo rapidamente e vigorosamente para incorporar.
   - Deixe o creme esfriar um pouco (até ficar morno). Em seguida, adicione 7 gemas peneiradas (para evitar a película e o cheiro de ovo), misturando bem, mas sem bater demais para não incorporar ar.
4. **Rechear e Assar os Pastéis de Nata (Caramelização Perfeita):**
   - Pré-aqueça o forno na temperatura máxima possível (idealmente entre 250-300°C). É crucial que o forno esteja muito quente para que a massa folheie e o creme caramelize rapidamente.
   - Retire as forminhas com a massa da geladeira. Preencha cada forminha com o creme, deixando uma pequena borda (cerca de 0,5 cm) livre.
   - Leve ao forno pré-aquecido por 10-15 minutos, ou até que a massa esteja crocante e dourada, e o creme apresente as características manchas escuras e caramelizadas na superfície. O tempo exato pode variar muito dependendo do seu forno.
   - Retire do forno e deixe esfriar um pouco nas forminhas antes de desenformar.
   - Sirva os Pastéis de Nata mornos ou em temperatura ambiente, polvilhados com canela em pó, se desejar.', 1, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8MXx8fGVufDB8fHx8fA%3D%3D'),
('Fish and Chips', 14, 2, 5, '800g de filé de peixe branco, sal, pimenta-do-reino, 1.5 xícara de farinha de trigo, 0.5 xícara de amido de milho, 1 colher de chá de fermento em pó, 350ml de cerveja clara, 1 kg de batatas, óleo vegetal.', '1. **Preparar as Batatas (Fritura Dupla para Crocância):**
   - Descasque 1 kg de batatas (idealmente batatas tipo Russet ou Aster) e corte-as em palitos grossos de aproximadamente 1 cm de espessura.
   - Lave os palitos de batata em água fria por alguns minutos para remover o excesso de amido. Seque-os completamente com um pano de prato limpo ou papel toalha. A secagem é crucial para a crocância.
   - Em uma panela funda ou fritadeira, aqueça óleo vegetal (girassol, canola ou amendoim) a 160°C.
   - Frite as batatas em lotes (sem superlotar a panela) por 5-7 minutos na primeira fritura. Elas devem cozinhar por dentro, mas não devem dourar. Retire as batatas e escorra-as em papel toalha. Deixe-as esfriar completamente. Este é o processo de "branqueamento".
2. **Preparar a Massa do Peixe (Leve e Crocante):**
   - Em uma tigela grande, misture 1.5 xícara de farinha de trigo, 0.5 xícara de amido de milho, 1 colher de chá de fermento em pó, ½ colher de chá de sal e ¼ colher de chá de pimenta-do-reino moída na hora.
   - Aos poucos, adicione 350ml de cerveja clara bem gelada à mistura de secos, mexendo com um fouet até obter uma massa homogênea e espessa, com a consistência de um creme para panquecas. Não misture demais para não desenvolver o glúten. Reserve na geladeira por 15-20 minutos.
3. **Fritar o Peixe e as Batatas (Segunda Fritura):**
   - Aumente a temperatura do óleo na panela para 180°C.
   - **Para o Peixe:** Seque bem os 800g de filés de peixe branco (bacalhau, haddock ou tilápia são boas opções) com papel toalha. Tempere com sal e pimenta.
   - Passe cada filé de peixe primeiro em um pouco de farinha de trigo seca (isso ajuda a massa a aderir melhor) e depois mergulhe-o completamente na massa de cerveja, garantindo que esteja bem coberto.
   - Frite os filés de peixe, um ou dois por vez, por 5-8 minutos, virando na metade do tempo, até que a massa esteja dourada, crocante e o peixe cozido por dentro. Retire e escorra em papel toalha.
   - **Para as Batatas:** Aumente a temperatura do óleo para 190°C. Frite as batatas pré-cozidas novamente em lotes por 2-4 minutos, ou até ficarem douradas e extremamente crocantes. Retire e escorra em papel toalha.
4. **Servir (Quente e Tradicional):**
   - Sirva o peixe frito e as batatas fritas imediatamente, temperados com sal a gosto.
   - Tradicionalmente, o Fish and Chips é acompanhado de molho tártaro, purê de ervilhas (mushy peas) e uma fatia de limão para espremer sobre o peixe.', 1, 'https://i.ytimg.com/vi/r0iW3p3Z_pA/maxresdefault.jpg'),
('Peking Duck', 5, 2, 6, '1 pato inteiro, mel, molho shoyu, vinagre, água, alho, gengibre, pimenta-de-sichuan, farinha de trigo, cebolinha, pepino.', '1. **Preparar o Pato (Limpeza e Escaldamento para Pele Crocante):**
   - Limpe bem 1 pato inteiro (cerca de 2-2.5 kg), removendo vísceras e excesso de gordura. Lave-o por dentro e por fora e seque-o completamente com papel toalha.
   - Ferva uma panela grande de água. Com cuidado, segure o pato pelo pescoço e escalde a pele com a água fervente por 2-3 minutos, despejando a água sobre toda a superfície. Isso ajuda a esticar a pele e a abrir os poros, facilitando a crocância.
   - Seque o pato novamente, por dentro e por fora, o mais completamente possível.
2. **Laquear o Pato e Secagem (Chave para a Crocância):**
   - Em uma tigela, misture 3 colheres de sopa de mel, 2 colheres de sopa de molho shoyu, 1 colher de sopa de vinagre de arroz (ou branco) e 1 colher de chá de cinco especiarias chinesas (opcional).
   - Pincele generosamente essa mistura por toda a pele do pato.
   - Pendure o pato em um local fresco e arejado (ou coloque-o sobre uma grade em uma assadeira na geladeira, descoberto) por pelo menos 6-8 horas, ou idealmente por 12-24 horas. A secagem da pele é o passo mais importante para garantir a crocância final.
3. **Assar o Pato (Cozimento Lento e Crocância Final):**
   - Pré-aqueça o forno a 180°C.
   - Coloque o pato em uma grade sobre uma assadeira (com um pouco de água no fundo da assadeira para coletar a gordura e evitar fumaça excessiva).
   - Asse o pato por cerca de 1 a 1.5 horas, ou até que a carne esteja cozida e a pele bem crocante e caramelizada. Vire o pato na metade do tempo para garantir um cozimento uniforme.
   - Para uma pele ainda mais crocante, você pode aumentar a temperatura do forno para 200-220°C nos últimos 15-20 minutos, observando cuidadosamente para não queimar.
   - Retire o pato do forno e deixe-o descansar por 10-15 minutos antes de fatiar.
4. **Preparar Acompanhamentos (Essenciais para a Experiência):**
   - Enquanto o pato assa, prepare os acompanhamentos tradicionais:
     - **Panquecas Chinesas (Mandarin Pancakes):** Podem ser compradas prontas ou feitas em casa. Aqueça-as no vapor ou em uma frigideira seca.
     - **Molho Hoisin:** Sirva em uma tigela pequena.
     - **Vegetais:** Corte cebolinha verde em tiras finas (julienne) e pepino em tiras finas.
5. **Servir (Montagem Interativa):**
   - Fatie a pele crocante do pato em pedaços pequenos e a carne em fatias finas.
   - Sirva o pato fatiado e os acompanhamentos separadamente.
   - Cada pessoa monta sua própria panqueca: espalhe um pouco de molho hoisin na panqueca, adicione fatias de pele e carne de pato, cebolinha e pepino. Enrole a panqueca e desfrute.', 1, 'https://i.ytimg.com/vi/5fN5n_5g_2o/maxresdefault.jpg'),
('Tandoori Chicken', 7, 2, 6, '1 kg de frango, 1 copo de iogurte natural, 3 dentes de alho, 3 cm de gengibre, 2 colheres de sopa de óleo, 2 colheres de chá de cominho, 1 colher de chá de coentro, 1 colher de chá de açafrão, páprica.', '1. **Preparar o Frango (Cortes e Primeira Marinada Ácida):**
   - Use 1 kg de frango (coxas e sobrecoxas com osso e pele são ideais para suculência, ou peito para uma versão mais leve). Faça cortes profundos na carne (2-3 cortes por pedaço) para que a marinada penetre bem.
   - Em uma tigela, tempere o frango com o suco de 1 limão e 1 colher de chá de sal. Misture bem e deixe descansar por 20 minutos em temperatura ambiente. Esta marinada ácida ajuda a amaciar a carne e a prepará-la para a segunda marinada.
2. **Preparar a Marinada Tandoori (Iogurte e Especiarias):**
   - Em outra tigela grande, combine 1 copo de iogurte natural (sem açúcar), 3 dentes de alho amassados ou picados, 3 cm de gengibre fresco ralado ou picado, 2 colheres de sopa de óleo vegetal, 2 colheres de chá de cominho em pó, 1 colher de chá de coentro em pó, 1 colher de chá de açafrão-da-terra (cúrcuma) em pó e 1 colher de chá de páprica doce (ou picante, se preferir). Para a cor vermelha característica, você pode adicionar uma pitada de corante alimentício vermelho (opcional).
   - Misture todos os ingredientes até formar uma pasta homogênea e aromática.
3. **Marinar o Frango (Infusão Profunda de Sabor):**
   - Escorra o excesso de líquido da primeira marinada do frango.
   - Adicione o frango à marinada tandoori de iogurte e especiarias, garantindo que cada pedaço esteja completamente coberto e que a marinada penetre nos cortes.
   - Cubra a tigela e leve à geladeira para marinar por pelo menos 4 horas, ou idealmente de um dia para o outro (12-24 horas). Quanto mais tempo marinar, mais saboroso e macio o frango ficará.
4. **Assar o Frango Tandoori (Cozimento e Crocância):**
   - Pré-aqueça o forno a 220°C. Se tiver, use a função grill ou broiler nos últimos minutos para um acabamento mais carbonizado.
   - Coloque o frango marinado em uma grelha sobre uma assadeira (para que a gordura escorra).
   - Asse por 25-35 minutos, virando o frango na metade do tempo, ou até que esteja cozido por completo (temperatura interna de 75°C), com as bordas levemente carbonizadas e a pele crocante.
   - Se estiver usando um forno com grill, nos últimos 5-7 minutos, coloque o frango mais perto do grill para obter um belo acabamento carbonizado, observando cuidadosamente para não queimar.
5. **Servir (Acompanhamentos Tradicionais):**
   - Retire o frango do forno e deixe descansar por alguns minutos.
   - Sirva o Tandoori Chicken quente, tradicionalmente acompanhado de gomos de limão fresco para espremer, rodelas de cebola roxa, chutney de menta, arroz basmati soltinho e pão naan fresco.', 1, 'https://www.recipetineats.com/wp-content/uploads/2019/05/Tandoori-Chicken_3-1.jpg'),
('Ramen', 3, 2, 4, '1 litro de caldo de galinha, 1 litro de água, 2-4 colheres de sopa de molho shoyu, 1-2 colheres de sopa de mirin, 100g de cogumelos shiitake, 2-4 pacotes de macarrão para ramen, ovos cozidos, lombo de porco, cebolinha, alga nori.', '1. **Preparar o Caldo Base (Dashi e Tare):**
   - Em uma panela grande, combine 1 litro de caldo de galinha (caseiro ou de boa qualidade) e 1 litro de água.
   - Adicione 2-3 dentes de alho fatiados, 3-4 fatias finas de gengibre fresco, e 100g de cogumelos shiitake frescos (ou secos reidratados).
   - Para o "Tare" (tempero concentrado que dá profundidade ao caldo), adicione 2-4 colheres de sopa de molho shoyu e 1-2 colheres de sopa de mirin (vinho de arroz doce).
   - Leve ao fogo baixo e cozinhe por pelo menos 30-40 minutos, ou até 1 hora, para que os sabores se apurem e se infundam no caldo.
   - Coe o caldo antes de servir para remover os sólidos, deixando-o limpo e aromático. Mantenha o caldo quente.
2. **Cozinhar o Macarrão para Ramen (Al Dente):**
   - Em uma panela separada, ferva bastante água.
   - Cozinhe 2-4 pacotes de macarrão para ramen (fresco ou seco) conforme as instruções da embalagem, geralmente por 2-3 minutos, até ficar "al dente" (firme, mas cozido).
   - Escorra o macarrão imediatamente e, se não for usar na hora, passe rapidamente por água fria para interromper o cozimento e evitar que grude. Escorra novamente.
3. **Preparar os Acompanhamentos (Toppings Essenciais):**
   - Enquanto o caldo e o macarrão cozinham, prepare os acompanhamentos:
     - **Ovos Cozidos (Ajitsuke Tamago):** Cozinhe ovos por 6-7 minutos para gemas cremosas. Descasque e corte ao meio. Opcional: marine os ovos descascados em uma mistura de shoyu, mirin e água por algumas horas para um sabor mais autêntico.
     - **Lombo de Porco (Chashu):** Fatie finamente o lombo de porco cozido (chashu, se tiver pronto) ou use fatias de carne de porco grelhada/assada.
     - **Cebolinha:** Pique finamente a cebolinha verde.
     - **Alga Nori:** Corte folhas de alga nori em retângulos ou tiras.
     - **Outros Opcionais:** Brotos de bambu, milho, narutomaki (massa de peixe), óleo de gergelim torrado, pimenta em flocos.
4. **Montar o Ramen (Camadas de Sabor e Textura):**
   - Aqueça as tigelas individuais de ramen (pode ser com água quente e depois esvaziando).
   - Divida o macarrão cozido igualmente entre as tigelas.
   - Despeje o caldo quente e aromático sobre o macarrão, garantindo que o macarrão esteja submerso.
   - Organize cuidadosamente os acompanhamentos por cima do macarrão e do caldo: fatias de porco (chashu), metades de ovo cozido, cebolinha picada e folhas de nori.
   - Adicione quaisquer outros acompanhamentos desejados.
   - Sirva o Ramen imediatamente, enquanto está bem quente, para desfrutar de todos os sabores e texturas.', 1, 'https://images.unsplash.com/photo-1591814468924-caf88d1232e1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'),
('Kimchi', 15, 4, 3, '1 cabeça de acelga, 1 xícara de sal grosso, 5-6 dentes de alho, 1-2 colheres de chá de gengibre, 1-2 colheres de chá de açúcar, 2-3 colheres de sopa de molho de peixe, 1-5 colheres de sopa de pimenta vermelha coreana, 200g de rabanete, 4 cebolinhas.', '1. **Preparar e Salgar a Acelga Chinesa (Napa Cabbage):**
   - Use 1 cabeça grande de acelga chinesa (Napa Cabbage). Corte-a em quartos no sentido do comprimento e depois em pedaços de aproximadamente 5 cm.
   - Em uma tigela grande e limpa, misture a acelga cortada com 1 xícara de sal grosso. Certifique-se de que todas as folhas estejam bem cobertas pelo sal.
   - Deixe a acelga descansar em temperatura ambiente por 2 horas, virando e misturando a cada 30 minutos. O sal irá extrair a umidade da acelga, amaciando-a.
   - Após o tempo de descanso, lave a acelga muito bem em água fria corrente (3-4 vezes) para remover todo o excesso de sal. Prove um pedaço para garantir que não esteja salgado demais.
   - Esprema delicadamente o excesso de água da acelga e reserve em uma peneira para escorrer completamente.
2. **Preparar a Pasta de Temperos (Kimchi Paste - Yangnyeom):**
   - No processador de alimentos, bata 5-6 dentes de alho, 1-2 colheres de chá de gengibre fresco ralado, 1-2 colheres de chá de açúcar e 2-3 colheres de sopa de molho de peixe (fish sauce) até obter uma pasta homogênea.
   - Transfira esta pasta para uma tigela grande. Adicione 1-5 colheres de sopa de pimenta vermelha coreana em flocos (gochugaru). A quantidade de gochugaru pode ser ajustada ao seu nível de picância preferido.
   - Corte 200g de rabanete (daikon) em tiras finas (julienne) e 4 cebolinhas verdes em pedaços de 2-3 cm. Adicione-os à pasta de temperos e misture bem.
3. **Misturar a Acelga com a Pasta de Temperos (Massagem):**
   - **Importante:** Use luvas de cozinha descartáveis para este passo, pois a pimenta pode irritar a pele.
   - Adicione a acelga escorrida à tigela com a pasta de temperos.
   - Esfregue e massageie a pasta em cada folha de acelga, garantindo que todas as partes estejam uniformemente cobertas. Este processo ajuda a infundir o sabor e a iniciar a fermentação.
4. **Fermentar o Kimchi (Desenvolvimento de Sabor e Probióticos):**
   - Pressione o kimchi firmemente em um pote de vidro grande e esterilizado, deixando um espaço de 3-4 cm no topo para permitir a expansão durante a fermentação.
   - Certifique-se de que o kimchi esteja submerso no próprio líquido que se formará. Se necessário, use um peso (como um saco plástico com água) para mantê-lo submerso.
   - Feche bem o pote (com uma tampa que permita a liberação de gases, se tiver) e deixe fermentar em temperatura ambiente (idealmente entre 18-22°C) por 1 a 5 dias.
   - Verifique o kimchi diariamente: pressione-o para baixo para liberar gases e garantir que esteja submerso. Prove um pedaço para verificar o sabor. Quando atingir o nível de acidez e sabor desejado, transfira o pote para a geladeira para retardar a fermentação.
5. **Servir:**
   - O Kimchi pode ser consumido imediatamente após a fermentação inicial ou guardado na geladeira por várias semanas (o sabor continuará a se desenvolver).
   - Sirva como acompanhamento para quase todas as refeições coreanas, ou como um condimento picante e probiótico.', 1, 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d1/Various_kimchi.jpg/767px-Various_kimchi.jpg'),
('Poutine', 16, 2, 2, '1 kg de batatas, óleo vegetal, sal, pimenta-do-reino, 2 colheres de sopa de manteiga, 2 colheres de sopa de farinha de trigo, 2 xícaras de caldo de carne, 600g de queijo coalho.', '1. **Preparar as Batatas Fritas (Fritura Dupla para Máxima Crocância):**
   - Descasque 1 kg de batatas (idealmente batatas tipo Russet ou Aster) e corte-as em palitos de aproximadamente 1 cm de espessura.
   - Lave os palitos de batata em água fria por alguns minutos para remover o excesso de amido. Seque-os completamente com um pano de prato limpo ou papel toalha. A secagem é crucial para a crocância.
   - Em uma panela funda ou fritadeira, aqueça óleo vegetal (girassol, canola ou amendoim) a 160°C.
   - Frite as batatas em lotes (sem superlotar a panela) por 5-7 minutos na primeira fritura. Elas devem cozinhar por dentro, mas não devem dourar. Retire as batatas e escorra-as em papel toalha. Deixe-as esfriar completamente. Este é o processo de "branqueamento".
   - Pouco antes de montar o poutine, aumente a temperatura do óleo para 190°C. Frite as batatas pré-cozinhas novamente em lotes por 2-4 minutos, ou até ficarem douradas e extremamente crocantes. Retire e escorra em papel toalha. Tempere com sal e pimenta-do-reino moída na hora.
2. **Preparar o Molho Gravy (Rico e Encorpado):**
   - Em uma panela média, derreta 2 colheres de sopa de manteiga em fogo médio.
   - Adicione 2 colheres de sopa de farinha de trigo e cozinhe, mexendo constantemente, por 1-2 minutos para formar um roux (pasta). O roux deve ter uma cor clara.
   - Aos poucos, adicione 2 xícaras de caldo de carne quente (caseiro ou de boa qualidade), mexendo vigorosamente com um fouet para evitar a formação de grumos.
   - Cozinhe em fogo baixo, mexendo ocasionalmente, até o molho engrossar e atingir a consistência desejada (deve cobrir as costas de uma colher). Isso levará cerca de 5-7 minutos.
   - Tempere o molho gravy com sal e pimenta-do-reino a gosto. Mantenha o molho quente.
3. **Montar o Poutine (Camadas de Sabor e Textura):**
   - Em uma tigela ou prato fundo individual, coloque uma porção generosa das batatas fritas quentes e crocantes.
   - Espalhe 600g de queijo coalho (cheese curds) por cima das batatas. É importante usar queijo coalho fresco, que range ao morder e derrete levemente com o calor do molho.
   - Regue tudo generosamente com o molho gravy bem quente. O calor do molho fará com que o queijo coalho amoleça e derreta ligeiramente, criando a textura característica do poutine.
   - Sirva o Poutine imediatamente, enquanto as batatas estão crocantes, o queijo está macio e o molho está quente.', 1, 'https://i.vimeocdn.com/video/1115721912-3225ca53224a8c9f53dd2d934b38323053c63b211a62105895523f013b642a99-d_640x360'),
('Guacamole', 6, 4, 3, '2-3 abacates maduros, 0.5 cebola roxa, 1-2 tomates, 0.25 xícara de coentro, 1-2 pimentas jalapeño, suco de 1-2 limões, sal, pimenta do reino.', '1. **Preparar e Picar os Ingredientes Frescos:**
   - Pique finamente ½ cebola roxa.
   - Corte 1-2 tomates maduros ao meio, remova as sementes e o excesso de líquido, e pique-os em cubos pequenos.
   - Pique finamente ¼ xícara de coentro fresco.
   - Para 1-2 pimentas jalapeño, remova as sementes e as nervuras brancas (para menos picância) e pique-as finamente. Se preferir mais picante, deixe algumas sementes.
2. **Amassar os Abacates (Textura Ideal):**
   - Escolha 2-3 abacates maduros (mas firmes). Corte-os ao meio, remova o caroço e retire a polpa com uma colher.
   - Em uma tigela média, amasse a polpa dos abacates com um garfo. Amasse até obter a consistência desejada – alguns preferem um guacamole mais liso, outros com pedaços maiores para dar textura.
3. **Combinar e Temperar (Equilíbrio de Sabores):**
   - Adicione a cebola roxa picada, os tomates picados, o coentro fresco picado e a pimenta jalapeño picada à tigela com o abacate amassado.
   - Esprema o suco de 1-2 limões frescos sobre a mistura. O suco de limão não só adiciona um sabor cítrico vibrante, mas também ajuda a prevenir a oxidação do abacate, mantendo o guacamole verde por mais tempo.
   - Tempere generosamente com sal (cerca de ½ a 1 colher de chá) e pimenta-do-reino moída na hora a gosto.
   - Misture delicadamente todos os ingredientes com uma colher ou espátula, apenas o suficiente para combinar, sem amassar demais.
4. **Provar e Ajustar (Toque Final):**
   - Prove o guacamole e ajuste os temperos conforme sua preferência. Você pode adicionar mais sal, limão, pimenta ou coentro.
   - **Dica para Armazenamento:** Se não for servir imediatamente, cubra o guacamole com plástico filme, pressionando o filme diretamente sobre a superfície do guacamole para evitar o contato com o ar. Isso minimiza a oxidação.
5. **Servir (Acompanhamento Perfeito):**
   - Sirva o Guacamole imediatamente com tortilhas de milho (nachos), tacos, burritos, ou como acompanhamento para carnes grelhadas.', 1, 'https://images.unsplash.com/photo-1534973600-877700000000?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80'),
('Ceviche', 17, 1, 5, '500g de peixe branco fresco, suco de 4-6 limões, 0.5 cebola roxa, 1 pimenta dedo-de-moça, 0.25 xícara de coentro, 1 tomate, sal, pimenta-do-reino.', '1. **Preparar o Peixe Fresco (Corte e Qualidade):**
   - Utilize 500g de peixe branco fresco e de alta qualidade (tilápia, linguado, robalo ou corvina são excelentes opções). É crucial que o peixe seja o mais fresco possível, pois ele será "cozido" apenas pelo ácido do limão.
   - Corte o filé de peixe em cubos uniformes de aproximadamente 1,5 cm. Isso garante que o peixe "cozinhe" por igual e rapidamente.
   - Coloque os cubos de peixe em uma tigela de vidro ou cerâmica.
2. **Picar e Preparar os Aromáticos:**
   - Fatie ½ cebola roxa em tiras bem finas (julienne). Para reduzir a acidez, você pode deixá-la de molho em água gelada por 10 minutos e depois escorrer bem.
   - Pique 1 pimenta dedo-de-moça (ou aji amarillo, se disponível) finamente. Remova as sementes e as nervuras brancas para controlar o nível de picância.
   - Pique ¼ xícara de coentro fresco.
   - Corte 1 tomate maduro ao meio, remova as sementes e o excesso de líquido, e pique-o em cubos pequenos.
3. **Marinar o Peixe (O "Cozimento" Cítrico):**
   - Na tigela com o peixe, adicione a cebola roxa fatiada e a pimenta picada.
   - Tempere com sal (cerca de 1 colher de chá) e pimenta-do-reino moída na hora a gosto.
   - Despeje o suco fresco de 4-6 limões (ou limas) sobre a mistura, garantindo que todo o peixe esteja completamente submerso no líquido. O ácido cítrico do limão irá desnaturar as proteínas do peixe, "cozinhando-o" quimicamente.
   - Misture delicadamente e leve à geladeira para marinar por 30 a 60 minutos. O tempo de marinada pode variar: para um peixe mais "cru" e translúcido, 30 minutos são suficientes; para um peixe mais "cozido" e opaco, deixe por 60 minutos. Evite marinar por tempo excessivo, pois o peixe pode ficar borrachudo.
4. **Finalizar o Ceviche (Leche de Tigre e Frescor):**
   - Após a marinada, escorra o excesso de suco de limão (este líquido é conhecido como "leche de tigre" e pode ser servido à parte ou descartado).
   - Adicione o tomate picado e o coentro fresco picado ao peixe marinado.
   - Misture delicadamente para combinar todos os ingredientes.
5. **Servir (Experiência Completa):**
   - Sirva o ceviche imediatamente em taças ou pratos fundos.
   - Tradicionalmente, é acompanhado de batata-doce cozida em rodelas, milho cozido (choclo) ou chips de banana (chifles).', 1, 'https://upload.wikimedia.org/wikipedia/commons/a/a7/Ceviche_de_corvina.jpg'),
('Koshari', 18, 2, 1, '1 xícara de arroz, 1 xícara de lentilhas, 1-2 xícaras de macarrão pequeno, 1 lata de grão-de-bico, 2 cebolas, azeite, caldo de legumes, 1 dente de alho, cominho, 1-2 latas de molho de tomate, pimenta, vinagre.', '1. **Cozinhar os Componentes Separadamente (Base do Koshari):**
   - **Arroz:** Cozinhe 1 xícara de arroz (preferencialmente arroz egípcio ou arroz de grão curto) conforme as instruções da embalagem. Geralmente, 1 parte de arroz para 1.5-2 partes de água, com uma pitada de sal. Mantenha aquecido.
   - **Lentilhas:** Lave 1 xícara de lentilhas marrons. Cozinhe em água fervente com uma pitada de sal por 20-30 minutos, ou até ficarem macias, mas ainda firmes. Escorra e reserve.
   - **Macarrão:** Cozinhe 1-2 xícaras de macarrão pequeno (cotovelinho, argolinha ou cabelo de anjo quebrado) em água fervente salgada até ficar al dente. Escorra e reserve.
   - **Grão-de-bico:** Se estiver usando grão-de-bico seco, deixe de molho durante a noite e cozinhe até ficar macio. Se for enlatado, escorra e enxágue 1 lata de grão-de-bico. Mantenha todos os componentes aquecidos.
2. **Fritar as Cebolas Crocantes (Topping Essencial):**
   - Fatie 2 cebolas grandes finamente em rodelas ou meias-luas.
   - Em uma panela funda, aqueça uma quantidade generosa de azeite (o suficiente para cobrir as cebolas) em fogo médio-alto.
   - Frite as cebolas em lotes, mexendo ocasionalmente, até ficarem bem douradas e crocantes. Este processo pode levar 10-15 minutos por lote.
   - Retire as cebolas fritas com uma escumadeira e escorra-as em papel toalha para remover o excesso de óleo. Tempere com uma pitada de sal. Reserve.
3. **Preparar o Molho de Tomate (Sabor e Especiarias):**
   - Na mesma panela onde fritou as cebolas (se desejar, use um pouco do óleo aromatizado), refogue 1 dente de alho picado em 1-2 colheres de sopa de azeite.
   - Adicione 1-2 latas de molho de tomate (ou tomate pelado amassado), 1 colher de chá de cominho em pó, sal e pimenta-do-reino a gosto.
   - Cozinhe em fogo baixo por 10-15 minutos, mexendo ocasionalmente, para que os sabores se desenvolvam.
   - **Molho Picante (Opcional):** Para um toque extra, você pode preparar um molho picante à parte, misturando um pouco do molho de tomate com pimenta vermelha em flocos ou pimenta caiena.
   - **Molho de Vinagre de Alho (Opcional - Dukkah):** Em uma tigela pequena, misture 2 colheres de sopa de vinagre branco, 1 dente de alho picado e uma pitada de cominho.
4. **Montar o Prato (Camadas Tradicionais):**
   - Em um prato fundo ou tigela grande, monte o Koshari em camadas, começando pela base:
     - Uma camada de arroz cozido.
     - Uma camada de lentilhas cozidas.
     - Uma camada de macarrão cozido.
     - Uma porção de grão-de-bico.
   - Regue generosamente com o molho de tomate quente.
   - Finalize com uma boa quantidade das cebolas fritas crocantes por cima.
   - Sirva o Koshari quente, acompanhado dos molhos picante e de vinagre de alho (se preparados) para que cada um adicione a gosto.', 1, 'https://upload.wikimedia.org/wikipedia/commons/4/49/Egyptian_Koshari.jpg'),
('Hummus', 19, 4, 3, '1.5-2 xícaras de grão-de-bico cozido, 0.3-0.5 xícara de tahini, 2-4 colheres de sopa de azeite, 2-3 dentes de alho, suco de 1 limão, 0.5-1 colher de chá de sal, 5 colheres de sopa de água.', '1. **Preparar o Grão-de-Bico (Base Essencial):**
   - Utilize 1.5-2 xícaras de grão-de-bico cozido. Se estiver usando grão-de-bico seco, deixe de molho durante a noite e cozinhe até ficar bem macio. Se for enlatado, escorra, enxágue bem e, para um hummus mais cremoso, remova as cascas de cada grão (opcional, mas faz diferença na textura). Reserve alguns grãos inteiros para decorar.
2. **Processar os Ingredientes Principais (Primeira Etapa):**
   - Em um processador de alimentos potente, combine o grão-de-bico cozido e descascado (se aplicável), 0.3-0.5 xícara de tahini (pasta de gergelim de boa qualidade), 2-4 colheres de sopa de azeite de oliva extravirgem, 2-3 dentes de alho descascados, o suco fresco de 1 limão grande e 0.5-1 colher de chá de sal.
   - Processe todos esses ingredientes até obter uma pasta grossa e homogênea. Raspe as laterais do processador conforme necessário.
3. **Atingir a Cremosidade Perfeita (Adição Gradual de Água Gelada):**
   - Com o processador ainda ligado, adicione 5 colheres de sopa de água gelada, uma colher de sopa de cada vez.
   - Continue processando até que o hummus atinja a consistência desejada: lisa, cremosa e aerada. A água gelada ajuda a clarear a cor e a deixar o hummus mais fofo.
4. **Ajustar o Tempero (Equilíbrio Final):**
   - Prove o hummus e ajuste os temperos conforme sua preferência. Você pode adicionar mais sal, suco de limão para acidez, ou alho para um sabor mais intenso. Se desejar um toque extra de azeite, adicione agora.
5. **Servir e Decorar (Apresentação Tradicional):**
   - Transfira o hummus para uma tigela rasa de servir.
   - Com as costas de uma colher, crie um redemoinho na superfície do hummus.
   - Regue generosamente com um fio de azeite de oliva extravirgem de boa qualidade.
   - Decore com os grãos-de-bico inteiros reservados, uma pitada de páprica doce (ou picante) e, opcionalmente, um pouco de salsinha fresca picada.
   - Sirva imediatamente com pão pita quente, vegetais frescos cortados (cenoura, pepino, aipo) ou como acompanhamento para pratos do Oriente Médio.', 1, 'https://via.placeholder.com/250x250?text=Imagem+Nao+Encontrada');